<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReleaseVersion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'number',
        'file_path',
        'published_at',
        'force_update',
        'is_release',
        'status'
    ];
}
