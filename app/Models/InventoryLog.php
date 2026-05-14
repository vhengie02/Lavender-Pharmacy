<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    protected $primaryKey = 'log_id';
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'quantity_changed',
        'action_type',
        'previous_quantity',
        'new_quantity',
        'notes',
        'date_logged',
    ];

    protected $casts = [
        'date_logged' => 'datetime',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
