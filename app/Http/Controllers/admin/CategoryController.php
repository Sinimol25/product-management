<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Repositories\CategoryRepository;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public $catRepo;

    public function __construct(CategoryRepository $catRepo)
    {
        $this->catRepo = $catRepo;
    }

    public function index()
    {
        return view('admin.category.index');
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(CategoryRequest $request)
    {
        try{
            $data = $this->catRepo->insert($request->all());
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

    public function listCategory(Request $request)
    {
        if ($request->ajax()) 
        {
            $data = $this->catRepo->getCategoryList();
            return $data;
        }
        
    }

    public function edit($id)
    {
        $data = $this->catRepo->getData($id);
        return view('admin.category.edit',compact('data'));
    }

    public function update(CategoryRequest $request ,$id)
    {
        try{
            $data = $this->catRepo->update($request->all(),$id);
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
            $data = $this->catRepo->statusChange($id,$status);
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

            $question = $this->catRepo->destroy($id);
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
