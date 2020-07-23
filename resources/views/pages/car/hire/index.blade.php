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

      <!-- DataTable of Product list -->
  <div class="card">
    <div class="card-header header-elements-inline ">
      <h5 class="card-title font-weight-bold text-uppercase">Car Hire List</h5>
      @if(Session::has('message'))
        
            <div id="showAddMessage" class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                <span class="font-weight-semibold">Well done!</span>{{Session::get('message')}}
            </div>
      
    @endif


    </div>
    <div class="card-body border-top-1">
      <table class="table datatable-basic table-hover table-bordered" style="font-size:1rem">
        <thead class="bg-dark">
          <tr>
            <th>Sl.</th>
            <th>Reg No.</th>
            <th>Car Name</th>
            <th>Price</th>
            <th>Auction</th>
            <th>Parking Place</th>
            <th>Buying Date</th>
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
<form method="post" class="form-horizontal" id="editForm">
        
        @csrf
        <div class="form-group row">
            <label class="col-form-label col-lg-2">Car Name:</label>
            <div class="col-lg-10">
                <div class="form-group-feedback form-group-feedback-right">
                <input type="text" class="form-control" placeholder="Enter Car Name" name="car_name" value="">
                </div>
           
            </div>
       
        </div>

        <div class="form-group row">
            <label class="col-form-label col-lg-2">Car Price:</label>
            <div class="col-lg-10">
                <div class="form-group-feedback form-group-feedback-right">
                <input
                 type="number" 
                 class="form-control" 
                  placeholder="Enter Car Name" 
                  name="car_price" 
                  value=""
                  step="0.01"
                  min="0"
                  
                  />
                </div>
            </div>
          
        </div>

        <div class="form-group row">
            <label class="col-form-label col-lg-2">Reg No:</label>
            <div class="col-lg-10">
                <div class="form-group-feedback form-group-feedback-right">
                <input type="text" class="form-control " placeholder="Enter Car Name" name="reg_no" value="">

                </div>
                
            </div>
          
        </div>

        <div class="form-group row">
            <label class="col-form-label col-lg-2">Auction Name:</label>
            <div class="col-lg-10">
                <div class="form-group-feedback form-group-feedback-right">
                <input type="text" class="form-control " placeholder="Enter Car Name" name="auction_name" value="">

                </div>
            </div>
          
        </div>

        <div class="form-group row">
            <label class="col-form-label col-lg-2">Auction Place:</label>
            <div class="col-lg-10">
                <div class="form-group-feedback form-group-feedback-right">
                <input type="text" class="form-control " placeholder="Enter Auction Place" name="auction_place" value="">


                </div>
            </div>
          
        </div>

        <div class="form-group row">
            <label class="col-form-label col-lg-2">Parking Place:</label>
            <div class="col-lg-10">
                <div class="form-group-feedback form-group-feedback-right">
                <input type="text" class="form-control " placeholder="Enter Parking Place Name " name="parking_place" value="">

              
            </div>
          
        </div>
       </div>

        <div class="form-group row">
            
            <label  class="col-form-label col-lg-2">Buying Date:</label>
                <div class="col-lg-10 input-group">
                 
                    <span class="input-group-prepend">
                        <span class="input-group-text"><i class="icon-calendar22"></i></span>
                    </span>
                <input type="text" class="form-control daterange-single " value="" name="buying_date">
                    <br>
                  
              
                    
                </div>
            
        </div>

        <div class="form-group row mb-0">
            <div class="col-lg-10 ml-lg-auto">
                <div class="d-flex justify-content-between align-items-center">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <button type="submit" class="btn bg-primary">Edit Hire Car <i class="icon-paperplane ml-2"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
    </div>
</form>

@endsection

@include('layouts.confirmModal');


@endsection

@section('extra-script')
<script type="text/javascript" defer>
 let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

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
    let getCarListDataTable = $('.datatable-basic').DataTable({
        processing: true,
        'serverSide': true,
        'ordering': true,
        'order': [],
        'ajax': {
            url: "{{route('car.showajax')}}",
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
                {data:'reg_no'},
                {data: 'car_name'},
                {data: 'car_price'},
                {data: 'auction_name'},
                {data: 'parking_place'},
                {data: 'buying_date'},
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
                    extend: 'copy'

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
                    if(jqXHR.status=== 419 || jqXHR.status === 401) {
                            alert('Something Went Wrong !! We are going to Reload this Page after 5 seconds');
                            setTimeout(()=>{
                                location.reload();
                            },5000)
                    }
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
                        if(jqXHR.status=== 419 || jqXHR.status === 401) {
                            alert('Something Went Wrong !! We are going to Reload this Page after 5 seconds');
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



</script>
@endsection