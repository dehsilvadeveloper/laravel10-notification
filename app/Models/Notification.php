<?php

namespace App\Models;

use App\Enums\NotificationCategoryEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $primaryKey = 'id';
    protected $fillable = [
        'recipient_id',
        'content',
        'category',
        'read_at',
        'canceled_at'
    ];
    protected $casts = [
        'category' => NotificationCategoryEnum::class,
        'read_at' => 'datetime:Y-m-d H:i:s',
        'canceled_at' => 'datetime:Y-m-d H:i:s'
    ];
}
