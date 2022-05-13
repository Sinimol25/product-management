@extends('admin.layout.index')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Order</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Order</li>
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
                 <h3 class="card-title">List Orders</h3>
                </div>
                <div class="col-2">
                  <button type="button" class="btn btn-primary" style="color:white;" data-toggle="modal" data-target="#orderModal">
                  Add Order</button>
                  </div>
              </div>
             <!-- /.card-header -->
              
              <div class="card-body">
              <table id="order_list" class="table table-bordered table-hover" data-url="{{route('admin.order.list-order')}}" style="width:100%">
                  <thead>
                  <tr>
                    <th>Sl.No</th>
                    <th>Invoice ID</th>
                    <td>Customer Name</td>
                    <th>Phone Number</th>
                    <th>Net Amount</th>
                    <th>Order Date</th>
                    <th>Action</th>

                   </tr>
                  </thead>
                  <tbody id="list">
                      {{--@foreach($data as $key=>$val)
                      @php  
                                $cid = $val->id; 
                                $total =  App\Repositories\OrderRepository::getTotal($cid);  
                        @endphp
                          
                      <tr>
                          <td>{{++$key}}</td>
                          <td>{{$val->getCustomer->invoice_no}}</td>
                          <td>{{$val->getCustomer->name}}</td>
                          <td>{{$val->getCustomer->phone}}</td>
                          <td>{{$total->net_amount}}</td>
                          <td>{{date('d-m-Y', strtotime($val->created_at))}}</td>
                          <td>
                                <a data-href="{{route('admin.order.view',['id' => $val->id])}}" title="Edit Customer" class="btn btn-primary editUser" style="background:blue;"><i class="fas fa-user "></i></a>
                                <a href="{{route('admin.order.create',['id' => $val->id])}}" title="Edit" class="btn btn-primary" style="background:green;"><i class="fas fa-pencil-alt "></i></a>
                                <a data-href="{{route('admin.order.delete-order',['id' => $val->id])}}" title="Delete" class="btn btn-danger deleteUser" ><i class="fas fa-trash-alt "></i></a>
                                <a target="_blank" href="{{route('admin.order.download-invoice',['id' => $val->id])}}" title="Download Invoice" class="btn btn-success invoiceDowload" ><i class="fas fa-file "></i></a>
                          </td>
                      </tr>
                      @endforeach--}}
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

  <!-- exam  medium -->
  <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true" data-backdrop="false">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel">Add Customer Details</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
                <form method="post" action="{{route('admin.order.store')}}"  name="addOrder" id="addOrder">
                    @csrf
                <div class="card-body card-block">
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="hf-email" class=" form-control-label"> Customer Name</label>
                        </div>
                        <div class="col-12 col-md-9">
                        <input type="text" id="name" name="name" class="form-control" value="" placeholder="Enter customer name">
                            <p style="color:red" class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12" > </p>
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="hf-email" class=" form-control-label"> Phone Number</label>
                        </div>
                        <div class="col-12 col-md-9">
                        <input type="text" id="phone" name="phone" placeholder="Enter Phone number" class="form-control" value="">
                            <p style="color:red" class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12" > </p>
                        </div>
                    </div>
                    </div>
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

    <!-- exam  medium -->
  <div class="modal fade" id="userEditModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true" data-backdrop="false">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel">Update Customer Details</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
                <form method="post" data-action=""  name="editOrder" id="editOrder">
                    @csrf
                <div class="card-body card-block">
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="hf-email" class=" form-control-label"> Customer Name</label>
                        </div>
                        <div class="col-12 col-md-9">
                        <input type="text" id="cname" name="cname" class="form-control" value="" >
                            <p style="color:red" class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12" > </p>
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="hf-email" class=" form-control-label"> Phone Number</label>
                        </div>
                        <div class="col-12 col-md-9">
                        <input type="text" id="cphone" name="cphone"  class="form-control" value="">
                            <p style="color:red" class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12" > </p>
                        </div>
                    </div>
                    </div>
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

  <script>
  $(document).ready(function () {
  let table;
    DataTabless();

    function DataTabless() {
        let columns = [
            {
                data: 'DT_RowIndex', 
                name: 'DT_RowIndex',
                orderable: false, 
                searchable: false
            },
            {
                data: "get_customer.invoice_no",
                orderable: true, 
                searchable: true
                
            },
            {
                data: "get_customer.name",
                orderable: true, 
                searchable: true
                
            },
           {
                data: "get_customer.phone",
                orderable: false, 
                searchable: true
            },
            {
                data: "net_amount",
                orderable: false, 
                searchable: true
            },
            {
                data: "get_customer.created_at",
                orderable: false, 
                searchable: false
            },
            {
                data: "action",
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ];

        if ($.fn.DataTable.isDataTable("#order_list")) {
            $("#order_list").DataTable().destroy();
        }

        table = $("#order_list").DataTable({
            bProcessing: true,
            serverSide: true,
            pageLength: 10,
            paging: true,
            bSort: true,
            order: [[1, "desc"]],
            scrollX: true,

            ajax: {
                url     : $("#order_list").data("url"), // json datasource
                type    : "POST", // type of method  , by default would be get
                datatype: "json",
               
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content" ),
                },
                data: function (data) {
                    data.custom_filter = $("#custom_select").val();
                },
                error: function () {
                    // error handling code
                    // $("#reports_visitors_processing").css("display", "none");
                },
            },
            columns: columns,
            lengthMenu: [
                [10, 20, 40, 60, 80, 100, -1],
                [10, 20, 40, 60, 80, 100, "All"],
            ],
            dom: "<'row'<'col-sm-6 text-left'B><'col-sm-6 text-right'f>>\n\t\t\t<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager pt-2'lp>>",
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
                
            'pageLength'
            ],
        });
    }
  });

  //delete order

  $(document).on("click", ".deleteUser", function (event) {
        event.preventDefault();
        let button = $(this);
        let route = $(this).data("href");
        Swal.fire({
            title: "Are you sure you wish to delete this?",
            icon: "warning",
            showCancelButton: true,
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-secondary",
            },
            buttonsStyling: true,
            confirmButtonText: "Delete",
            showLoaderOnConfirm: true,
            preConfirm: () => {
                // let options = {
                //     url: route,
                //     method: "DELETE",
                // };
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept' :'application/json'
                    }
                });
                $.ajax({
                url       : route,
                type      : "DELETE",
                dataType  : 'JSON',
                contentType: false,
                cache     :  false,
                processData: false,
                success:function(result)
                {
                    if(result.status==1)
                    {
                        Swal.fire({
                            icon: 'success',
                            text: result.message,
                            customClass: {
                            confirmButton: "btn btn-primary",
                        },
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        })
                    }
                    else{
                        Swal.fire({
                            icon: 'error',
                            text: result.message,
                            customClass: {
                            confirmButton: "btn btn-primary",
                        },
                        }).then((result) => {
                            if (result.isConfirmed) {
                            window.location.reload();
                            }
                        })
                    }
                },
            
        }); // Ajax closing
            },
            
        });
    });

     // edit

