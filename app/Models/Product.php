<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'product_id';
    public $timestamps = false;

    protected $fillable = [
        'product_name',
        'generic_name',
        'brand_name',
        'category_id',
        'description',
        'dosage_info',
        'price',
        'stock_quantity',
        'expiration_date',
        'manufacturer',
        'barcode',
        'product_image',
        'prescription_required',
        'date_added',
        'date_updated',
    ];

    protected $casts = [
        'date_added' => 'datetime',
        'date_updated' => 'datetime',
        'expiration_date' => 'date',
        'prescription_required' => 'boolean',
        'price' => 'decimal:2',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class, 'product_id', 'product_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'product_id');
    }

    public function inventoryLogs()
    {
        return $this->hasMany(InventoryLog::class, 'product_id', 'product_id');
    }
}
