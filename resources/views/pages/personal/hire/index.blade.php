@extends('layouts.app')

@section('extra-header')
    <script src="/global_assets/js/plugins/extensions/jquery_ui/full.min.js"></script>
    <script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
    <script src="/global_assets/js/plugins/notifications/pnotify.min.js"></script>
   <!-- For Data Table -->
   <script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
   <script src="/global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
   <script src="/global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js"></script>
   <script src="/global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"></script>
   <script src="/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
   <script src="/global_assets/js/plugins/notifications/pnotify.min.js"></script>

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
</style>
@section('content')

<div class="row ">
    <div class="col-md-12 ">

      <!-- DataTable of Car list -->
  <div class="card">
    <div class="card-header header-elements-inline  ">
      <h2 class="card-title font-weight-bold text-uppercase">Personal Car Hire List</h2>
 
      <button type="button" class="btn bg-violet btn-lg addHireBtn" data-toggle="modal" data-target="#modalForm">Hire Car<i class="icon-play3 ml-2"></i></button>

    </div>

    <div class="card-body border-top-1">
      <table class="table datatable-basic table-hover table-bordered" style="font-size:1rem">
        <thead class="bg-dark">
          <tr>
            <th>Sl.</th>
            <th>Date</th>
            <th>Reg. No.</th>
            <th>Customer</th>
            <th>Hire Rate</th>
            <th>Weeks</th>
            <th>Payment</th>
            <th>Due</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
  <!-- /DataTable of Car list -->
    
</div>
</div>
{{--  Modal Form --}}

@section('modal-content')

    <div class="modal-body">
        <span id="form_result"></span>
<form method="post" class="form-horizontal" id="sample_form">
        
        @csrf
        <div class="form-group row">
            <label class="col-form-label col-lg-2">Select Customer:</label>
            <div class="col-lg-10">
                <div class="form-group-feedback form-group-feedback-right">
                    <select name="customer"  data-placeholder="Select a Customer First"  class="form-control customer-select-search"  data-fouc>
                        <option></option>
                      
                        @foreach ($customerList as $customer)
                    <option value={{$customer['id']}}>{{$customer['value']}}</option>
                        
                        @endforeach
                        
                            
                           
                    </select>
                </div>
           
            </div>

            
       
        </div>

        <div class="form-group row customerShow">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Address</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>NI</th>
                        </tr>
                    </thead>
                    <tbody class="addCustomerRow">
    
                    </tbody>
                </table>
            </div>
        </div>

        <div class="form-group row carShowSelect">
            <label class="col-form-label col-lg-2">Select Car:</label>
            <div class="col-lg-10">
                <div class="form-group-feedback form-group-feedback-right">
                    <select name="car"  data-placeholder="Select  Available Car "  class="form-control car-select-search" data-fouc>
                        <option></option>
                      
                        @foreach ($carList as $car)
                    <option value="{{$car['id']}}">{{$car['value']}}</option>
                        
                        @endforeach
                        
                            
                           
                    </select>
                </div>
           
            </div>

            
       
        </div>

        <div class="form-group row carShow">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Car Name</th>
                            <th>Reg No</th>
                        </tr>
                    </thead>
                    <tbody class="addCarRow">
    
                    </tbody>
                </table>
            </div>
        </div>

        <div class="form-group row showDisplay">
            <label class="col-form-label col-lg-2">Hire Start Date</label>
            <div class="col-lg-10">
                <div class="form-group-feedback form-group-feedback-right">
                <input
                 type="text" 
                 class="form-control daterange-single" 
                 id="hireStartDate"
                  placeholder="Enter Hire Start Date" 
                  name="hire_start_date"
                  value=""
                  autocomplete="off"
                  />
                </div>
            </div>
          
        </div>

        <div class="form-group row showDisplay">
            <label class="col-form-label col-lg-2">Weekly Hire Rate</label>
            <div class="col-lg-10">
                <div class="form-group-feedback form-group-feedback-right">
                <input
                 type="text" 
                 class="form-control checkForDot" 
                 id="hireRate"
                  placeholder="Enter Weekly Rate" 
                  name="hire_rate"
                  value=""
                  autocomplete="off"
                  />
                </div>
            </div>
          
        </div>

        <div class="form-group row showDisplay">
            <label class="col-form-label col-lg-2">Hire End Date</label>
            <div class="col-lg-10">
                <div class="form-group-feedback form-group-feedback-right">
                <input
                 type="text" 
                 class="form-control" 
                 id="hireEndDate"
                  placeholder="Enter Hire End Date" 
                  name="hire_end_date"
                  value=""
                  autocomplete="off"
                  />
                </div>
            </div>
          
        </div>





        <div class="form-group row mb-0">
            <div class="col-lg-10 ml-lg-auto">
                <div class="d-flex justify-content-between align-items-center">
                 <input type="hidden" name="action" id="action" value="Add" />
                 <input type="hidden" name="hidden_id" id="hidden_id" />
                 <input type="submit" name="action_button" id="action_button" class="btn bg-violet btn-lg" value="Hire Car" />
                </div>
            </div>
        </div>
    </form>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
    </div>


