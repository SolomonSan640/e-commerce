<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\DeviceToken;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class DeviceController extends Controller
{
    //
    protected function validateCreateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'device_token' => [
                'required',
                'string',
                // Rule::unique('device_tokens')->whereNull('deleted_at')->ignore($id),
            ],
            'device_id'=>[
                'required',
            ]
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return null;
    }

    public function store(Request $request)
    {
        $validationResult = $this->validateCreateData($request, null);
        if ($validationResult !== null) {
            return $validationResult;
        }

        $user = auth()->user();
        $userId = $user ? $user->id : null;
        $deviceTokenQuery = DeviceToken::where('device_id', $request->device_id);

        if ($userId) {
            $deviceToken = DeviceToken::where('user_id', $userId)->first();

            if ($deviceToken) {
                $deviceToken->update([
                    'device_token' => $request->device_token,
                    'device_id' => $request->device_id,
                ]);
            } else {
                $deviceTokenQuery->update([
                    'user_id' => $userId,
                    'device_token' => $request->device_token,
                ]);
            }
        } else {
            $deviceTokenQuery->updateOrCreate([
                'device_id' => $request->device_id,
            ], [
                'device_token' => $request->device_token,
            ]);
        }

        return response()->json(['status' => true, 'message' => "Device token saved successfully!"], 201);
    }

}
