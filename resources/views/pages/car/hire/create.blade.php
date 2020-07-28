@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8 ">

    
<div class="card">
    <div class="card-header header-elements-inline">
        <h1 class="card-title">Car Hire Form</h1>
      
    </div>

    <div class="card-body">
        <form action="/car/hire" method="post">
                @csrf
            <div class="form-group row">
                <label class="col-form-label col-lg-2">Car Name:</label>
                <div class="col-lg-10">
                    <div class="form-group-feedback form-group-feedback-right">
                    <input type="text" class="form-control @error('car_name') border-danger @enderror " placeholder="Enter Car Name" name="car_name" value="{{old('car_name')}}">

                    @error('car_name')
                    <div class="form-control-feedback text-danger">
                        <i class="icon-cancel-circle2"></i>
                    </div>
                    @enderror

                    </div>
                    @error('car_name')
                    <span class="form-text text-danger">{{$errors->first('car_name')}}</span>
                    @enderror
                </div>
           
            </div>

            <div class="form-group row">
                <label class="col-form-label col-lg-2">Car Price:</label>
                <div class="col-lg-10">
                    <div class="form-group-feedback form-group-feedback-right">
                    <input
                     type="number" 
                     class="form-control
                      @error('car_price') border-danger @enderror " 
                      placeholder="Enter Car Price" 
                      name="car_price" 
                      value="{{old('car_price')}}"
                      step="0.01"
                      min="0"
                      
                      />

                    @error('car_price')
                    <div class="form-control-feedback text-danger">
                        <i class="icon-cancel-circle2"></i>
                    </div>
                    @enderror

                    </div>
                    @error('car_price')
                    <span class="form-text text-danger">{{$errors->first('car_price')}}</span>
                @enderror
                </div>
              
            </div>

            <div class="form-group row">
                <label class="col-form-label col-lg-2">Reg No:</label>
                <div class="col-lg-10">
                    <div class="form-group-feedback form-group-feedback-right">
                    <input type="text" class="form-control @error('reg_no') border-danger @enderror " placeholder="Enter Reg No" name="reg_no" value="{{old('reg_no')}}">

                    @error('reg_no')
                    <div class="form-control-feedback text-danger">
                        <i class="icon-cancel-circle2"></i>
                    </div>
                    @enderror

                    </div>
                    @error('reg_no')
                    <span class="form-text text-danger">{{$message}}</span>
                        @enderror
                </div>
              
            </div>

            <div class="form-group row">
                <label class="col-form-label col-lg-2">Auction Name:</label>
                <div class="col-lg-10">
                    <div class="form-group-feedback form-group-feedback-right">
                    <input type="text" class="form-control @error('auction_name') border-danger @enderror " placeholder="Enter Auction Name" name="auction_name" value="{{old('auction_name')}}">

                    @error('auction_name')
                    <div class="form-control-feedback text-danger">
                        <i class="icon-cancel-circle2"></i>
                    </div>
                    @enderror

                    </div>
                    @error('auction_name')
                    <span class="form-text text-danger">{{$message}}</span>
                        @enderror
                </div>
              
            </div>

            <div class="form-group row">
                <label class="col-form-label col-lg-2">Auction Place:</label>
                <div class="col-lg-10">
                    <div class="form-group-feedback form-group-feedback-right">
                    <input type="text" class="form-control " placeholder="Enter Auction Place" name="auction_place" value="{{old('auction_place')}}">


                    </div>
                </div>
              
            </div>

            <div class="form-group row">
                <label class="col-form-label col-lg-2">Parking Place:</label>
                <div class="col-lg-10">
                    <div class="form-group-feedback form-group-feedback-right">
                    <input type="text" class="form-control " placeholder="Enter Parking Place Name " name="parking_place" value="{{old('parking_place')}}">

                  
                </div>
              
            </div>
           </div>

            <div class="form-group row">
                
                <label  class="col-form-label col-lg-2">Buying Date:</label>
                    <div class="col-lg-10 input-group">
                     
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-calendar22"></i></span>
                        </span>
                    <input type="text" class="form-control daterange-single  @error('buying_date') border-danger @enderror" value="{{old('buying_date')}}" name="buying_date">
                        <br>
                      
                  
                      
                        
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