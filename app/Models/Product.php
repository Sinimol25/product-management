<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'category_id','product_name','price'
    ];

    public function getCategory()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
}
