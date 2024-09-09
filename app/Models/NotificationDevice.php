<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationDevice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'device_id',
        'notification_id',
        'is_read',
        'status'
    ];

    public function device()
    {
        return $this->belongsTo(DeviceToken::class);
    }

    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }
}
