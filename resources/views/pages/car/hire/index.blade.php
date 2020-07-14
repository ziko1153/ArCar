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
      <h5 class="card-title font-weight-bold text-uppercase">View All Products</h5>
    </div>
    <div class="card-body border-top-1">
      <table class="table datatable-basic table-hover table-bordered">
        <thead class="bg-dark">
          <tr>
              <th>Sl.</th>
            <th>Car Name</th>
            <th>Car Price</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
  <!-- /DataTable of Product list -->
    
</div>
</div>

@endsection

@section('extra-script')
<script type="text/javascript" defer>
 var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
console.log(CSRF_TOKEN);

// $.ajax({
//         url: "{{route('car.showajax')}}",
//         type:"POST",
//         data:{
//           name:'ziko',
//           email:'hello@',
//           _token: CSRF_TOKEN

//         },
//         success:function(response){
//           console.log(response);
//           if(response) {
            
//           }
//         },
//         error:function(err) {
//             console.log('Error',err);
            
//         }
//        });

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
    var getProductList = $('.datatable-basic').DataTable({
        'processing': true,
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

{data:'id'},
{data: 'car_name'},
{data: 'car_price'},
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
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    }

                },

                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    }
                },

                {
                    extend: 'pdf',

                    title: 'Company name will Be Here',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]

                    }

                },

                {
                    extend: 'print',
                    footer: true,
                    title: 'Company name will Be Here',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                        stripHtml: false
                    }


                }

            ]
        },
    });



</script>
@endsection