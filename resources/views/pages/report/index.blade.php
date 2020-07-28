@extends('layouts.app')

@section('extra-header')
<script src="/global_assets/js/plugins/notifications/pnotify.min.js"></script>

@endsection
    

@section('content')

<div class="row ">
    <div class="col-md-12 ">

        <form  class="reportForm">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="reportSelect">Select Report</label>
                    <select class="form-control" id="reportSelect" name="reportSelect">
                        <option value="" selected >Select Report First</option>
                    <option value="1">Car Available Report</option>
                    {{-- <option value="2">Loss/Profit Report</option> --}}

                    </select>
                </div>
                <div class="form-group col-md-3">
                <label for="startDate">Start Date:</label>
                <input type="text" name="startDate" class="form-control " placeholder="Start Date" id="startDate">
                </div>
                <div class="form-group col-md-3">
                <label for="endDate">End Date:</label>
                <input type="text" name="endDate" class="form-control daterange-single" id="endDate" placeholder="End Date">
                </div>
                <div class="form-group col-md-3">
                    <button type="submit" class="btn btn-primary mt-4">Search Report</button>
                </div>
            </div>
            

            
        </form>

        
    </div>
</div>

{{-- Generate Report --}}

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-light header-elements-inline">
                <h6 class="card-title report-title">Select Report First</h6>
                <div class="header-elements">
                    <div class="list-icons">
                       <button id="printBtn" class="btn btn-success btn-lg"><i class="icon-printer mr-2"></i> Print</button>
                    </div>
                </div>
            </div>

            <div class="card-body showDisplay" id="printArea">
                <div class="d-flex justify-content-center mb-2">
                    <div class="companyDetails">
                        <h2 style="margin: 0">{{ config('app.name', 'AR Car Hire & Sale') }}</h2>
                        <h4 id="reportName" style="padding-left: 20px;margin:0"></h4>
                        <span id="dateShow"></span>
                    </div>
                </div>
               <div class="row">
                   <div class="col-md-4">
                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h5 class="card-title">Statistics</h5>
                        </div>
    
    
                        <div class="table-responsive">
                            <table class="table table-bordered">

                                <tbody class="statisticBody" style="text-transform: capitalize">
                                 
                                </tbody>
                            </table>
                        </div>
                    </div>

                   </div>
                   <div class="col-md-8">
                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h5 class="card-title">Details</h5>
                        </div>
    
    
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" style="text-transform: capitalize">
                                <thead class="detailsHeader">
                                  
                                </thead>
                                <tbody class="detailsBody" >
                                  
                                </tbody>
                            </table>
                        </div>
                    </div>
                   </div>
               </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('extra-script')
<script type="text/javascript" defer>
 
 $('#startDate').daterangepicker({ 
                singleDatePicker: true,
                startDate: moment().subtract(7, 'days'),
                locale: {
                format: 'MMMM D, YYYY'
            }
        });

 $('#endDate').daterangepicker({ 
                singleDatePicker: true,
                startDate: moment(),
                locale: {
                format: 'MMMM D, YYYY'
            }
 });

 
 $('#reportSelect').on('change',(e)=>{
     let reportName = e.target.options[e.target.selectedIndex].text;
     $('#reportName').text(reportName);
     $('.report-title').html(reportName);

 })
 
$('.reportForm').on('submit', function(event){

                event.preventDefault();
                dateChange();
                $.ajax({
                url: '/report/ajax',
                method:"POST",
                data:$(this).serialize(),
                dataType:"json",
                success:function(data)
                {   
                    if(data.type){
                      (data.type == 'car_available') ? sanitizieCarAvailabelReport(data) : '';
                    }else if(data.errors){
                        let errorNo = 1;
                        data.errors.forEach(error => {
                            pAlertError(`Error No: ${errorNo++}`,error);
                        })
                    }else {
                        pAlertError('Sorry','Invalid Report.. Its Pending')
                    }

                },
                error:function(jqXHR,textStatus) {
                    alert('Inertnal Server Error');
                    console.log(jqXHR);
                    if(jqXHR.status === 419 || jqXHR.status === 401) {
                        alert('Something Went Wrong !! We are going to reload this Page after 5 seconds');
                            pAlertError('Something Went Wrong !! We are going to reload this Page after 5 seconds');
                            setTimeout(()=>{
                                location.reload();
                            },5000)
                    }
                }

            });
});



let sanitizieCarAvailabelReport = (data) => {
    generateStatisticData(data.statistic)

    generateDetailsRowData(data.row)

}


let generateStatisticData = (data) => {

        $list = '';

         for (const [key, value] of Object.entries(data)) {
                 $list += ` <tr>
                                <td>${textCapitalize(key)}</td>
                                <td>${value}</td>

                            </tr>`;
        }

        $('.statisticBody').html($list);



    
}

let generateDetailsRowData = (data) => {
   let listHeader =  `<tr>`;
   let  listBody = ``;
    if(data.length>0) {
        for (const [key, value] of Object.entries(data[0])) {
                 listHeader += ` <th>${textCapitalize(key)}</th>`;
        }
        listHeader += `</tr>`;
    }
    $('.detailsHeader').html(listHeader);

    data.forEach(element => {
        let tableRow = '<tr>';
         let tableData = '';   
        for (const [key, value] of Object.entries(element)) {
                 tableData += `<td>${value}</td>`;
        }
       listBody +=  tableRow+tableData+'</tr>';
        
    });

    $('.detailsBody').html(listBody);


}

let textCapitalize = (str) => {

    return  str.split('_').join(' ');
}

$('#printBtn').on('click',function(){
    let printContents, popupWin;
        printContents = document.getElementById('printArea').innerHTML;
        popupWin = window.open();
        popupWin.document.open();
        popupWin.document.write(`
          <html>
            <head>
                <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
            </head>
            <style>

            </style>
        <body onload="window.print();window.close()">${printContents}</body>
          </html>`
        );
        popupWin.document.close();
});

let dateChange = () => {
    let startDate = $('#startDate').val();
    let endDate = $('#endDate').val();

    let dateShow = `Form: ${startDate} To: ${endDate}`;
    $('#dateShow').html(dateShow);
}

let  pAlertError = (title, text)  => {
    new PNotify({
        title: title,
        text: text,
        addclass: 'bg-danger border-danger'
    });
}

</script>
@endsection