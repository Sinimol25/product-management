<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    protected $fillable  = [
        'customer_id','product_id','quantity'
    ];

    public function getProduct()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function getCustomer()
    {
        return $this->belongsTo(CustomerDetails::class,'customer_id');
    }
}
