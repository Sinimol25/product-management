@extends('admin.layout.index')
@section('content')
<div class="content-wrapper">
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{route('admin.product.list')}}">Product</a></li>
              <li class="breadcrumb-item active">Edit Product</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Update Product</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="productForm" method="post" data-action=" {{route('admin.product.update',$data->id)}}" name="productForm" data-url="{{route('admin.product.list')}}">
                  @csrf
                <div class="card-body">
                <div class="row type1 ">
                <!-- left column -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Product Name *</label>
                    <input type="text" name="product_name" class="form-control" id="product_name" placeholder="Enter the product name" value="{{$data->product_name}}">
                    @if($errors->has('product_name'))
                      <p style="color:red">  {{$errors->first('product_name')}}</p>
                    @endif
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Category Name *</label>
                    <select name="category" class="form-control" id="category" placeholder="Enter the category name">
                        <option value=''>Choose category</option>
                        @foreach(@$cats as $row)
                        <option value="{{$row->id}}" @if($row->id==$data->category_id) ? selected='selected' @endif >{{$row->category_name}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Price *</label>
                    <input type="text" name="price" class="form-control" id="price" placeholder="Enter the price" value="{{$data->price}}">
                    @if($errors->has('price'))
                      <p style="color:red">  {{$errors->first('price')}}</p>
                    @endif
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Product Description</label>
                    <input type="text" name="desc" class="form-control" id="desc" placeholder="Enter the product description" value="{{$data->description}}">
                    @if($errors->has('desc'))
                      <p style="color:red">  {{$errors->first('desc')}}</p>
                    @endif
                  </div>
                </div>
                @if($data->image!='')
                <div class="col-md-6 ">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Image </label>
                    <input type="file" name="image" class="form-control" id="image" placeholder="Enter the question text" >
                    @php
                    if(Storage::disk('local')->exists('public/images/'.$data->image)){
                      $img =Storage::disk('local')->url($data->image);
                    }
                    else{
                      $img={{asset ('theme/dist/img/images.png')}};
                    }
                    @endphp
                     <img id="preview-image-before-upload" src="{{($img) ? $img : ''}}" alt="preview image" style="max-height: 250px;">
                  </div>
                </div>
                @endif
                </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" >Submit</button>
                  <a  href="javascript:history.back()" class="btn btn-primary" style="color:white">
                    <i class=""></i> Back
                </a>
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
</div>
@endsection

@push('js')
<script src="{{ asset('admin/product.js') }}"></script>
<script type="text/javascript">
$('#image').change(function(){
            
let reader = new FileReader();

reader.onload = (e) => { 

    $('#preview-image-before-upload').attr('src', e.target.result); 
}

reader.readAsDataURL(this.files[0]); 

});
</script>
@endpush

  