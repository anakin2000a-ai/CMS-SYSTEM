<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification_campaign extends Model
{
     protected $fillable = [
        'title',
        'body',
        'link',
        'image_url',
        'type',
        'status',
        'target_categories',
        'recipients_count',
        'delivered_count',
        'opened_count',
        'clicked_count',
        'scheduled_at',
        'sent_at',
    ];
}
