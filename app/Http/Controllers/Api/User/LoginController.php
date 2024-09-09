<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class LoginController extends Controller
{
    public function timezone()
    {

    }

    public function login(Request $request)
    {

        $validator = $this->validateLoginData($request);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // $this->setLocale(strtolower('en'));
        App::setLocale('en');
        $credentials = $request->only('phone', 'password');
        $users = User::where('phone', $credentials['phone'])->first();

        if ($users && Hash::check($credentials['password'], $users->password)) {
            $token = $users->createToken('Token Name')->plainTextToken;
            $users['token'] = $token;

            return response()->json([
                'status' => true,
                'message' => __('success.loginSuccess'),
                'data' => $users,
            ], 200);

        } else {
            return response()->json([
                'status' => false,
                'message' => __('error.loginFailed'),
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        // $this->setLocale(strtolower($request->country));
        $request->user()->tokens()->delete();
        return response()->json(['status'=> true,'message' => __('success.logout')]);
    }

    protected function validateLoginData(Request $request)
    {
        return Validator::make($request->all(), [
            // 'phone' => 'required',
            // 'password' => [
            //     'required',
            //     Password::min(8)
            //         ->letters()
            //         ->numbers()
            //         ->mixedCase()
            //         ->symbols(),
            // ],
        ]);
    }

    protected function checkPasswordValidation($request)
    {
        $rules = [
            'old_password' => 'required|min:6',
            'new_password' => [
                'required',
                Password::min(6)
                    ->letters()
                    ->numbers()
                    ->mixedCase()
                    ->symbols(),
            ],
            'new_password_confirm' => 'required|same:new_password',
        ];
        // $messages = [
        //     'oldPassword.required' => "Old Password must be filled.",
        //     'newPassword.required' => "New Password must be Filled.",
        //     'newPassword.min' => 'The password must be at least :min characters long and must contain at least one letter, one number, one capitalized letter, and one special character.',
        //     'newPasswordConfirm.required' => "New Password Confirmation must be Filled.",
        // ];
        Validator::make($request->all(), $rules)->validate();
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

    public function checkUser()
    {
        app()->setLocale('en');

        $user = Auth::guard('user')->user();
        if (!$user) {
            $response = [
                'status' => false,
                'message' => __('error.dataNotFound'),
                'data' => [],
            ];
            return response()->json($response, 422);
        }

        $userId = $user->id;
        $users = User::where('id', $userId)->orderBy('updated_at', 'desc')->first();
        $response = [
            'status' => true,
            'message' => __('success.dataRetrieved'),
            'data' => $users
        ];
        return response()->json($response, 200);
    }
}