@endsection


{{-- Payment Modal Form --}}

<div id="modalPaymentForm" class="modal fade" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <div class="modal-body">
                <span id="payment_form_result"></span>
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
                        <input type="text" class="form-control daterange-single " value="" name="payment_date" autocomplete="off">
                            <br>
                          
                      
                            
                        </div>
                    
                </div>
        
                <div class="form-group row mb-0">
                    <div class="col-lg-10 ml-lg-auto">
                        <div class="d-flex justify-content-between align-items-center">
                            <input type="hidden" name="hire_id" id="hire_id" />
                            <button id="paymentBtn" type="submit" class="btn bg-primary"> <i class="icon-coin-pound ml-2"></i> Take Payment</button>
                        </div>
                    </div>
                </div>
        
            </form>
           </div>

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
          
        </div>
    </div>
</div>


@include('layouts.confirmModal');


@endsection

@section('extra-script')
<script type="text/javascript" defer>

let  pAlertError = (title, text)  => {
    new PNotify({
        title: title,
        text: text,
        addclass: 'bg-danger border-danger'
    });
}

let  pAlertSuccess = (title, text)  => {
    new PNotify({
        title: title,
        text: text,
        addclass: 'bg-success border-success'
    });
}

$(".checkForDot").focusout(function() {
        let val = $(this).val();
        if (val == "." || val == "") {
            $(this).val(0);
           

        }

    });

    $('.checkForDot').on('input', function() {

        let value = $(this).val();
        var id = $(this).attr('id');

        value = value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g,
        '$1'); /// here replace double dot and any character

        if (/\./i.test(value)) {

            flt = value.indexOf(".");
            decimal = value.substr(0, flt);
            x = value.substr(flt, 3);
            value = decimal + x;

        }

        $(this).val(value);
  

});

$('#modalForm').attr('data-backdrop', 'static');
 let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
 let  hireId = null;
 

 let selectedCustomerId = 0;
 let selectedCarId = 0;
 let customerList = @json($customerList);
 let carList  = @json($carList);
