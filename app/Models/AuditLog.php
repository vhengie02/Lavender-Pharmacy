<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $primaryKey = 'log_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'action_performed',
        'table_name',
        'record_id',
        'old_value',
        'new_value',
        'ip_address',
        'user_agent',
        'date_logged',
    ];

    protected $casts = [
        'date_logged' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
