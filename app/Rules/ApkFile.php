<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;

class ApkFile implements Rule
{
    public function passes($attribute, $value)
    {
        if ($value instanceof UploadedFile) {
            $extension = $value->getClientOriginalExtension();
            return $extension === 'apk';
        }
        return false;
    }

    public function message()
    {
        return 'The :attribute must be a file of type: apk.';
    }
}
