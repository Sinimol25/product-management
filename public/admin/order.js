$(document).ready(function(){
    $('#addOrder').validate({
        rules: {
            name :{
                required : true,
            },
            phone: {
                required : true,
                digits: true,
                minlength :10,
                maxlength:10
            }
           
          },
        
    submitHandler: function(form) {    
      form.submit();
    
    }
    });

    var proAry=[];
    var existProductId = $('#hidQues').val();
    //console.log(existQuestinId);
    if(existProductId!=''){
        proAry = existProductId.split(',');
    }
// console.log(quesAry);
$(document).on("click", ".proAdd", function (event) {
    event.preventDefault();
    let button = $(this);
    let route = $(this).data("href");
    let remove = $(this).data("remove");
    let cust_id = $('#cust_id').val();
    let customer_id = $(this).data('customerid');
    let rate = $(this).data('rate');
    var val = $(this).closest("div.row").find("input[name='qty']").val();
    //   console.log(remove);
    //  console.log(customer_id);
    //   console.log(route);
    //   console.log(val);
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept' :'application/json'
        }
    });
    var proId=$(this).attr('data-proid');
    index = proAry.indexOf(proId);
    console.log(index);
    if(index == -1){ 
        Swal.fire({
            title: "Are you sure you wish to add this product?",
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
                proAry.push(proId);
                $(this).html('Remove');
                // $(this).removeClass('btn-success');
                // $(this).addClass('btn-danger');
                //ajax code for inseritng quetion details
                $.ajax({
                    url       : route,
                    type      : "POST",
                    dataType  : 'JSON',
                    // contentType: false,
                    cache     :  false,
                    // processData: false,
                    data      : {cust_id:cust_id,qty:val,rate:rate},
                    success:function(result)
                    {
                        console.log(result.product);
                        if(result.status==1)
                        {
                            $('#productModal').modal('show');
                            button.closest("div.row").find("input[name='qty']").hide()
                                var quty = result.product.quantity;
                                var rate = result.product.get_product.price;
                                var total = quty * rate;
                                // console.log(rate);
                                // console.log(quty);
                                // console.log(total);
                                $('.addedProduct').append('<tr><td>'+result.product.get_product.product_name+'</td><td>'+result.product.quantity+'</td><td>'+result.product.get_product.price+'</td><td>'+total+'</td><td><a data-href="'+result.url_edit+'" data-price="'+result.product.get_product.price+'" data-custid="'+result.product.customer_id+'" data-productid="'+result.product.product_id+'" class="btn btn-success orderEdit" title="Edit"><i class="fas fa-pencil-alt "></i></a><a data-href="'+result.url_delete+'" data-custid="'+result.product.customer_id+'" data-productid="'+result.product.product_id+'"class="btn btn-danger orderDelete" ><i class="fas fa-trash-alt "></i></a></td></tr>');
                            
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
    }
    else
    {
       
        Swal.fire({
                title: "Are you sure you wish to remove this product?",
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
                    proAry.splice(index,1);
                        $(this).html('Add');
                        //$(this).css('background-color:red');
                        //  $(this).removeClass('btn-danger');
                        //  $(this).addClass('btn-success');
                        //ajax code for inseritng quetion details
                        $.ajax({
                        url       : remove,
                        type      : "GET",
                        dataType  : 'JSON',
                        // contentType: false,
                        cache     :  false,
                        // processData: false,
                        data      : {customer_id:customer_id},
                        success:function(result)
                        {
                            //console.log(result);
                            //console.log(result.question);
                            
                            if(result.status==1)
                            {
                                
                                $('#productModal').modal('show');
                                button.closest("div.row").find("input[name='qty']").show()
                                $('.addedProduct').empty();

                                     $.each(result.product ,function(index,value){
                                        var quty = value.quantity;
                                        var rate = value.get_product.price;
                                        var total = quty * rate;
                                        // console.log(rate);
                                        // console.log(quty);
                                        // console.log(total);
                                        $('.addedProduct').append('<tr><td>'+value.get_product.product_name+'</td><td>'+value.quantity+'</td><td>'+result.product.get_product.price+'</td><td>'+total+'</td><td><a data-href="'+value.url_edit+'" data-price="'+result.product.get_product.price+'" data-custid="'+value.customer_id+'" data-productid="'+value.product_id+'" class="btn btn-success orderEdit" title="Edit"><i class="fas fa-pencil-alt "></i></a><a data-href="'+value.url_delete+'" data-custid="'+value.customer_id+'" data-productid="'+value.product_id+'"class="btn btn-danger orderDelete" ><i class="fas fa-trash-alt "></i></a></td></tr>');

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
    }
  });

  //delete

$(document).on("click", ".orderDelete", function (event) {
    event.preventDefault();
    let button = $(this);
    let route = $(this).data("href");
    let customer_id = $(this).data('custid');
    //console.log(route);
    
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
            data      :{customer_id:customer_id},
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

$(document).on("click", ".orderEdit", function (event) {
    //alert('hii');
    event.preventDefault();
    var custid = $(this).data('custid');
    var route = $(this).data('href');
    console.log(custid);
    console.log(route);
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
        data : {custid:custid},
        success:function(result)
        {
            if(result.status==1)
            {
                $('#productEditModal').modal('show');
                 var value =result.product.quantity;
                 var value1 =result.product.get_product.price;
                 var total = value * value1;
                 $('#proname').val(result.product.get_product.product_name);
                 $('#rate').val(total);
                 $('#proqty').val(result.product.quantity);
                 $('#price').val(result.product.get_product.price);
                 $('#updateProduct').attr('data-action',result.route);
                 $('orderid').val(result.product.id);
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


    // update
    
    $("#updateProduct").validate({
    
    rules: {
        proqty : {
            required: true
        }
    },
    submitHandler: function(form) {
        var qty      = $('#proqty').val();
        var orderid  = $('#orderid').val();
        var action   = $("#updateProduct").data("action");
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

//list


});