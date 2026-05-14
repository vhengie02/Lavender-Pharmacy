<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'category_id';
    public $timestamps = false;

    protected $fillable = [
        'category_name',
        'description',
        'date_created',
    ];

    protected $casts = [
        'date_created' => 'datetime',
    ];

    // Relationships
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }
}
