<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $primaryKey = 'receipt_id';
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'invoice_number',
        'vat_amount',
        'vat_exempt_sales',
        'zero_rated_sales',
        'cash_tendered',
        'change_amount',
        'date_created',
    ];

    protected $casts = [
        'date_created' => 'datetime',
        'vat_amount' => 'decimal:2',
        'vat_exempt_sales' => 'decimal:2',
        'zero_rated_sales' => 'decimal:2',
        'cash_tendered' => 'decimal:2',
        'change_amount' => 'decimal:2',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}
