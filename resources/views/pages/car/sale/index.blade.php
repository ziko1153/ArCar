@extends('layouts.app')

@section('extra-header')
<script src="/global_assets/js/plugins/extensions/jquery_ui/full.min.js"></script>
<script src="../../../../global_assets/js/plugins/forms/selects/select2.min.js"></script>
@endsection
@section('content')

<style>
    .delBtn:hover {
           opacity: 0.5;
    }
</style>
<div class="row ">
    <div class="col-md-8">
        
        {{-- Customer Section --}}
        <div class="card border-left-3 border-left-success-400 border-right-3 border-right-success-400 rounded-0">
            <div class="card-header">
                <h6 class="card-title"><span class="font-weight-semibold">Customer Add Section</span></h6>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group ml-3 mb-3">
                        <select data-placeholder="Select a Customer First"  class="form-control select-search" data-fouc>
                            <option></option>
                                <option value="AZ">Arizona</option>
                                <option value="CO">Colorado</option>
                                <option value="ID">Idaho</option>
                                <option value="WY">Wyoming</option>
                                <option value="AL">Alabama</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                        </select>
                    </div>

                </div>

                
            </div>
 
            
        </div>
        
        {{-- Sale Section --}}
        <div class="card border-left-3 border-left-pink-400 border-right-3 border-right-pink-400 rounded-0">
            <div class="card-header">
                <h6 class="card-title"><span class="font-weight-semibold">Car  Add Section</span></h6>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group ml-3">
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-search4"></i></span>
                        </span>
                        <input type="text" class="form-control mr-4"  id="carSearch" placeholder="Search Car By 'Name' or 'Reg No' or 'Auction Name'">
                    </div>

                </div>

                
            </div>
            
            <div class="card-body">
                <div class="table-responsive table-hover table-striped table-scrollable">
                    <table class="table">
                        <thead>
                            <tr class="bg-dark">
                                <th>Car Details</th>
                                <th>Buying</th>
                                <th>Sale</th>
                                <th>Del</th>
                            </tr>
                        </thead>
                        <tbody class="tableBody">
    
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{--Take Payment Section--}}
        <div class="card border-left-3 border-left-success-400 border-right-3 border-right-success-400 rounded-0">
            <div class="card-header">
                <h6 class="card-title"><span class="font-weight-semibold">Payment Section</h6>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group ml-3 mb-3">
                        <span class="input-group-prepend">
                            <span class="input-group-text">Take Payment</span>
                        </span>
                        <input type="text" class="form-control mr-4" id="" placeholder="Enter Payment">
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="input-group ml-3 mb-3">
                        <span class="input-group-prepend">
                            <span class="input-group-text">Disocunt</span>
                        </span>
                        <input type="text" class="form-control mr-4" id="" placeholder="Enter Disocunt Amount">
                    </div>

                </div>
            </div>
 
            
        </div>
    </div>

    {{-- Display Section --}}
    <div class="col-md-4">
            <div class="card">
                <div class="card-header alpha-success text-success-800 header-elements-inline justify-content-center">
                    <h6 class="card-title "><b>Cost Estimate</b></h6>
                    
                </div>
                <div class="card-body">
                   
                    <div class="table-responsive">
						<table class="table">
							<tbody style="font-size:1.2rem">
								<tr>
                                <th colspan="1" class="table-active">Buying Price</th>
                                <th colspan="1"  class="table-active" ><span class="badge badge-flat badge-pill border-info text-info-600 ml-1 mb-1">€67345</span></th>
                                </tr>
                                <tr>
                                    <th colspan="1" class="table-active">Sale Price</th>
                                    <th colspan="1"  class="table-active" ><span class="badge badge-flat badge-pill border-primary text-primary-600 ml-1 mb-1">€67345</span></th>
                                </tr>
                                <tr >
                                    <th colspan="1" class="table-active">Discount</th>
                                    <th colspan="1"  class="table-active" ><span class="badge badge-flat badge-pill border-dark text-dark-600 ml-1 mb-1">€67345</span><span class="badge badge-flat badge-pill border-dark text-dark-600 ml-1 mb-1">10%</span></th>
                                </tr>

                                <tr class="table-border-double border-top-danger">
                                    <th colspan="1" class="table-active">Total Cost</th>
                                    <th colspan="1"  class="table-active" ><span class=" text-dark-600 ml-1 mb-1">€67345</span></th>
                                </tr>
                                <tr class="table-border-dashed ">
                                    <th colspan="1" class="table-active">Total Payment</th>
                                    <th colspan="1"  class="table-active" ><span class=" text-success-600 ml-1 mb-1">€67345</span></th>
                                </tr>

                                <tr class="table-border-dashed ">
                                    <th colspan="1" class="table-active">Total Due</th>
                                    <th colspan="1"  class="table-active" ><span class="border-dark text-danger-600 ml-1 mb-1">€0</span></th>
                                </tr>
                                
                            
							
                            </tbody>
                        </table>


                    </div>
                   
                </div>
            </div>


            <div class="card">
                <div class="card-header alpha-warning text-warning-800 header-elements-inline justify-content-center">
                    <h6 class="card-title "><b>Action Button</b></h6>
                    
                </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody style="font-size:1.2rem">
                                    <tr>
                                    <th colspan="1" class="table-active"><button type="button" class="btn btn-outline-success"><i class="icon-stack-check mr-2"></i> Save </button></th>

                                    <th colspan="1"  class="table-active" ><button type="button" class="btn btn-outline-primary"><i class="icon-printer2  mr-2"></i>Print & Save</button>
                                    </th>
                                    <th colspan="1"  class="table-active text-center"><button type="button" class="btn btn-outline-danger btn-lg"><i class="
                                        icon-bell3 mr-2"></i> Draft </button></th>
                                    </tr>
                                    <tr  class="table-border-double">
                                      
                                       
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
            </div>

    

            
    </div>
