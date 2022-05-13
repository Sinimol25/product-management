@extends('admin.layout.index')
@section('content')
<div class="content-wrapper">
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Order</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{route('admin.order.list')}}">Order</a></li>
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
                <h3 class="card-title">Customer Details</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
             <div class="card-body">
                <div class="row type1 ">
                <!-- left column -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Customer Name </label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter the customer name" value="{{$data->name}}" readonly>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Phone Number</label>
                    <input type="text" name="phone" class="form-control" id="phone" placeholder="Enter the category description" value="{{$data->phone}}" readonly>
                  </div>
                </div>
                </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#productModal">Add Products</button>
                  <a href="javascript:history.back()" class="btn btn-primary" style="color:white" >Back
                </a>
                </div>
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

      <!-- Product List -->
      <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
              <div class="row">
                 <div class="col-10">
                 <h3 class="card-title">List Added Products</h3>
                </div>
                
              </div>
             <!-- /.card-header -->
              
              <div class="card-body">
              <table id="order_list" class="table table-bordered table-hover" data-route="" style="width:100%">
                  <thead>
                  <tr>
                   <th>Product Name</th>
                    <td>Quantity</td>
                    <td>Price per Item</td>
                    <th>Total Amount</th>
                    <th>Action</th>
                   </tr>
                  </thead>
                  <tbody class="addedProduct">
                    @foreach($allPro as $key=>$pro)
                      @php $amount = $pro->getProduct->price * $pro->quantity; @endphp
                      <tr>
                        <td>{{$pro->getProduct->product_name}}</td>
                        <td>{{$pro->quantity}}</td>
                        <td>{{$pro->getProduct->price}}</td>
                        <td>{{$amount}}</td>
                        <td><a data-href="{{route('admin.order.edit-product', ['id' => $pro->id]) }}" data-price="{{$pro->getProduct->price}}" data-custid="{{$pro->customer_id}}" data-productid="{{$pro->product_id}}" title="Edit" class="btn btn-success orderEdit" style="background:green;"><i class="fas fa-pencil-alt "></i></a>
                            <a data-href="{{route('admin.order.delete-product', ['id' => $pro->getProduct->id])}}" data-custid="{{$pro->customer_id}}" data-productid="{{$pro->product_id}}" title="Delete" class="btn btn-danger orderDelete" ><i class="fas fa-trash-alt "></i></a>
                        </td>
                      </tr>
                    @endforeach
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
</div>

<!-- producr add   medium -->
<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true" data-backdrop="false">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel">Add product</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
                        <input type="hidden" id="cust_id" name="cust_id" placeholder="Customet ID" class="form-control" value="{{$data->id}}">
                        @php $cid= $data->id; @endphp

                        <div class="card-body card-block">
                        <div class="row form-group">
                                <div class="col col-md-1">
                                    <label for="hf-email" class=" form-control-label">Sl.No</label>
                                </div>
                                <div class="col col-md-6">
                                    <label for="hf-email" class=" form-control-label">Product Name</label>
                                </div>
                                <div class="col col-md-2">
                                <label for="hf-email" class=" form-control-label">Price</label>
                                </div>
                               <div class="col col-md-1">
                               <label for="hf-email" class=" form-control-label">Quantity</label>
                              </div>    
                          </div>
                        @foreach($product as $key=>$row)
                            <div class="row form-group">
                                <div class="col col-md-1">
                                    <label for="hf-email" class=" form-control-label">{{++$key}}</label>
                                </div>
                                <div class="col col-md-6">
                                    <label for="hf-email" class=" form-control-label">{{$row->product_name}}</label>
                                </div>
                                <div class="col col-md-2">
                                    <span for="hf-email" class=" form-control-label">{{$row->price}}</span>
                                </div>
                               @php 
                               $pid = $row->id;
                              //echo   $cid;
                                  $data =  App\Repositories\OrderRepository::getAddedProduct($pid,$cid);  @endphp
                              <div class="col col-md-1">
                              @if($data==0)
                                <input type="number" name="qty" id="qty" style="width: 56px;height:35px;" value="1" class="qty">
                              @endif
                              </div>    
                              <div class="col-12 col-md-2">
                                    <a  class="btn btn-primary proAdd" style="color:white" data-rate="{{$row->price}}" data-remove="{{route('admin.order.delete-product', ['id' => $row->id])}}" data-proid="{{$row->id}}" data-customerid="{{$cid}}" data-href="{{route('admin.order.store-product',['id' =>$row->id])}}" >
                                        <i class=""></i> 
                                        @if($data==0)
                                        Add
                                        @endif
                                        @if($data==1)
                                        @php $prosAry[] = $pid ; @endphp
                                        Remove
                                        @endif
                                    </a>
                              </div>
                          </div>
                        @endforeach
                          @php if(@$prosAry)  { $productid= implode(',',@$prosAry); } @endphp
                          <input type="hidden" id="hidQues" value="{{@$productid}}">
                    </div>
                    </div>
						</div>
						
					</div>
				</div>


        <!-- exam  medium -->
  <div class="modal fade" id="productEditModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true" data-backdrop="false">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel">Edit Product</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
                <form method="post" data-action=""  name="updateProduct" id="updateProduct" class="updateProduct">
                    @csrf
                <div class="card-body card-block">
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="hf-email" class=" form-control-label"> Product Name</label>
                        </div>
                        <div class="col-12 col-md-9">
                        <input type="text" id="proname" name="proname" class="form-control" value="" placeholder="" value="" readonly>
                            <p style="color:red" class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12" > </p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="hf-email" class=" form-control-label"> Total Rate</label>
                        </div>
                        <div class="col-12 col-md-9">
                        <input type="text" id="rate" name="rate" class="form-control" value="" placeholder="" value="" readonly>
                            <p style="color:red" class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12" > </p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="hf-email" class=" form-control-label"> Quantity</label>
                        </div>
                        <div class="col-12 col-md-9">
                        <input type="number" id="proqty" name="proqty" placeholder="" class="form-control" value="" min="1">
                        <input type="hidden" id="price" name="price" placeholder="" class="form-control" value="" >
                            <p style="color:red" class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12" > </p>
                        </div>
                    </div>
                    </div>
                    <input type="hidden" id="orderid" name="orderid" class="form-control" value="" placeholder="" value="">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm" style="color:white">
                            <i class=""></i> Submit
                        </button>
                        <button type="button" class="btn btn-primary btn-sm" style="color:white" data-dismiss="modal">
                            <i class=""></i> Back
                        </button>
                   </div>
                </form>
              </div>
						</div>
						
					</div>
				</div>
			</div>
		<!-- end exam medium -->
@endsection

@push('js')
<script src="{{ asset('admin/order.js') }}"></script>
<script type="text/javascript">

</script>
@endpush

  