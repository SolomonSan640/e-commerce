<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "name",
        "iso2",
        "iso3",
        "currency",
        "callcode",
        "flag",
        "description",
        "remark",
        "is_show",
        "created_by",
        "updated_by",
        "status",
    ];
}
