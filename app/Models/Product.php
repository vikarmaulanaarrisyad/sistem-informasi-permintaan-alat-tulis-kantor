<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'unit_id', 'id');
    }

    public function category_product()
    {
        return $this->belongsToMany(Category::class, 'category_product',  'product_id')->withTimestamps();
    }

    public function permintaan_barang()
    {
        return $this->belongsTo(Submission::class, 'id','product_id');
    }
}
