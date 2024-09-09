<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ImageUploadTrait
{
    public function singleImage($request, $imageName, $folderName)
    {

        if ($request->hasFile($imageName)) {
            $image = $request->file($imageName);
            $imageName = $image->getClientOriginalName();
            $image->store($folderName, 'public');

            $userId = Auth::id();
            $oldImage = User::where('id', $userId)->value('image');

            if ($oldImage != null) {
                Storage::disk('public')->delete($oldImage);
            }

            return $folderName . '/' . $image->hashName();
        }
        return null;
    }

    public function multipleImage($image, $imageName, $folderName)
    {
        if ($image->isValid()) {
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/' . $folderName), $imageName);
            return $folderName . '/' . $imageName;
        }
        return null;
    }

    // public function base64($request, $imageName, $folderName)
    // {
    //     $base64Image = $request->input('image');

    //     if ($base64Image) {
    //         if (strpos($base64Image, ';base64,') !== false) {
    //             list($meta, $base64Image) = explode(';base64,', $base64Image);
    //         }

    //         $image = base64_decode($base64Image);

    //         if ($image === false) {
    //             Log::error('Base64 decoding failed.');
    //             return response()->json(['status' => 400, 'message' => 'Invalid base64 string'], 400);
    //         }

    //         $imageName = Str::random(10) . '.png';
    //         $filePath = public_path('images/users/' . $imageName);

    //         if (file_put_contents($filePath, $image)) {
    //             $publicUrl = 'users/' . $imageName;
    //             return $publicUrl;
    //         } else {
    //             Log::error('Failed to store the image.', ['filePath' => $filePath]);
    //             return response()->json(['status' => 500, 'message' => 'Failed to store the image'], 500);
    //         }
    //     }

    //     return response()->json(['status' => 400, 'message' => 'No image     2pt'], 400);
    // }

    public function base64($request, $imageName, $folderName)
    {
        $base64Image = $request->image;

        $userId = Auth::id();
        $oldImage = User::where('id', $userId)->value('image');

        if ($base64Image || $base64Image = '') {

            if ($oldImage != null) {
                Storage::disk('public')->delete($oldImage);
            }

            if (strpos($base64Image, ';base64,') !== false) {
                list($meta, $base64Image) = explode(';base64,', $base64Image);
            } else {
                Log::warning('Base64 meta data not found.');
            }

            $image = base64_decode($base64Image);

            if ($image === false) {
                return null;
            }

            $imageName = Str::random(10) . '.png';
            $filePath = $folderName . '/' . $imageName;

            if (Storage::disk('public')->put($filePath, $image)) {
                return $filePath;
            } else {
                return null;
            }
        }

        return $oldImage;
    }

}
