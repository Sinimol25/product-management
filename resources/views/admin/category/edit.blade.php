@extends('admin.layout.index')
@section('content')
<div class="content-wrapper">
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Category</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{route('admin.category.list')}}">Category</a></li>
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
                <h3 class="card-title">Add Category</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="catForm" method="post" data-action=" {{route('admin.category.update' ,$data->id)}}" name="catForm" data-url="{{route('admin.category.list')}}">
                  @csrf
                <div class="card-body">
                <div class="row type1 ">
                <!-- left column -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Category Name *</label>
                    <input type="text" name="category" class="form-control" id="category" placeholder="Enter the category name" value="{{$data->category_name}}">
                    @if($errors->has('category'))
                      <p style="color:red">  {{$errors->first('category')}}</p>
                    @endif
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Category Description</label>
                    <input type="text" name="desc" class="form-control" id="desc" placeholder="Enter the category description" value="{{$data->description}}">
                    @if($errors->has('desc'))
                      <p style="color:red">  {{$errors->first('desc')}}</p>
                    @endif
                  </div>
                </div>
                </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" >Submit</button>
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
<script src="{{ asset('admin/category.js') }}"></script>
<script type="text/javascript">

</script>
@endpush

  