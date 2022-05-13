<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Repositories\OrderRepository;
use PDF;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public $orderRepo;
    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function index()
    {
        $data = $this->orderRepo->getOrderList();
        return view('admin.order.index',compact('data'));
    }

    public function create($id)
    {
        $data = $this->orderRepo->getUser($id);
        $product = $this->orderRepo->getProduct();
        $allPro = $this->orderRepo->addedProduct($id);
        return view('admin.order.create',compact('data','product','allPro'));
    }

    public function store(OrderRequest $request)
    {
        $user_id    = $this->orderRepo->store($request->all());
        //dd($user_id);
        return redirect()->route('admin.order.create',$user_id);
    }

    public function storeProduct(Request $request,$id)
    {
        //  dd($request->all());
        $data = $this->orderRepo->ProductStore($request->all(),$id);
        $url_delete =  route("admin.order.delete-product",$data['product_id']);
        $url_edit   =  route("admin.order.edit-product",$data['id']);
        //dd($data);
        if (!$data) {
            return response()->json(['status'=>'0','message'=>'Product not added']);
        }
            return response()->json(['status'=>'1','message'=>'Successfully added the product','product' => $data, 'url_edit' => $url_edit , 'url_delete' => $url_delete]);
    }

    public function deleteProduct(Request $request,$id)
    {
       // dd($id);
        try {

            $product = $this->orderRepo->destroyOrder($id,$request->all());
            // dd($question);
            $url_delete = 'route("admin.order.delete-product")';
            $url_edit   =  'route("admin.order.edit-product")';
            if(! $product)
            {
                return response()->json(['status'=>'0','message'=>'Order not found']);

            }
            return response()->json(['status'=>'1','message'=>'Product deleted successfully','product' =>$product ,'edit' => $url_edit , 'delete' => $url_delete]);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function editProduct(Request $request,$id)
    {
        try {

            $product = $this->orderRepo->editProducts($id,$request->all());
            $route = route('admin.order.update-product',$product['id']);
            if(! $product)
            {
                return response()->json(['status'=>'0','message'=>'Product not found']);

            }
            return response()->json(['status'=>'1','product' =>$product ,'route' => $route]);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function updateProduct(Request $request,$id)
    {
       // dd($request->all());
        $data = $this->orderRepo->updateProduct($request->all(),$id);
        if (!$data) {
            return response()->json(['status'=>'0','message'=>'Product not added']);
        }
            return response()->json(['status'=>'1','message'=>'Successfully updated the product']);
    }

    public function listProduct(Request $request)
    {
        // dd('in');
        if ($request->ajax()) 
        {
            $data = $this->orderRepo->getOrderList();
            return $data;
        }
    }

    public function deleteOrder($id)
    {
        try {

            $order = $this->orderRepo->destroy($id);
            if(! $order)
            {
                return response()->json(['status'=>'0','message'=>'Order not found']);

            }
            return response()->json(['status'=>'1','message'=>'Order deleted successfully']);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function view($id)
    {
        try {

            $user = $this->orderRepo->editUser($id);
            $route = route('admin.order.update',$user['id']);
            if(! $user)
            {
                return response()->json(['status'=>'0','message'=>'User not found']);

            }
            return response()->json(['status'=>'1','user' =>$user ,'route' => $route]);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function update(Request $request,$id)
    {
        $data = $this->orderRepo->updateUser($request->all(),$id);
        if (!$data) {
            return response()->json(['status'=>'0','message'=>'Customer not added']);
        }
            return response()->json(['status'=>'1','message'=>'Successfully updated']);
    }

    public function downloadInvoice($id)
    {
        $custData = $this->orderRepo->downloadData($id);
        $products = $this->orderRepo->productDetails($id);
        $total = $this->orderRepo->getTotal($id);
        $pdf = PDF::loadView('admin.order.samplePdf', ['data' => $custData , 'product' => $products , 'total' => $total])->setOptions(['defaultFont' => 'sans-serif']);
        //$pdf->stream("admin.order.samplePdf", array("Attachment" => false));
       // exit;
        return $pdf->download('order_details.pdf');
    }

}