$('.addHireBtn').click(function(){
    resetHireForm();
  $('.modal-title').text('Add Hire Car');
  $('#action_button').val('Hire Car');
  $('#action').val('Add');
  $('#form_result').html('');
  $('#sample_form')[0].reset();

 });



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
    let getCarDataTable = $('.datatable-basic').DataTable({
        processing: true,
        'serverSide': true,
        'ordering': true,
        'order': [],
        'ajax': {
            url: "{{route('personal.car.hire.showajax')}}",
            type: 'POST',
            data: {
                _token: CSRF_TOKEN
            },
            beforeSend: function() {
                // $('body').loadingModal({
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
                if(jqXHR.status===419) {
                            alert('Something Went Wrong !! We are going to reload this Page after 5 seconds');
                            setTimeout(()=>{
                                location.reload();
                            },5000)
                }

            },
            complete: function() {
                // $('body').loadingModal('hide');
                // $('body').loadingModal('destroy');
            }
        },
        "columnDefs": [{
            "targets": [0, 1, 2],
            "orderable": false
        }],
        columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                {data: 'date'},
                {data: 'reg_no'},
                {data: 'customer'},
                {data: 'hire_rate'},
                {data: 'weeks'},
                {data: 'payment'},
                {data: 'due'},
                {data: 'hire_status'},
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
                    extend: 'copy'

                },

                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [0, 1, 2,3,4,5,6]
                    }

                },

                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2,3,4,5,6]
                    }
                },

                {
                    extend: 'pdf',

                    title: 'Company name will Be Here',
                    exportOptions: {
                        columns: [0, 1, 2,3,4,5,6]

                    }

                },

                {
                    extend: 'print',
                    footer: true,
                    title: '{!!config('app.name')!!}',
                    exportOptions: {
                        columns: [0, 1, 2,3,4,5,6],
                        stripHtml: false
                    }


                }

            ]
        },
    });




    $('#sample_form').on('submit', function(event){
                event.preventDefault();
                let action_url = '';

                if($('#action').val() == 'Add')
                {
                    action_url = "{{ route('personal.car.hire.store') }}";
                }

                if($('#action').val() == 'Edit')
                {
                 action_url = "{{ route('personal.car.hire.update') }}";
                }


            $.ajax({
                url: action_url,
                method:"POST",
                data:$(this).serialize(),
                dataType:"json",
                success:function(data)
                {
                    var html = '';
                    if(data.errors)
                    {
                    html = '<div class="alert alert-danger">';
                    for(var count = 0; count < data.errors.length; count++)
                    {
                    html += '<p>' + data.errors[count] + '</p>';
                    }
                    html += '</div>';
                    }
                    if(data.success)
                    {
                    html = '<div class="alert alert-success">' + data.success + '</div>';
                    $('#sample_form')[0].reset();
                    resetHireForm();
                    getCarDataTable.ajax.reload();
                    setTimeout(()=>$('#modalForm').modal('hide'),1000);
                    }
                    $('#form_result').html(html);
                    
                },
                error:function(jqXHR,textStatus) {
                    console.log(jqXHR);
                    if(jqXHR.status === 419 || jqXHR.status === 401) {
                            alert('Something Went Wrong !! We are going to reload this Page after 5 seconds');
                            setTimeout(()=>{
                                location.reload();
                            },5000)
                    }
                }
            });
    });
        /// Get Edit Form Modal 

        $(document).on('click','.edit',function(){
              resetHireForm();
              let  id = $(this).attr('id');
                $('#form_result').html('');
                $.ajax({
                url :"/personal/car/hire/"+id+"/edit",
                dataType:"json",
                success:function(data)
                {
                    console.log(data);
                    insertDataEditForm(data.result);
                    $('#hidden_id').val(data.result.id);
                    $('.modal-title').text('Edit Record');
                    $('#action_button').val('Edit Hire Data');
                    $('#action').val('Edit');
                    $('#modalForm').modal('show');
                },
                error:function(jqXHR,textStatus) {
                    console.log(jqXHR);
                    if(jqXHR.status=== 419 || jqXHR.status === 401) {
                            alert('Something Went Wrong !! We are going to reload this Page after 5 seconds');
                            setTimeout(()=>{
                                location.reload();
                            },5000)
                    }
                }
                })
            
        });


       ///// Date Range Select
        $('.daterange-single').daterangepicker({ 
                singleDatePicker: true,
                drops:"up",
                startDate: moment(),
                locale: {
                format: 'YYYY-MM-DD'
            }
        });

        $('#hireEndDate').daterangepicker({
            singleDatePicker: true,
            drops:"up",
            autoUpdateInput:false,
            locale: {
                        format: 'YYYY-MM-DD'
                    }
        }, function(start) {
            console.log('date',start);
        $('#hireEndDate').val(start.format('YYYY-MM-DD'));
        });



$('.customer-select-search').select2();
$('.customer-select-search').select2().on("change", function(e) {
    $('.customerShow').show();
    $('.carShowSelect').show();
    var obj = $(".customer-select-search").select2("data");
    addCustomer(parseInt(obj[0].id))  // 0 or 1 on change
});



$('.car-select-search').select2();
$('.car-select-search').select2().on("change", function(e) {
    $('.carShow').show();
    var obj = $(".car-select-search").select2("data");
    addCar(parseInt(obj[0].id))  // 0 or 1 on change
});


let insertDataEditForm = (data) => {
  $('.customer-select-search').val(data.customer_id).trigger('change');
  $('.car-select-search').val(data.car_id).trigger('change');
  $('#hireStartDate').daterangepicker({ 
                singleDatePicker: true,
                startDate: data.hire_start_date,
                locale: {
                format: 'YYYY-MM-DD'
            }
        });

    $('#hireEndDate').val(data.hire_end_date);
    $('#hireRate').val(data.hire_rate);

}
let addCustomer = (id) => {
      
        let customer = customerList.find(customer => customer.id === id );
        if(customer) {
            selectedCustomerId = customer.id;
            
            let row = `
                    <tr>
                    <td>${customer.name}</td>
                    <td>${customer.address}</td>
                    <td>${customer.mobile}</td>
                    <td>${customer.email}</td>
                    <td>${customer.ni}</td>
                    </tr>
            `;

            $('.addCustomerRow').html(row);

        }
}

let addCar = (id) => {
    $('.showDisplay').show();
        let car = carList.find(car => car.id === id );
        if(car) {
            selectedCarId = car.id;
            
            let row = `
                    <tr>
                    <td>${car.name}</td>
                    <td>${car.reg_no}</td>
                    </tr>
            `;

            $('.addCarRow').html(row);

        }
}


