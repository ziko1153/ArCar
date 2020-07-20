@extends('layouts.app')

@section('extra-header')
   <!-- For Data Table -->
   <script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
   <script src="/global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
   <script src="/global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js"></script>
   <script src="/global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"></script>
   <script src="/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>


@endsection
    

@section('content')

<div class="row ">
    <div class="col-md-12 ">

      <!-- DataTable of Customer list -->
  <div class="card">
    <div class="card-header header-elements-inline  ">
      <h2 class="card-title font-weight-bold text-uppercase">Customer List</h2>
 
      <button type="button" class="btn bg-primary addCustomerBtn" data-toggle="modal" data-target="#modalForm">Add Customer<i class="icon-play3 ml-2"></i></button>

    </div>

    <div class="card-body border-top-1">
      <table class="table datatable-basic table-hover table-bordered" style="font-size:1rem">
        <thead class="bg-dark">
          <tr>
            <th>Sl.</th>
            <th>Customer Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Address</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
  <!-- /DataTable of Customer list -->
    
</div>
</div>
{{--  Modal Form --}}

@section('modal-content')

    <div class="modal-body">
        <span id="form_result"></span>
<form method="post" class="form-horizontal" id="sample_form">
        
        @csrf
        <div class="form-group row">
            <label class="col-form-label col-lg-2">Customer Name:</label>
            <div class="col-lg-10">
                <div class="form-group-feedback form-group-feedback-right">
                <input type="text" class="form-control" placeholder="Enter Car Name" name="cust_name" value="">
                </div>
           
            </div>
       
        </div>

        <div class="form-group row">
            <label class="col-form-label col-lg-2">Customer Mobile:</label>
            <div class="col-lg-10">
                <div class="form-group-feedback form-group-feedback-right">
                <input
                 type="number" 
                 class="form-control" 
                  placeholder="Enter Customer  Email" 
                  name="cust_mobile"
                  value=""
                  min="0"
                  />
                </div>
            </div>
          
        </div>

        <div class="form-group row">
            <label class="col-form-label col-lg-2">Customer Email:</label>
            <div class="col-lg-10">
                <div class="form-group-feedback form-group-feedback-right">
                <input type="email" class="form-control " placeholder="Enter Customer Email Address" name="cust_email" value="">

                </div>
                
            </div>
          
        </div>

        <div class="form-group row">
            <label class="col-form-label col-lg-2">Customer Address:</label>
            <div class="col-lg-10">
                <div class="form-group-feedback form-group-feedback-right">
                <input type="text" class="form-control " placeholder="Enter Customer Address" name="cust_address" value="">

                </div>
            </div>
          
        </div>



        <div class="form-group row mb-0">
            <div class="col-lg-10 ml-lg-auto">
                <div class="d-flex justify-content-between align-items-center">
                 <input type="hidden" name="action" id="action" value="Add" />
                 <input type="hidden" name="hidden_id" id="hidden_id" />
                 <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add Customer" />
                </div>
            </div>
        </div>
    </form>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
    </div>


@endsection

@include('layouts.confirmModal');


@endsection

@section('extra-script')
<script type="text/javascript" defer>
 let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$('.addCustomerBtn').click(function(){
  $('.modal-title').text('Add New Customer');
  $('#action_button').val('Add');
  $('#action').val('Add');
  $('#form_result').html('');

 });

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
    let getCustomerDataTable = $('.datatable-basic').DataTable({
        processing: true,
        'serverSide': true,
        'ordering': true,
        'order': [],
        'ajax': {
            url: "{{route('customer.showajax')}}",
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
                {data: 'cust_name'},
                {data: 'cust_email'},
                {data: 'cust_mobile'},
                {data: 'cust_address'},
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
                        columns: [0, 1, 2,3]
                    }

                },

                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2,3]
                    }
                },

                {
                    extend: 'pdf',

                    title: 'Company name will Be Here',
                    exportOptions: {
                        columns: [0, 1, 2,3]

                    }

                },

                {
                    extend: 'print',
                    footer: true,
                    title: '{!!config('app.name')!!}',
                    exportOptions: {
                        columns: [0, 1, 2,3],
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


    $('#sample_form').on('submit', function(event){
                event.preventDefault();
                let action_url = '';

                if($('#action').val() == 'Add')
                {
                    action_url = "{{ route('customer.store') }}";
                }

                if($('#action').val() == 'Edit')
                {
                 action_url = "{{ route('customer.update') }}";
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
                    getCustomerDataTable.ajax.reload();
                    }
                    $('#form_result').html(html);
                }
            });
    });
        /// Get Edit Form Modal 

        $(document).on('click','.edit',function(){
            let id  = $(this).attr('id');
            $('#modalForm').modal('show');
            $('#editForm').css('display','none');
            formMessageShow('Getting Data From Server....');
            let request = $.ajax({
                url: "/car/hire/"+id+"/edit",
                data: {
                 id:id
                 },
                dataType: "json"
                });
            
                request.done(function( msg ) {
                    console.log(msg);
                    if(msg.response === 'success'){
                        $( "input[name*='car_name']" ).val(msg.data.car_name);
                        $( "input[name*='reg_no']" ).val(msg.data.reg_no);
                        $( "input[name*='car_price']" ).val(msg.data.car_price);
                        $( "input[name*='auction_name']" ).val(msg.data.auction_name);
                        $( "input[name*='auction_place']" ).val(msg.data.acution_place);
                        $( "input[name*='buying_date']" ).val(msg.data.buying_date);
                        $( "input[name*='parking_place']" ).val(msg.data.parking_place);
                        $( "#hidden_id" ).val(msg.data.id);
                        $('#editForm').css('display','');
                        formMessageShow('');
                        $('.modal-title').text('Edit Record');
                        

                    }

                });
            
                request.fail(function( jqXHR, textStatus ) {
                    formMessageShow(`Server Error ${textStatus}`,'danger');
                });
            
        });

        //// Submit Form 
       $('#editForm').on('submit', function(event){
          event.preventDefault();

         let request =   $.ajax({
                            url: "{{route('car.update')}}",
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
                $('#editForm')[0].reset();
                getCarListDataTable.ajax.reload(null, false);
            }
         });
        
        request.fail(function( jqXHR, textStatus ) {
            formMessageShow(`Internal Server ${textStatus} Failed Edit  ${jqXHR} `,'danger');
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
                carId = $(this).attr('id');
                $('#confirmModal').modal('show');
                
        });

        $('#confirm_btn').click(function(){
            
            $.ajax({
                    url: "{{route('car.delete')}}",
                    method:"POST",
                    data: {id:carId, _token: CSRF_TOKEN},
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
                        getCarListDataTable.ajax.reload(null, false);
                    },
                    error:function(jqXHR, textStatus) { 
                        $('#confirm_btn').prop('disabled', false);
                        $('#confirm_btn').text('Delete');
                        alert('Internal Server Error');
                        console.log(jqXHR,textStatus);
                    }
            });
        });



</script>
@endsection