$(document).on("click", ".editUser", function (event) {
    event.preventDefault();
    var route = $(this).data('href');
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
        $.ajax({
        url       :  route,
        type      : "GET",
        dataType  : 'JSON',
        //contentType: false,
        cache     :  false,
        //processData: false,
        success:function(result)
        {
            console.log(result.user.name);
            if(result.status==1)
            {
                $('#userEditModal').modal();
                 $('#cname').val(result.user.name);
                 $('#cphone').val(result.user.phone);
                 $('#editOrder').attr('data-action',result.route);
                
            }
            else{
                Swal.fire({
                    icon: 'error',
                    text: result.message,
                    customClass: {
                    confirmButton: "btn btn-primary",
                },
                }).then((result) => {
                    if (result.isConfirmed) {
                    window.location.reload();
                    }
                })
            }
        },
        
    }); // Ajax closing
});

//update

$("#editOrder").validate({
    
    rules: {
        cname : {
            required: true,
            minlength:3
        },
        cphone : {
            required: true,
            digits:true,
            minlength:10
        }
    
    },
    
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
        var action = $("#editOrder").data("action");
        $.ajaxSetup({
            headers: {
                'X-CSSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept':'application/json'
            }
        });
        $.ajax({
            dataType    :'json',
            type        :'post',
            data        :new FormData($(form)[0]),
            url         :action,
            processData :false,
            cache       :false,
            contentType :false,
            success:function(result){
                if(result.status==1)
                {
                    Swal.fire({
                        icon: 'success',
                        text: result.message,
                        customClass: {
                        confirmButton: "btn btn-primary",
                    },
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    })
                }
                else{
                    Swal.fire({
                        icon: 'error',
                        text: result.message,
                        customClass: {
                        confirmButton: "btn btn-primary",
                    },
                    }).then((result) => {
                        if (result.isConfirmed) {
                        window.location.reload();
                        }
                    })
                }
            },
            error: function(resp){
                  console.log(resp);
                    let errors=resp.responseJSON.errors;
                            //  console.log(errors);
                Object.keys(errors).forEach((item,index)=>{
                    $('input[name='+item+']')
                    .closest('div')
                    .append('<p class="error" style="color: red">'+errors[item][0]+'</p>')
                });
            }
        })
    }
});

    </script>
  @endpush
