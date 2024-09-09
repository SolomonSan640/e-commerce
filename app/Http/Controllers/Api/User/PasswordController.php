<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\SmsVerification;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class PasswordController extends Controller
{
    public function change(Request $request)
    {
        // $request->validate([
        //     'old_password' => 'required',
        //     'password' => [
        //         'required',
        //         Password::min(8)
        //             ->letters()
        //             ->numbers()
        //             ->mixedCase()
        //             ->symbols(),
        //     ],
        //     'confirm_password' => 'same:password',
        // ]);

        $userId = Auth::user()->id;
        $user = User::where('id', $userId)->first();

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['status' => false, 'message' => 'The old password is incorrect.'], 200);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['status' => true, 'message' => 'Password changed successfully.'], 200);

    }

    public function forgot(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'phone' => 'required'
        // ]);

        // if ($validator->fails()) {
        //     return $validator->errors()->toJson();
        // }

        $phone = $request->phone;

        $user = User::where('phone', $phone)->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found.'], 404);
        }

        $verificationCode = mt_rand(100000, 999999);
        $time = Carbon::now();

        SmsVerification::create([
            'user_id' => $user->id,
            'phone' => $phone,
            'code' => $verificationCode,
            'created_at' => $time,
        ]);

        // Send the verification code via SMS
        $this->sendVerificationSms($phone, $verificationCode);

        return response()->json(['status' => true, 'message' => 'Verification code sent.'], 200);
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
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function verifyPasswordSms(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:6',
        ]);

        if ($validator->fails()) {
            return $validator->errors()->toJson();
        }

        $smsVerification = SmsVerification::where('phone', $request->phone)
            ->latest()
            ->first();

        if (!$smsVerification) {
            return response()->json(['status' => false, 'message' => 'Phone Number Not Found'], 422);
        }

        $currentTime = Carbon::now();
        $otpCreationTime = $smsVerification->created_at;

        $expirationTime = $otpCreationTime->copy()->addMinute();

        if ($currentTime->greaterThan($expirationTime)) {
            return response()->json(['status' => false, 'message' => 'OTP has expired'], 403);
        }

        if ($smsVerification && $smsVerification->code === $request->code) {
            $smsVerification->update(['status' => 1]);

            return response()->json(['status' => true, 'message' => 'Verified'], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Not Verified'], 422);
        }
    }

    public function resetPassword(Request $request)
    {
        // Validate the request
        // $request->validate([
        //     'new_password' => 'required|min:8'
        // ]);

        // $request->validate([
        //     'new_password' => [
        //         'required',
        //         Password::min(8)
        //             ->letters()
        //             ->numbers()
        //             ->mixedCase()
        //             ->symbols(),
        //     ],
        //     'confirm_password' => 'same:new_password',
        // ]);

        $phone = $request->phone;
        $user = User::where('phone', $phone)->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found.'], 404);
        }

        $checkVerify = SMSVerification::where('phone', $request->phone)->latest()->first();
        if ($checkVerify->status != 1) {
            return response()->json(['status' => false, 'message' => 'User not verified yet.'], 404);
        }

        if ($user->password != $request->password) {

            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json(['status' => true, 'message' => 'Password changed successfully.'], 200);
        }
    }

    public function resendOTP(Request $request)
    {
        $phone = $request->phone;

        $user = User::where('phone', $phone)->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found.'], 404);
        }

        $verificationCode = mt_rand(100000, 999999);

        SmsVerification::create([
            'user_id' => $user->id,
            'phone' => $phone,
            'code' => $verificationCode,
            'created_at' => Carbon::Now(),
        ]);

        // Send the verification code via SMS
        $this->sendVerificationSms($phone, $verificationCode);

        return response()->json(['status' => true, 'message' => 'Verification code sent.'], 200);
    }
}
