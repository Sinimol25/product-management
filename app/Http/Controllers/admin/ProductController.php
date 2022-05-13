<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Repositories\ProductRepository;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public $proRepo;

    public function __construct(ProductRepository $proRepo)
    {
        $this->proRepo = $proRepo;
    }

    public function index()
    {
        return view('admin.product.index');
    }

    public function create()
    {
        $cats  = $this->proRepo->getCategory();
        return view('admin.product.create',compact('cats'));
    }

    public function store(ProductRequest $request)
    {
        try{
            $data = $this->proRepo->insert($request->all());
            if(! $data)
            {
                return response()->json(['status'=>'0','message'=>'Not Found']);

            }
            return response()->json(['status'=>'1','message'=>'Successfully Added']);

        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }

    public function listProduct(Request $request)
    {
        if ($request->ajax()) 
        {
            $data = $this->proRepo->getProductList();
            return $data;
        }
    }

    public function edit($id)
    {
        $data = $this->proRepo->getData($id);
        $cats  = $this->proRepo->getCategory();
        return view('admin.product.edit',compact('data','cats'));
    }

    public function update(ProductRequest $request ,$id)
    {
        try{
            $data = $this->proRepo->update($request->all(),$id);
            if(! $data)
            {
                return response()->json(['status'=>'0','message'=>'Not Found']);

            }
            return response()->json(['status'=>'1','message'=>'Successfully Updated']);

        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }

    public function changeStatus($id,$status)
    {
        try{
            $data = $this->proRepo->statusChange($id,$status);
            if(! $data)
            {
                return response()->json(['status'=>'0','message'=>'Not Found']);

            }
            return response()->json(['status'=>'1','message'=>'Successfully change the status']);

        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {

            $question = $this->proRepo->destroy($id);
            if(! $question)
            {
                return response()->json(['status'=>'0','message'=>'Exam not found']);

            }
            return response()->json(['status'=>'1','message'=>'Successfully deleted']);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
