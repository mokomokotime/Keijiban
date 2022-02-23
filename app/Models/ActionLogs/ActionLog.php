<?php

namespace App\Models\ActionLogs;

use Illuminate\Database\Eloquent\Model;

class ActionLog extends Model
{
    protected $table = 'action_logs';

    protected $fillable = [
        'user_id',
        'post_id',
        'event_at',
    ];
}
