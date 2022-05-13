<?php

namespace App\Repositories;

use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;

class CategoryRepository
{
    public function __construct()
    {
        //
    }

    public function insert($data)
    {
        $category = new Category();
        $category->category_name    = $data['category'];
        $category->description      = $data['desc'];
        $category->save();
        return true;
    }

    public function getCategoryList()
    {
        $data = Category::select('id','category_name','status');
            
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<a href="'.route('admin.category.edit',['id' => $row->id]).'" title="Edit" class="btn btn-primary" style="background:green;"><i class="fas fa-pencil-alt "></i></a>
                                <a data-href="'.route('admin.category.delete',['id' => $row->id]).'" title="Delete" class="btn btn-danger delete" ><i class="fas fa-trash-alt "></i></a>';
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
                            <a  data-href="'.route('admin.category.status-change',['id' => $row->id , 'status' =>$row->status]).'" class="status-change">
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
        return Category::findOrFail($id);
    }

    public function update($data,$id)
    {
        $category = Category::find($id);
        $category->category_name    = $data['category'];
        $category->description      = $data['desc'];
        $category->save();
        return true;
    }

    public function statusChange($id,$status)
    {
        $category = Category::find($id);
        $new_status = $status=='1' ? '0' : '1';
        $category->status = $new_status;
        $category->save();
        return $id;
    }

    public function destroy($id)
    {
        return Category::find($id)->delete();
    }
}
