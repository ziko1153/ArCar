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

      <!-- DataTable of Car list -->
  <div class="card">
    <div class="card-header header-elements-inline  ">
      <h2 class="card-title font-weight-bold text-uppercase">Personal Car Add List</h2>
 
      <button type="button" class="btn bg-warning addCarBtn" data-toggle="modal" data-target="#modalForm">Add Car<i class="icon-play3 ml-2"></i></button>

    </div>

    <div class="card-body border-top-1">
      <table class="table datatable-basic table-hover table-bordered" style="font-size:1rem">
        <thead class="bg-dark">
          <tr>
            <th>Sl.</th>
            <th>Car Name</th>
            <th>Registration No</th>
            <th>Hire Status</th>
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
            <label class="col-form-label col-lg-2">Car Name:</label>
            <div class="col-lg-10">
                <div class="form-group-feedback form-group-feedback-right">
                <input type="text" class="form-control" placeholder="Enter Car Name" name="car_name" value="">
                </div>
           
            </div>
       
        </div>

        <div class="form-group row">
            <label class="col-form-label col-lg-2">Reg No:</label>
            <div class="col-lg-10">
                <div class="form-group-feedback form-group-feedback-right">
                <input
                 type="text" 
                 class="form-control" 
                  placeholder="Enter Reg No" 
                  name="reg_no"
                  value=""
                  />
                </div>
            </div>
          
        </div>





        <div class="form-group row mb-0">
            <div class="col-lg-10 ml-lg-auto">
                <div class="d-flex justify-content-between align-items-center">
                 <input type="hidden" name="action" id="action" value="Add" />
                 <input type="hidden" name="hidden_id" id="hidden_id" />
                 <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add Car" />
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
$('.addCarBtn').click(function(){
  $('.modal-title').text('Add New Car');
  $('#action_button').val('Add Car');
  $('#action').val('Add');
  $('#form_result').html('');
  $('#sample_form')[0].reset();

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

    let getCarDataTable = $('.datatable-basic').DataTable({
        processing: true,
        'serverSide': true,
        'ordering': true,
        'order': [],
        'ajax': {
            url: "{{route('personal.car.add.showajax')}}",
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
                {data: 'car_name'},
                {data: 'reg_no'},
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
                    action_url = "{{ route('personal.car.add.store') }}";
                }

                if($('#action').val() == 'Edit')
                {
                 action_url = "{{ route('personal.car.add.update') }}";
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
            
              let  id = $(this).attr('id');
                $('#form_result').html('');
                $.ajax({
                url :"/personal/car/add/"+id+"/edit",
                dataType:"json",
                success:function(data)
                {
                    $("input[name*='car_name']").val(data.result.car_name);
                    $("input[name*='reg_no']").val(data.result.reg_no);
                    $('#hidden_id').val(id);
                    $('.modal-title').text('Edit Record');
                    $('#action_button').val('Edit Car Data');
                    $('#action').val('Edit');
                    $('#modalForm').modal('show');
                },
                error:function(jqXHR,textStatus) {
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
                startDate: moment(),
                locale: {
                format: 'YYYY-MM-DD'
            }
        });

        //// Delete Car List

        $(document).on('click', '.delete', function(){
                CarId = $(this).attr('id');
                $('#confirmModal').modal('show');
                $('.modal-title').text('Delete Record');
        });

        $('#confirm_btn').click(function(){
            
            $.ajax({
                    url: "{{route('personalCarDelete')}}",
                    method:"POST",
                    data: {id:CarId, _token: CSRF_TOKEN},
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
                        //alert('Internal Server Error');
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



</script>
@endsection