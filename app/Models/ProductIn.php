<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductIn extends Model
{
    use HasFactory;

    protected $table = 'product_in';

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
