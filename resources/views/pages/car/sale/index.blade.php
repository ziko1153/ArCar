@extends('layouts.app')

@section('extra-header')
   <!-- For Data Table -->
   <script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
   <script src="/global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
   <script src="/global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js"></script>
   <script src="/global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"></script>
   <script src="/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>


@endsection
    

<style>
    .dataList {
	list-style: none;
	padding: 0;
	margin: 0 0 9px 0;
	border-bottom: tomato 2px solid;
}
.dt-button-info {
    position: absolute;
    top: 20vh;
    left:50%;
    transform: translate(-50%,-50%);
    background:#333;
    color: white;
    padding: 20px;
}
.carList {
    margin:5px 0;
    border-bottom: tomato 2px solid;

}
</style>
@section('content')

<div class="row ">
    <div class="col-md-12 ">

      <!-- DataTable of Product list -->
  <div class="card">
    <div class="card-header header-elements-inline ">
      <h5 class="card-title font-weight-bold text-uppercase">Sale List</h5>
      @if(Session::has('message'))
        
            <div id="showAddMessage" class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                <span class="font-weight-semibold">Well done!</span>{{Session::get('message')}}
            </div>
      
    @endif


    </div>
    <div class="card-body border-top-1">
      <table class="table datatable-basic table-hover table-bordered" style="font-size:1rem">
        <thead class="bg-dark" >
          <tr>
            <th>Sl.</th>
            <th>Date</th>
            <th>Customer</th>
            <th>Discount</th>
            <th>Car List</th>
            <th>Payment History</th>
            <th>Due</th>
            <th>Sale Status</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
  <!-- /DataTable of Product list -->
    
</div>
</div>
{{-- Edit Modal Form --}}

@section('modal-content')

    <div class="modal-body">
        <span id="form_result"></span>
<form method="post" class="form-horizontal" id="paymentForm">
        
        @csrf

        <div class="form-group row">
            <label class="col-form-label col-lg-2">Amount:</label>
            <div class="col-lg-10">
                <div class="form-group-feedback form-group-feedback-right">
                <input
                 type="number" 
                 class="form-control" 
                  placeholder="Enter Amount" 
                  name="payment" 
                  value=""
                  step="0.01"
                  min="0"
                  
                  />
                </div>
            </div>
          
        </div>

        
        <div class="form-group row">
            <label class="col-form-label col-lg-2">Reference:</label>
            <div class="col-lg-10">
                <div class="form-group-feedback form-group-feedback-right">
                <input
                 type="text" 
                 class="form-control" 
                  placeholder="Enter Reference" 
                  name="reference" 
                  value=""

                  
                  />
                </div>
            </div>
          
        </div>


        <div class="form-group row">
            
            <label  class="col-form-label col-lg-2">Payment Date:</label>
                <div class="col-lg-10 input-group">
                 
                    <span class="input-group-prepend">
                        <span class="input-group-text"><i class="icon-calendar22"></i></span>
                    </span>
                <input type="text" class="form-control daterange-single " value="" name="payment_date">
                    <br>
                  
              
                    
                </div>
            
        </div>

        <div class="form-group row mb-0">
            <div class="col-lg-10 ml-lg-auto">
                <div class="d-flex justify-content-between align-items-center">
                    <input type="hidden" name="sale_id" id="sale_id" />
                    <button type="submit" class="btn bg-primary"> <i class="icon-coin-pound ml-2"></i> Take Payment</button>
                </div>
            </div>
        </div>
    </div>

 
</form>
<div class="card">
    <div class="payment-header card-header alpha-success text-success-800 header-elements-inline justify-content-center">
        <h6 class="card-title "><b>Previous Payment Hisotry</b></h6>
        
    </div>
    <div class="card-body">
       
        <div class="table-responsive table-scrollable">
            <table class="table">
                <thead>
                    <th>Sl.</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Reference</th>
                    <th>Delete</th>
                </thead>
                <tbody class="previousPaymentHistory">
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
</div>


@endsection

@include('layouts.confirmModal')


@endsection