<div>

    </div>

</div>


@endsection

@section('extra-script')
<script type="text/javascript" >

let carSearchInp = document.getElementById('carSearch'); 
let carList  = @json($carList);
let saleCarList = [];

$("#carSearch").autocomplete({
    source: function(request, response) {
        // let searchResult = $.ui.autocomplete.filter(carList, request.term);
        // response(searchResult.slice(0, 10));

        var matcher = new RegExp( $.ui.autocomplete.escapeRegex( request.term ), "i" );
            response( $.grep( carList, function( value ) {
            return  matcher.test(value.reg_no) || matcher.test(value.car_price) || matcher.test(value.value) ||  matcher.test(value.auction_name);
        }));
    },
    select: function(event, ui) {
        event.preventDefault();
        addCarInputList(ui.item);
        $("#carSearch").val("");
    },
    options:{
        html:true
    }

}); // End of searching by product name    

let addCarInputList = (data)=>{
        
if(!checkExistInCart(data.id)){
    insertRow(data)
    addSaleListInCart(data)
}else {
    alert('Already Added Into The Cart')
}


}

let insertRow = (data) => {
    let tableBody = document.getElementsByClassName('tableBody')[0];

        let row = tableBody.insertRow();

        let colCarName = row.insertCell(0).innerText = `${data.value}`;
        let colBuyingPrice = row.insertCell(1).innerText = `€${new Intl.NumberFormat().format(data.car_price)}`

        let inputElm = document.createElement('input');
        inputElm.type="number";
        inputElm.step="0.01";
        inputElm.min="0";
        inputElm.className = 'form-control input-sm';
        inputElm.style.minWidth = "5rem";

        let colSalePrice = row.insertCell(2).appendChild(inputElm).focus();
        
        let iconElm = document.createElement('i');
        iconElm.className = 'icon-trash delBtn';
        iconElm.style.color = 'tomato';
        iconElm.style.cursor = 'pointer';

        let colDelete = row.insertCell(3).appendChild(iconElm);

        let hiddenRow = row.insertCell(4);
        hiddenRow.style.display = 'none';
        hiddenRow.className = 'hiddenId';
        hiddenRow.innerText = data.id;

        colDelete.addEventListener("click", e => {
            deleteRow(e.target);
        });

        inputElm.addEventListener('keypress',e =>{
              console.log(e);
              if(e.key === 'Enter' || e.keyCode === 13) {
                carSearchInp.focus();
                $("#carSearch").val("");
              }
        })

        inputElm.addEventListener('focusout',e=>{
            if(e.target.value === "" ){
                e.target.value = 0;
            }

        })

        
}

let deleteRow = (btn)=>{

    let row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);

}

let addSaleListInCart = (data) =>{

        let sale = {
            id:data.id,
            buyingPrice:data.car_price,
            salePrice:0
        }
     
        saleCarList.push(sale);
    

}

let checkExistInCart = (id) => {

       let exist =  saleCarList.find(car => car.id === id)
       if(exist) return true;
       else return false;
}

$('.select-search').select2();



</script>
@endsection