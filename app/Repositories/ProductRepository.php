<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;

class ProductRepository
{
    public function __construct()
    {
        //
    }

    public function getCategory()
    {
        return Category::select('id','category_name','status')->where('status','=','1')->withTrashed()->get();
    }

    public function insert($data)
    {
        $product = new Product();
        $product->product_name    = $data['product_name'];
        $product->price           = $data['price'];
        $product->category_id     = $data['category'];
        $product->description     = $data['desc'];
        if(isset($data['image'])){
            $imageName = time().'.'.$data['image']->getClientOriginalExtension();  
            $product->image = $imageName ;
           $data['image']->storeAs('public/images/', $imageName);
        }
        else{ 
            $product->image = '' ;
        }
        $product->save();
        return true;
    }

    public function getProductList()
    {
        $data = Product::with('getCategory')->get();
            
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<a href="'.route('admin.product.edit',['id' => $row->id]).'" title="Edit" class="btn btn-primary" style="background:green;"><i class="fas fa-pencil-alt "></i></a>
                <a data-href="'.route('admin.product.delete',['id' => $row->id]).'" title="Delete" class="btn btn-danger delete" ><i class="fas fa-trash-alt "></i></a>';
                return $actionBtn;
            })
           
            ->addColumn('status', function($row){
                
                if($row->status==1)
                {
                    $val="checked";
                }
                else{
                    $val="";
                }
                $statusBtn = '<div class="form-group" data-id="'.$row->id.'">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <a  class="status-change" data-href="'.route('admin.product.status-change',['id' => $row->id, 'status' =>$row->status]).'">
                                <input type="checkbox" class="custom-control-input"'.$val.' disabled>
                                <label class="custom-control-label " for="customSwitch3"></label></a>
                                </div>
                            </div>';
            return $statusBtn;
            })
            ->rawColumns(['action','status'])
            ->make(true);
    }

    public function getData($id)
    {
        return Product::findOrFail($id);
    }

    public function update($data,$id)
    {
        $product = Product::find($id);
        $product->product_name    = $data['product_name'];
        $product->price           = $data['price'];
        $product->category_id     = $data['category'];
        $product->description     = $data['desc'];
        if(isset($data['image'])){
            $imageName = time().'.'.$data['image']->getClientOriginalExtension();  
            $product->image = $imageName ;
           $data['image']->storeAs('public/images/', $imageName);
        }
        $product->save();
        return true;
    }

    public function statusChange($id,$status)
    {
        $product = Product::find($id);
        $new_status = $status=='1' ? '0' : '1';
        $product->status = $new_status;
        $product->save();
        return $id;
    }

    public function destroy($id)
    {
        return Product::find($id)->delete();
    }
}
