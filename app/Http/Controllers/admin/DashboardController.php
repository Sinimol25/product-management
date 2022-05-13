<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Repositories\DashboardRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public $dashRepo;

    public function __construct(DashboardRepository $dashRepo)
    {
        $this->dashRepo = $dashRepo;
    }
    public function index()
    {
        $product = $this->dashRepo->getProduct();
        $order = $this->dashRepo->getOrder();
        return view('admin.layout.content',compact('product','order'));
    }
}
