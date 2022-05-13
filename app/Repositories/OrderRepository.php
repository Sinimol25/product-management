<?php

namespace App\Repositories;

use App\Models\CustomerDetails;
use App\Models\OrderDetails;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class OrderRepository
{
    public function __construct()
    {
        //
    }

    public function store($data)
    {
        $user = new CustomerDetails();
        $user->name     = $data['name'];
        $user->phone    = $data['phone'];
        $user->save();
        return $user->id;
    }

    public function getUser($id)
    {
        return CustomerDetails::find($id);
    }

    public function getProduct()
    {
        return Product::where('status','=','1')->get();
    }

    public function getAddedProduct($pid,$cid)
    {
        $dtls =  OrderDetails::where('customer_id',$cid)->where('product_id',$pid)->first();
        if(! $dtls)
        {
            return 0; //Add
        }
        else
        {
            return 1; //Remove
        }
    }

    public function addedProduct($id)
    {
        return OrderDetails::with('getProduct')->where('customer_id',$id)->get();
    }

    public function productStore($data,$id)
    {
        $order_id = $data['cust_id'].rand(10000,999999);
        $cust = CustomerDetails::find($data['cust_id']);
        $cust->invoice_no = $order_id;

        $pro = Product::find($id);
        
        $order  =new OrderDetails();
        $order->product_id = $id;
        $order->customer_id = $data['cust_id'];
        $order->quantity = $data['qty'];
        $order->net_amount = $data['qty']*$data['rate'];
        $order->product_name = $pro->product_name;
        $order->price = $pro->price;
        $final = $data['qty']*$data['rate'];
        $items = OrderProduct::where('customer_id',$data['cust_id'])->first();
        //dd($items);
        if($items!=null)
        {
            $total = $items->total;
            $product = OrderProduct::find($items->id);
            $items->total = $total + $final;
            $items->save();
        }
        else
        {
            $product = new OrderProduct();
            $product->customer_id = $data['cust_id'];
            $product->total = $final;
            $product->save();
        }
        $cust->save();
        $order->save();

        $id = $order->id;

        return OrderDetails::where('id',$id)->first();
    }

    public function destroyOrder($id,$data)
    {
        //dd($id);
        $cust_id = $data['customer_id'];
        $dtls =  OrderDetails::where('product_id',$id)->where('customer_id',$cust_id)->first();
        $dtls->delete();
        return OrderDetails::with('getProduct')->where('customer_id',$cust_id)->get();
    }

    public function editProducts($id,$data)
    {
        // return OrderDetails::with('getProduct')->where('id',$id)->where('customer_id',$data['custid'])->first();
        return OrderDetails::where('id',$id)->where('customer_id',$data['custid'])->first();

    }

    public function updateProduct($data,$id)
    {
        $order = OrderDetails::find($id);
        $order->quantity = $data['proqty'];
        $order->net_amount = $data['proqty']*$data['price'];

        // $items = OrderProduct::where('customer_id',$data['cust_id'])->first();
        // //dd($items);
        // if($items!=null)
        // {
        //     $total = $items->total;
        //     $product = OrderProduct::find($items->id);
        //     $items->total = $total + $final;
        //     $items->save();
        // }
        // else
        // {
        //     $product = new OrderProduct();
        //     $product->customer_id = $data['cust_id'];
        //     $product->total = $final;
        //     $product->save();
        // }
        $order->save();
        return $id;
    }

    public function getOrderList()
    {
        //with('getCustomer')
        $data = CustomerDetails::get();
                    // select('order_details.customer_id as customer_id',
                    //         DB::raw('sum(order_details.net_amount) as total'),
                    //         'order_details.created_at as order_date',
                    //         'customer_details.name as name',
                    //         'customer_details.phone as phone',
                    //         'customer_details.invoice_no as invoice_no',
                    //         'customer_details.id as id')
                    //         ->leftjoin('customer_details','customer_details.id','=','order_details.customer_id')
                    //         ->groupBy('order_details.customer_id')
                   
            //dd($data);
        /*return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<a data-href="'.route('admin.order.view',['id' => $row->id]).'" title="Edit Customer" class="btn btn-primary editUser" style="background:blue;"><i class="fas fa-user "></i></a>
                                <a href="'.route('admin.order.create',['id' => $row->id]).'" title="Edit" class="btn btn-primary" style="background:green;"><i class="fas fa-pencil-alt "></i></a>
                                <a data-href="'.route('admin.order.delete-order',['id' => $row->id]).'" title="Delete" class="btn btn-danger deleteUser" ><i class="fas fa-trash-alt "></i></a>
                                <a href="'.route('admin.order.download-invoice',['id' => $row->id]).'" title="Download Invoice" class="btn btn-success invoiceDowload" ><i class="fas fa-file "></i></a>';
                return $actionBtn;
            })
           
            ->rawColumns(['action'])
            ->make(true);*/
            return $data;
    }

    public function getTotal($cid)
    {
        return OrderDetails::select(DB::raw('sum(net_amount) as total'))->where('customer_id',$cid)->first();
    }

    public function destroy($id)
    {
       OrderDetails::where('customer_id',$id)->delete();
       return CustomerDetails::find($id)->delete();
    }

    public function editUser($id)
    {
        return CustomerDetails::find($id);
    }

    public function updateUser($data,$id)
    {
        $user = CustomerDetails::find($id);
        $user->name = $data['cname'];
        $user->phone = $data['cphone'];
        $user->save();
        return $id;
    }

    public function downloadData($id)
    {
        return CustomerDetails::where('id',$id)->first();
    }

    public function productDetails($id)
    {
        return OrderDetails::where('customer_id',$id)->get();
    }

}
