<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeviceToken extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'device_id',
        'device_token',
        'created_by',
        'updated_by',
    ];


    public function notificationDevices(){
        return $this->hasMany(NotificationDevice::class);
    }
}
