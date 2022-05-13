$(document).ready(function(){
    console.log($("#productForm").data("action"));
    $('#productForm').validate({

        rules: {
            product_name: {
              required: true,
            },
            category: {
                required: true,
            },
            price: {
                required: true,
                number: true
            }
          },
        
    submitHandler: function(form) {    
        // form.preventDefault();
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    let redirect =  $('#productForm').data("url");
     $.ajax({
      url       : $("#productForm").data("action"),
      type      : "POST",
      data      :  new FormData($(form)[0]),
    //   data      : $('#addOffer').serialize(),
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
                location.href = redirect;
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
        //   console.log(resp);
            let errors=resp.responseJSON.errors;
                    //  console.log(errors);
        Object.keys(errors).forEach((item,index)=>{
            $('input[name='+item+']')
            .closest('div')
            .append('<p class="error" style="color: red">'+errors[item][0]+'</p>')
        });
    }
     
     }); // Ajax closing
    }
    });

    // List category

    let table;
    AjaxAdminProductTable();

    function AjaxAdminProductTable() {
        let columns = [
           
            {
                data: 'DT_RowIndex', 
                name: 'DT_RowIndex',
                orderable: false, 
                searchable: false
            },
            {
                data: "product_name",
                orderable: true, 
                searchable: true
            },
            {
                data: "get_category.category_name",
                orderable: true, 
                searchable: true
            },
            {
                data: "price",
                orderable: true, 
                searchable: true
            },
            {
                data: "status",
                searchable: true
            },
            {
                data: "action",
                orderable: false,
            },
        ];

        if ($.fn.DataTable.isDataTable("#product_list")) {
            $("#product_list").DataTable().destroy();
        }

        table = $("#product_list").DataTable({
            bProcessing: true,
            serverSide: true,
            pageLength: 10,
            paging: true,
            bSort: true,
            order: [[1, "desc"]],
            scrollX: true,

            ajax: {
                url: $("#product_list").data("route"), // json datasource
                type: "post", // type of method  , by default would be get
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
        });
    }

    //status change

$(document).on("click", ".status-change", function (event) {
    event.preventDefault();
    let button = $(this);
    var route = $(this).data("href");
   
    Swal.fire({
        title: "Are you sure to change the status?",
        icon: "warning",
        showCancelButton: true,
        customClass: {
            confirmButton: "btn btn-danger",
            cancelButton: "btn btn-secondary",
        },
        buttonsStyling: true,
        confirmButtonText: "Yes",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
           $.ajax({
            url       : route,
            type      : "GET",
            dataType  : 'JSON',
            //contentType: false,
            cache     :  false,
            //processData: false,
            //data      :{exam_id:exam_id},
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

 $(document).on("click", ".delete", function (event) {
    event.preventDefault();
    let button = $(this);
    let route = $(this).data("href");
    Swal.fire({
        title: "Are you sure to delete this?",
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
});