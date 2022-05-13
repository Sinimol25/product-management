@extends('admin.layout.index')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Product</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
              <div class="row">
                 <div class="col-10">
                 <h3 class="card-title">List Product</h3>
                </div>
                <div class="col-2">
                  <a href="{{ route('admin.product.create')}}" class="btn btn-primary">Add Product</a>
                  </div>
              </div>
             <!-- /.card-header -->
              
              <div class="card-body">
              <table id="product_list" class="table table-bordered table-hover" data-route="{{route('admin.product.list-product')}}" style="width:100%">
                  <thead>
                  <tr>
                    <th>Sl.No</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <td>Status</td>
                    <th>Action</th>

                   </tr>
                  </thead>
                  <tbody>
                      
                  </tbody>
                </table>
               
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  @endsection

  @push('js')
  <script src="{{ asset('admin/product.js') }}"></script>

  @endpush
