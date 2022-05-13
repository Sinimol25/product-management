<?php

namespace App\Repositories;

use App\Models\OrderDetails;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardRepository
{
    public function __construct()
    {
        //
    }

    public function getProduct()
    {
        return $product = Product::count('id');
    }

    public function getOrder()
    {
        return OrderDetails::select(DB::raw('count(id) as cnt'))->groupBy('customer_id')->first();

    }
}
