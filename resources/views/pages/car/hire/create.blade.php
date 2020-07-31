@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8 ">

    
<div class="card">
    <div class="card-header header-elements-inline">
        <h1 class="card-title">Car Buying Form</h1>
        @if(count($errors)>0)
        <div class="alert text-violet-800 alpha-violet border-violet alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold">Surprise!</span> There is a Error.Please Fixed That
        </div>
        @endif
      
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
                     type="text" 
                     class="form-control checkForDot
                      @error('car_price') border-danger @enderror " 
                      placeholder="Enter Car Price" 
                      name="car_price" 
                      value="{{old('car_price')}}"
                      step="0.01"
                      min="0"
                      id="car_price"
                      
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
                <label class="col-form-label col-lg-2">Auction Fee:</label>
                <div class="col-lg-10">
                    <div class="form-group-feedback form-group-feedback-right">
                    <input
                     type="text" 
                     class="form-control checkForDot
                      @error('auction_fee') border-danger @enderror " 
                      placeholder="Enter Auction Fee" 
                      name="auction_fee" 
                      value="{{old('auction_fee')}}"
                      step="0.01"
                      min="0"
                      id="auction_fee"
                      
                      />

                    @error('auction_fee')
                    <div class="form-control-feedback text-danger">
                        <i class="icon-cancel-circle2"></i>
                    </div>
                    @enderror

                    </div>
                    @error('auction_fee')
                    <span class="form-text text-danger">{{$errors->first('auction_fee')}}</span>
                @enderror
                </div>
              
            </div>


            
            <div class="form-group row">
                <label class="col-form-label col-lg-2">Storage Fee:</label>
                <div class="col-lg-10">
                    <div class="form-group-feedback form-group-feedback-right">
                    <input
                     type="text" 
                     class="form-control checkForDot
                      @error('storage_fee') border-danger @enderror " 
                      placeholder="Enter Storage Fee" 
                      name="storage_fee" 
                      value="{{old('storage_fee')}}"
                      step="0.01"
                      min="0"
                      id="storage_fee"
                      
                      />

                    @error('storage_fee')
                    <div class="form-control-feedback text-danger">
                        <i class="icon-cancel-circle2"></i>
                    </div>
                    @enderror

                    </div>
                    @error('storage_fee')
                    <span class="form-text text-danger">{{$errors->first('storage_fee')}}</span>
                @enderror
                </div>
              
            </div>

            
            <div class="form-group row">
                <label class="col-form-label col-lg-2">Transport Fee:</label>
                <div class="col-lg-10">
                    <div class="form-group-feedback form-group-feedback-right">
                    <input
                     type="text" 
                     class="form-control checkForDot 
                      @error('transport_fee') border-danger @enderror " 
                      placeholder="Enter Transport Fee" 
                      name="transport_fee" 
                      value="{{old('transport_fee')}}"
                      step="0.01"
                      min="0"
                      id="transport_fee"
                      
                      />

                    @error('transport_fee')
                    <div class="form-control-feedback text-danger">
                        <i class="icon-cancel-circle2"></i>
                    </div>
                    @enderror

                    </div>
                    @error('transport_fee')
                    <span class="form-text text-danger">{{$errors->first('transport_fee')}}</span>
                @enderror
                </div>
              
            </div>

            
            <div class="form-group row">
                <label class="col-form-label col-lg-2">Expense Fee:</label>
                <div class="col-lg-10">
                    <div class="form-group-feedback form-group-feedback-right">
                    <input
                     type="text" 
                     class="form-control checkForDot 
                      @error('expense_fee') border-danger @enderror " 
                      placeholder="Enter Expense Fee" 
                      name="expense_fee" 
                      value="{{old('expense_fee')}}"
                      step="0.01"
                      min="0"
                      id="expense_fee"
                      
                      />

                    @error('expense_fee')
                    <div class="form-control-feedback text-danger">
                        <i class="icon-cancel-circle2"></i>
                    </div>
                    @enderror

                    </div>
                    @error('expense_fee')
                    <span class="form-text text-danger">{{$errors->first('expense_fee')}}</span>
                @enderror
                </div>
              
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-2">Total Buying Price</label>
            <div class="col-lg-10 text-center" style="font-size:2rem">
                    <span id="total_buying_price">£ 0</span>
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
            <label class="col-lg-3 col-form-label">Delivery Status:</label>
            <div class="col-lg-9">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="delivery" id="inlineRadio1" value="yes" @if(old('delivery')==='yes') checked ="checked" @endif>
                    <label class="form-check-label mt-1" for="inlineRadio1">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="delivery" id="inlineRadio2" value="no" @if(old('delivery')==='no') checked ="checked" @endif >
                    <label class="form-check-label mt-1"  for="inlineRadio2">No</label>
                  </div>
            </div>
        </div>

          
        <div class="form-group row">
            <label class="col-form-label col-lg-2">Comment:</label>
            <div class="col-lg-10">
                <div class="form-group-feedback form-group-feedback-right">
                <input type="text" class="form-control " placeholder="Enter Some Comments " name="comment" value="{{old('comment')}}">

              
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
                        <button type="submit" class="btn bg-blue"><i class="icon-paperplane mr-2"></i>Buying Car </button>
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
<script defer style="text/javascript" >

// $('.form-input-styled').uniform({
//             // fileButtonClass: 'action btn bg-pink-400'
//         });

// $('#car_price').val(0);
// $('#auction_fee').val(0);
// $('#storage_fee').val(0);
// $('#transport_fee').val(0);
// $('#expense_fee').val(0);
     $('.daterange-single').daterangepicker({ 
            singleDatePicker: true,
            locale: {
            format: 'YYYY-MM-DD'
        }
     });

     $(".checkForDot").focusout(function() {
        let val = $(this).val();
        if (val == "." || val == "") {
            $(this).val(0);
           

        }
        calculate();

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
        calculate();

});

    let calculate = () => {
           let car_price =  +$('#car_price').val();
           let auction_fee = +$('#auction_fee').val();
           let storage_fee =  +$('#storage_fee').val();
           let transport_fee = +$('#transport_fee').val();
           let expense_fee =  +$('#expense_fee').val();

          let total =  (car_price+storage_fee+transport_fee+expense_fee+auction_fee).toFixed(2);
        $('#total_buying_price').html(`£ ${total}`);
    }
    calculate();


</script>
@endsection