@section('extra-script')
<script type="text/javascript" defer>
 let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
 let  saleId = 0;
    // Setting datatable defaults
    $.extend($.fn.dataTable.defaults, {
      autoWidth: false,
      dom: '<"datatable-header"fBl><"datatable-scroll"t><"datatable-footer"ip>',
      language: {
        search: '<span>Search:</span> _INPUT_',
        searchPlaceholder: 'Type to search...',
        lengthMenu: '<span>Show:</span> _MENU_',
        paginate: {
          'first': 'First',
          'last': 'Last',
          'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
          'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
        }
      }
    });


    let getSaleListDataTable = $('.datatable-basic').DataTable({
        processing: true,
        'serverSide': true,
        'ordering': true,
        'order': [],
        'ajax': {
            url: "{{route('car.sale.showajax')}}",
            type: 'POST',
            data: {
                _token: CSRF_TOKEN
            },
            beforeSend: function() {
                // $('body').modalForm({
                //     position: 'auto',
                //     text: 'Please wait...',
                //     color: 'white',
                //     opacity: '0.8',
                //     backgroundColor: 'rgb(33, 0, 0)',
                //     animation: 'circle'
                // });
            },
            error: function(xhr, error) {
                console.log('DataTable Get Data From Ajax Failed.');
                console.log(xhr);
                console.log(error);
            },
            complete: function() {
                // $('body').modalForm('hide');
                // $('body').modalForm('destroy');
            }
        },
        "columnDefs": [{
            "targets": [0, 1, 2],
            "orderable": false
        }],
        columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                {data:'date'},
                {data: 'customer'},
                {data: 'discount'},
                {data: 'car_list'},
                {data: 'payment_history'},
                {data: 'due'},
                {data: 'sale_status'},
                {data: 'action'}

            ], 

        buttons: {
            dom: {
                button: {
                    className: 'btn btn-dark',

                }
            },

            buttons: [

                {
                    extend: 'copy',
                    messageTop: 'Top Copy'

                },

                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }

                },

                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },

                {
                    extend: 'pdf',

                    title: 'Company name will Be Here',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]

                    }

                },

                {
                    extend: 'print',
                    footer: true,
                    title: '{!!config('app.name')!!}',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7],
                        stripHtml: false
                    }


                }

            ]
        },
    });

        const formMessageShow = (message,type='info') => {
            (message==="")? display = 'd-none' : display = '';
            $('#form_result').html(`<div class="${display} alert alert-${type} alert-rounded alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold">Message: </span>${message}</div>`);
        }

        /// Get Edit Form Modal 



        //// Submit Form 
       $('#paymentForm').on('submit', function(event){
          event.preventDefault();

         let request =   $.ajax({
                            url: "{{route('car.sale.payment')}}",
                            method:"POST",
                            data:$(this).serialize(),
                            dataType:"json"
                         });
            
         request.done(function( msg ) {
            if(msg.errors){
                let errorMsg = `<ul>`;
                msg.errors.forEach( (error) =>{
                    errorMsg += `<li>${error}</li>`;
                });
                errorMsg += `</ul>`;
                formMessageShow(`Error: ${errorMsg}`,'danger');
            }
            else {
                formMessageShow(`${msg.success}`,'success');
                $('#paymentForm')[0].reset();
                getPaymentData(saleId);
                getSaleListDataTable.ajax.reload(null, false);

            }
         });
        
        request.fail(function( jqXHR, textStatus ) {
            formMessageShow(`Internal Server ${textStatus} Failed Edit  ${jqXHR} `,'danger');
            if(jqXHR.status=== 419 || jqXHR.status === 401) {
                            alert('Something Went Wrong !! We are going to Reload this Page after 5 seconds');
                            setTimeout(()=>{
                                location.reload();
                            },5000)
                    }
         });
                        
       });

       ///// Date Range Select
        $('.daterange-single').daterangepicker({ 
                singleDatePicker: true,
                startDate: moment(),
                locale: {
                format: 'YYYY-MM-DD'
            }
        });

        //// Delete Car List

        $(document).on('click', '.delete', function(){
                saleId = $(this).attr('id');
                $('#confirmModal').modal('show');
                
        });

        $('#confirm_btn').click(function(){
            
            $.ajax({
                    url: "{{route('car.sale.delete')}}",
                    method:"POST",
                    data: {id:saleId, _token: CSRF_TOKEN},
                    dataType:'json',
                    beforeSend:function(){
                        $('#confirm_btn').prop('disabled', true);
                        $('#confirm_btn').text('Deleting...');
                    },
                    success:function(data)
                    {  
                        $('#confirm_btn').prop('disabled', false);
                        $('#confirmModal').modal('hide');
                        $('#confirm_btn').text('Delete');
                        getSaleListDataTable.ajax.reload(null, false);
                    },
                    error:function(jqXHR, textStatus) { 
                        $('#confirm_btn').prop('disabled', false);
                        $('#confirm_btn').text('Delete');
                        pAlertError('Internal Server Error');
                        console.log(jqXHR,textStatus);
                        if(jqXHR.status=== 419 || jqXHR.status === 401) {
                            pAlertError('Something Went Wrong !! We are going to Reload this Page after 5 seconds');
                            setTimeout(()=>{
                                location.reload();
                            },5000)
                    }
                    }
            });
        });


        setTimeout(()=>{

                $('#showAddMessage').hide();
        },4000)



        $(document).on('click', '.addPayment', function(){
            $('.modal-title').html('Add/Delete Payment');
            $('#modalForm').modal('toggle');
            saleId  = $(this).attr('id');
            $('#sale_id').val(saleId)

               getPaymentData(saleId);
        });

        let getPaymentData = (saleId) => {
            $.ajax({
            url: "/car/sale/payment",
            dataType: 'JSON',
            data: {saleId,_token:CSRF_TOKEN},
            beforeSend: function() {
  
        
               $('.previousPaymentHistory').html('<h5>Fetching Data <i class="icon-spinner2 spinner"></i></h5>');
               
            },
            success: function(response) {

                if(response.success === true) {
                    $('.previousPaymentHistory').html(response.data);
                }
            },
            error: function(xhr, error) {
                if (xhr.readyState == 0 && xhr.status != 200) {
                    pAlertError('Oppss Offline','Please Check Your Internet Connection');
                    setTimeout(()=>{
                        $('#modalForm').modal('toggle');
                    },2000);
                    return;
                }

                setTimeout(()=>{
                        $('#modalForm').modal('toggle');
                    },5000);

            $('.payment-header').html(`<h1 class="text-danger-800 ">Internal Server Error</h1>`);
            }

            });
        } 

        let deletePayment = (id) => {
            $.ajax({
            url: "/car/sale/payment/destroy",
            type:'POST',
            dataType: 'JSON',
            data: {paymentId:id,_token:CSRF_TOKEN},
            beforeSend: function() {
                $('.payment-header').html(`<h1 class="text-danger-800 ">Wait We are Deleteing...</h1>`);
               
            },
            success: function(response) {

                if(response.success === true) {
                    $('.payment-header').html(`<h1 class="text-success-800 ">Deleted SuccessFully</h1>`);
                    getSaleListDataTable.ajax.reload(null, false);
                }
                setTimeout(() => {
                    $('.payment-header').html(`<h6 class="card-title "><b>Previous Payment Hisotry</b></h6>`);
                },2000);
            },
            error: function(xhr, error) {
                if (xhr.readyState == 0 && xhr.status != 200) {
                    pAlertError('Oppss Offline','Please Check Your Internet Connection');
                    setTimeout(()=>{
                        $('#modalForm').modal('toggle');
                    },2000);
                    return;
                }

                setTimeout(()=>{
                        $('#modalForm').modal('toggle');
                    },5000);

            $('.payment-header').html(`<h1 class="text-danger-800 ">Internal Server Error</h1>`);
            },
            complete:function() {
                getPaymentData(saleId);
            }

            });

        }

    

</script>
@endsection