let resetHireForm = () => {
    $('.customer-select-search').val(null).trigger('change');
    $('.car-select-search').val(null).trigger('change');
    selectedCarId = 0;
    selectedCustomerId = 0;
    $('.showDisplay').hide();
    $('.customerShow').hide();
    $('.carShow').hide();
    $('.carShowSelect').hide();
    $('#sample_form')[0].reset();
    $('#form_result').html('');


}

const formMessageShow = (message,type='info') => {
            (message==="")? display = 'd-none' : display = '';
            $('#payment_form_result').html(`<div class="${display} alert alert-${type} alert-rounded alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold">Message: </span>${message}</div>`);
        }
 /// Add PAyment Form
$(document).on('click', '.addPayment', function(){
            $('.modal-title').html('Add/Delete Payment');
            $('#modalPaymentForm').modal('toggle');
            hireId  = $(this).attr('id');
            $('#paymentBtn').prop('disabled',false);
            $('#hire_id').val(hireId)
            formMessageShow("");
               getPaymentData(hireId);
});
    //// Submit Form 
    $('#paymentForm').on('submit', function(event){
          event.preventDefault();
        $('#paymentBtn').prop('disabled',true);
         let request =   $.ajax({
                            url: "{{route('personal.car.hire.payment')}}",
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
                $('#paymentBtn').prop('disabled',false);
            }
            else {
                formMessageShow(`${msg.success}`,'success');
                $('#paymentForm')[0].reset();
                getPaymentData(hireId);
                getCarDataTable.ajax.reload(null, false);
                $('#paymentBtn').prop('disabled',false);

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
                    $('#paymentBtn').prop('disabled',false);
         });
                        
    });



    let getPaymentData = (hireId) => {
            $.ajax({
            url: "/personal/car/hire/payment",
            dataType: 'JSON',
            data: {hireId,_token:CSRF_TOKEN},
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
                        $('#modalPaymentForm').modal('toggle');
                    },2000);
                    return;
                }

                setTimeout(()=>{
                        $('#modalPaymentForm').modal('toggle');
                    },5000);

            $('.payment-header').html(`<h1 class="text-danger-800 ">Internal Server Error</h1>`);
            }

            });
    } 

    let deletePayment = (id) => {

        
            $.ajax({
            url: "/personal/car/hire/payment/destroy",
            type:'POST',
            dataType: 'JSON',
            data: {paymentId:id,_token:CSRF_TOKEN},
            beforeSend: function() {
                $('.payment-header').html(`<h1 class="text-danger-800 ">Wait We are Deleteing...</h1>`);
               
            },
            success: function(response) {

                if(response.success === true) {
                    $('.payment-header').html(`<h1 class="text-success-800 ">Deleted SuccessFully</h1>`);
                    getCarDataTable.ajax.reload(null, false);
                }
                setTimeout(() => {
                    $('.payment-header').html(`<h6 class="card-title "><b>Previous Payment Hisotry</b></h6>`);
                },2000);
            },
            error: function(xhr, error) {
                if (xhr.readyState == 0 && xhr.status != 200) {
                    pAlertError('Oppss Offline','Please Check Your Internet Connection');
                    setTimeout(()=>{
                        $('#modalPaymentForm').modal('toggle');
                    },2000);
                    return;
                }

                setTimeout(()=>{
                        $('#modalPaymentForm').modal('toggle');
                    },5000);

            $('.payment-header').html(`<h1 class="text-danger-800 ">Internal Server Error</h1>`);
            },
            complete:function() {
                getPaymentData(hireId);
            }

            });

    }


    $(document).on('click', '.delete', function(){
                hireId = $(this).attr('id');
                $('#confirmModal').modal('show');
                
    });
    

    $('#confirm_btn').click(function(){
                
            $.ajax({
                        url: "{{route('personalCarDelete')}}",
                        method:"POST",
                        data: {id:hireId, _token: CSRF_TOKEN},
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
                            getCarDataTable.ajax.reload(null, false);
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

    $(document).on('click', '.endHire', function(){
                hireId = $(this).attr('id');
                $.ajax({
                        url: "{{route('personalCarHireEnd')}}",
                        method:"POST",
                        data: {id:hireId, _token: CSRF_TOKEN},
                        dataType:'json',
                        beforeSend:function(){
                           pAlertError("Ending","Please Wait For Processing");
                        },
                        success:function(data)
                        {   PNotify.removeAll();
                            if(data.success){
                   
                             pAlertSuccess("Success","Hire End");
                              getCarDataTable.ajax.reload(null, false);
                            }else {
                                pAlertError('Error',data.error);
                            }
         

                        },
                        error:function(jqXHR, textStatus) { 
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







</script>
@endsection