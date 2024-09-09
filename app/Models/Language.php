<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Language extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "name",
        "is_show",
        "created_by",
        "updated_by",
        "status",
    ];
}
