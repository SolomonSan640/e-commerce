<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurrencyPoint extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "currency_id",
        "point",
        "amount",
        "status",
        "created_by",
        "updated_by",
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
