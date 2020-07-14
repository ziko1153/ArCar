@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    @if($hire)
    <div class="col-md-8 ">

        
        <div class="card">
            <div class="card-header header-elements-inline">
                <h1 class="card-title">Edit Car Hire Form</h1>
            </div>

            <div class="card-body">
                <form action="/car/hire/{{$hire->id}}" method="post">
                        @csrf
                        @method('PUT')
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Car Name:</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" placeholder="Enter Car Name" name="car_name" value="{{$hire->car_name}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Car Price:</label>
                        <div class="col-lg-10">
                            <input type="number" class="form-control" placeholder="Enter Car Price" name="car_price" step="0.01" min="0">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Car Reg No.:</label>
                        <div class="col-lg-10">
                            <textarea rows="3" cols="3" class="form-control" placeholder="Enter Car Reg. No." name="reg_no"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        
                        <label  class="col-form-label col-lg-2">Buying Date:</label>
                            <div class="col-lg-10 input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                </span>
                                <input type="text" class="form-control daterange-single" value="03/18/2013" name="buying_date">
                            </div>
                        
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-lg-10 ml-lg-auto">
                            <div class="d-flex justify-content-between align-items-center">
                                <button type="submit" class="btn bg-blue">Hire Car <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @else 
    <div class="col-md-4">
        <h2>Sorry Something Went Wrong With Route</h2>
    </div>
    @endif
</div>

@endsection

@section('extra-script')
<script>
     $('.daterange-single').daterangepicker({ 
            singleDatePicker: true,
            startDate: moment(),
            locale: {
            format: 'YYYY-MM-DD'
        }
     });
</script>
@endsection