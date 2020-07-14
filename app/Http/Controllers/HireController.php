<?php

namespace App\Http\Controllers;
use App\Hire;
use DataTables;
use Illuminate\Support\Facades\DB;

class HireController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        $this->middleware('auth');
    }

    public function index() {
        if (request()->ajax()) {
            $data = Hire::orderBy('id', 'desc')->get();
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    $button = '<div class="list-icons">
                    <div class="dropdown">
                        <a href="#" class="list-icons-item" data-toggle="dropdown" aria-expanded="false">
                            <i class="icon-menu9"></i>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(22px, 19px, 0px);">
                            <a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Export to .pdf</a>
                            <a href="#" class="dropdown-item"><i class="icon-file-excel"></i> Export to .csv</a>
                            <a href="#" class="dropdown-item"><i class="icon-file-word"></i> Export to .doc</a>
                        </div>
                    </div>
                </div>';
                    return $button;
                })->setTotalRecords($data->count())
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.car.hire.index');
    }

    public function show() {
        $hireCar = DB::select('select * from hire');

        return abort(404);
    }

    public function create() {
        return view('pages.car.hire.create');
    }

    public function store() {

        Hire::create(request()->validate([
            'car_name' => 'required',
            'car_price' => 'required|numeric',
            'reg_no' => 'required',
            'auction_name' => 'required',
            'buying_date' => 'required|date_format:Y-m-d',
            'auction_place' => '',
            'parking_place' => '',

        ]) + ['user_id' => request()->user()->id]);

        return redirect('/car/hire');

    }

    public function edit(Hire $id) {

        return view('pages.car.edit', ['hire' => $id]);
    }

    public function update() {

    }

}