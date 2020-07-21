@extends('layouts.app')

@section('extra-header')
<script src="/global_assets/js/plugins/extensions/jquery_ui/full.min.js"></script>
@endsection
@section('content')

<div class="row ">
    {{-- Sale Section --}}
    <div class="col-md-8">
        <div class="card border-left-3 border-left-pink-400 border-right-3 border-right-pink-400 rounded-0">
            <div class="card-header">
                <h6 class="card-title"><span class="font-weight-semibold">Car </span> Sale</h6>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="input-group ml-3">
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-search4"></i></span>
                        </span>
                        <input type="text" class="form-control" id="carSearch" placeholder="Search Car By 'Name' or 'Reg No' or 'Auction Name'">
                    </div>

                </div>
            </div>
            
            <div class="card-body">
                <div class="table-responsive table-hover table-striped table-scrollable">
                    <table class="table">
                        <thead>
                            <tr class="bg-dark">
                                <th>#</th>
                                <th>Reg No.</th>
                                <th>Car Name</th>
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
    </div>

    {{-- Display Section --}}
    <div class="col-md-4">
            <div class="card">
                <div class="card-header alpha-success text-success-800 header-elements-inline">
                    <h6 class="card-title">Preview</h6>
                    
                </div>

                <div class="card-body">
                    Card header with custom light colors - add <code>.alpha-*</code> class to card header container
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
    }
}); // End of searching by product name    

let addCarInputList = (data)=>{
        

insertRow(data)


}

let insertRow = (data) => {
    let tableBody = document.getElementsByClassName('tableBody')[0];

        let row = tableBody.insertRow();

        let colSerialNo = row.insertCell(0).innerText = 1;
        let colRegNo = row.insertCell(1).innerText = `${data.reg_no}`;
        let colCarName = row.insertCell(2).innerText = `${data.value}`;
        let colBuyingPrice = row.insertCell(3).innerText = `€${new Intl.NumberFormat().format(data.car_price)}`

        let inputElm = document.createElement('input');
        inputElm.type="number";
        inputElm.step="0.01";
        inputElm.min="0";
        inputElm.className = 'form-control';

        let colSalePrice = row.insertCell(4).appendChild(inputElm).focus();
        
        let iconElm = document.createElement('i');
        iconElm.className = 'icon-trash';
        iconElm.style.color = 'tomato';
        iconElm.style.cursor = 'pointer';

        let colDelete = row.insertCell(5).appendChild(iconElm);

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



</script>
@endsection