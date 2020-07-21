@extends('layouts.app')

@section('content')

<div class="row ">
    {{-- Sale Section --}}
    <div class="col-md-8">
        <div class="card border-left-3 border-left-pink-400 border-right-3 border-right-pink-400 rounded-0">
            <div class="card-header">
                <h6 class="card-title"><span class="font-weight-semibold">Car </span> Sale</h6>
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
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Eugenes dfsfsdf</td>
                                <td>Kopyov sdfsf sfsfsd fsfsdf sdf sf dfsdf sdf</td>
                                <td>32,457</td>
                                <td>32,457</td>
                                <td><i class="icon-trash" style="color:tomato;cursor: pointer"></i></td>
                            </tr>
                      
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