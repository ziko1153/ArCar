@extends('layouts.app')

@section('extra-header')
 
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
                    <option value="1">Car Available</option>
                    <option value="2">Loss/Profit</option>

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
                <h6 class="card-title">Select Report First</h6>
                <div class="header-elements">
                    <div class="list-icons">
                       <button class="btn btn-success btn-lg"><i class="icon-printer mr-2"></i> Print</button>
                    </div>
                </div>
            </div>

            <div class="card-body showDisplay">
               <div class="row">
                   <div class="col-md-4">
                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h5 class="card-title">Statistics</h5>
                        </div>
    
    
                        <div class="table-responsive">
                            <table class="table table-bordered">

                                <tbody class="statisticBody">
                                    <tr>
                                        <td>1</td>
                                        <td>Eugene</td>

                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Victoria</td>

                                    </tr>
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
                            <table class="table table-bordered table-striped">
                                <thead class="detailsHeader">
                                    <tr>
                                        <th>#</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Username</th>
                                    </tr>
                                </thead>
                                <tbody class="detailsBody">
                                    <tr>
                                        <td>1</td>
                                        <td>Eugene</td>
                                        <td>Kopyov</td>
                                        <td>@Kopyov</td>
                                    </tr>
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

        $('.reportForm').on('submit', function(event){
                event.preventDefault();

                $.ajax({
                url: '/report/ajax',
                method:"POST",
                data:$(this).serialize(),
                dataType:"json",
                success:function(data)
                {
                    console.log(data);

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


</script>
@endsection