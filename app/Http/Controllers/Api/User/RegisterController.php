<?php

namespace App\Http\Controllers\Api\User;

use Throwable;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\SmsVerification;
use Illuminate\Validation\Rule;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    use ImageUploadTrait;
    public function index()
    {
        $this->setLocale(strtolower('en'));
        $userId = auth()->user()->id;
        $users = User::where('id', $userId)->select('id', 'customized_number', 'name', 'email', 'phone', 'gender', 'dob', 'address', 'qr_code', 'image')
            ->orderBy('updated_at', 'desc')->first();
        $response = [
            'status' => true,
            'message' => __('success.dataRetrieved'),
            'data' => $users,
        ];
        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        $this->setLocale(strtolower('en'));
        // $validationResult = $this->validateCreateData($request, null);
        // if ($validationResult !== null) {
        //     return $validationResult;
        // }
        try {
            $data = $this->getCreateData($request);
            $data->fill($data->toArray());
            $phone = $request->phone;

            $folderName = 'users';
            $imageFileName = $this->singleImage($request, 'image', $folderName); // use trait to upload image

            $data['image'] = $imageFileName;
            $data->save();

            $verificationCode = mt_rand(100000, 999999);
            SmsVerification::updateOrCreate([
                'user_id' => $data->id,
                'phone' => $request->phone,
                'code' => $verificationCode,
            ]);
            $this->sendVerificationSms($phone, $verificationCode);

            DB::commit();
            $response = [
                'status' => 201,
                'message' => __('success.dataCreated', ['attribute' => 'User']),
            ];
            return response()->json($response, 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            $response = [
                'status' => 400,
                'message' => __('success.dataCreatedFail', ['attribute' => 'User']),
            ];
            return response()->json($response, 400);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        // $decryptId = decrypt($id);
        $this->setLocale(strtolower('en'));
        $validationResult = $this->validateUpdateData($request, $id);
        // if ($validationResult !== null) {
        //     return $validationResult;
        // }
        try {
            $data = $this->getCreateData($request);
            $users = User::findOrFail($id);
            $users->fill($data->toArray());
            $folderName = 'users';
            // $imageFileName = $this->singleImage($request, 'image', $folderName); // use trait to upload image
            $imageFileName = $this->base64($request, 'image', $folderName);

            $users['image'] = $imageFileName;
            $data['image'] = $imageFileName;
            $users->update();
            DB::commit();

            $response = [
                'status' => true,
                'message' => __('success.dataUpdated', ['attribute' => 'User']),
                'data' => $data,
            ];
            return response()->json($response, 200);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            $response = [
                'status' => false,
                'message' => __('success.dataUpdatedFail', ['attribute' => 'User']),
            ];
            return response()->json($response, 400);
        }
    }

    protected function getCreateData(Request $request)
    {
        $data = [];

        $data['name'] = $request->name;
        $data['address'] = $request->address;
        $data['phone'] = $request->phone;
        $data['sec_phone'] = $request->sec_phone;
        $data['third_phone'] = $request->third_phone;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['gender'] = $request->gender;
        $data['dob'] = $request->dob;
        $data['customized_number'] = $this->generateUniqueCustomizedNumber();
        return new User($data);
    }

    protected function validateCreateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => [
                'required',
                Rule::unique('users')->whereNull('deleted_at')->ignore($id),
            ],
            'phone' => [
                'required',
                'regex:/^09\d{9}$/',
                Rule::unique('users')->whereNull('deleted_at')->ignore($id),
            ],
            'gender' => 'required',
            'address' => 'required',
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->mixedCase()
                    ->symbols(),
            ],
            'confirm_password' => 'same:password',

        ], [
            // 'name.required' => 'User name is required',
            // 'email.required' => 'email is required',
            // 'email.unique' => 'Email is already taken',
            // 'phone.unique' => 'Phone Number is already taken',
            // 'phone' => 'The phone format is invalid',
            // 'address' => 'The address is required',
            // 'passsword.required' => 'Password is required',
            // 'password.min' => 'Password must be at least 8',
            // 'confirm_password' => 'Confirm password must be the same as password',
            // 'gender' => 'Please choose your gender',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        return null;
    }

    protected function validateUpdateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'gender' => 'required',
            'phone' => [
                'required',
                'regex:/^09\d{9}$/',
                Rule::unique('users')->ignore($id)->whereNull('deleted_at'),
            ],
            'address' => 'required',
            'dob' => [
                'required',
            ],
        ], [
            // 'name.required' => 'User name is required',
            // 'email.required' => 'email is required',
            // 'email.unique' => 'Email is already taken',
            // 'phone.unique' => 'Phone Number is already taken',
            // 'phone' => 'The phone format is invalid',
            // 'address' => 'The address is required',
            // 'gender' => 'Please choose your gender',
            // 'dob' => '',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return null;
    }

    public function sendVerificationSms($phone, $verificationCode)
    {
        $apiUrl = env('SMSPOH_API_URL');
        $apiKey = env('SMSPOH_API_KEY');

        try {
            $client = new Client();
            $message = "Your Verfication Code: " . $verificationCode . "\n" . "Don't share it with anyone.";
            $response = $client->request('POST', $apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                ],
                'json' => [
                    'to' => $phone,
                    'message' => $message,
                    'sender' => "FreshMoe",
                ],
                'verify' => false,
            ]);
            $responseBody = json_decode($response->getBody(), true);
            return $responseBody;
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function verifySms(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:6',
        ]);

        // Find the SMS verification record
        $smsVerification = SmsVerification::where('phone', $request->phone)
            ->where('code', $request->code)
            ->first();

        if ($smsVerification) {
            $user = User::find($smsVerification->user_id);
            $user->update(['phone_verified_at' => now()]);
            $smsVerification->update(['is_verified' => true]);

            // Create token here
            $token = $user->createToken('User')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Verified',
                'token' => $token,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Not Verified',
            ], 400);
        }
    }

    public function generateQrCode($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $uniqueId = Uuid::uuid4()->toString();
        $user->update(['qr_code' => $uniqueId]);
        $data = [
            // 'user' => $user,
            'uniqueId' => $uniqueId,
        ];

        $response = [
            'status' => 200,
            'data' => $data,
        ];

        return response()->json($response, 200);
    }

    public function findUserByUniqueId(Request $request)
    {
        $user = User::where('qr_code', $request->qr_code)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json(['user' => $user], 200);
    }

    private function setLocale($country)
    {
        $supportedLocales = ['en', 'mm'];
        if (in_array($country, $supportedLocales)) {
            app()->setLocale($country);
        } else {
            app()->setLocale('en');
        }
    }

    private function generateUniqueCustomizedNumber()
    {
        do {
            $uniqueNumber = 'FMUN-' . time() . mt_rand(1000, 9999);
        } while (DB::table('users')->where('customized_number', $uniqueNumber)->exists());

        return $uniqueNumber;
    }
}
