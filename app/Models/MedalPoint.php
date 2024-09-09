<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedalPoint extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "medal_id",
        "point",
        "status",
        "created_by",
        "updated_by",
    ];

    public function medal()
    {
        return $this->belongsTo(Medal::class);
    }
}
