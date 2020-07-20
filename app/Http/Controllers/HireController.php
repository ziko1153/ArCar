<?php

namespace App\Http\Controllers;
use App\Hire;
use DataTables;
use Illuminate\Support\Facades\DB;
use Validator;

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
            $i = 0;
            $hire = Hire::orderBy('id', 'desc')->get();
            return $this->getDataTablesView($hire);
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

        if (request()->ajax()) {
            return response()->json(['response' => 'success', 'data' => $id]);
        }

    }

    public function update() {
        //error_log(request->all());
        $rules = array(
            'car_name' => 'required',
            'car_price' => 'required|numeric',
            'reg_no' => 'required',
            'auction_name' => 'required',
            'buying_date' => 'required|date_format:Y-m-d',
            'auction_place' => '',
            'parking_place' => '',
        );

        $error = Validator::make(request()->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'car_name' => request()->car_name,
            'car_price' => request()->car_price,
            'reg_no' => request()->reg_no,
            'auction_name' => request()->auction_name,
            'buying_date' => request()->buying_date,
            'auction_place' => request()->auction_place,
            'parking_place' => request()->parking_place,
            'user_id' => request()->user()->id,
        );

        Hire::whereId(request()->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);

    }

    protected function getDataTablesView($hire) {
        return DataTables::of($hire)
            ->addIndexColumn()
            ->addColumn('action', function ($hire) {
                $button = '<div class="list-icons">
            <div class="dropdown">
                <a href="#" class="list-icons-item" data-toggle="dropdown" aria-expanded="false">
                    <i class="icon-menu9"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(22px, 19px, 0px);">
                    <a href="#" class="dropdown-item edit" id="' . $hire->id . '"><i class="icon-pencil"></i>Edit</a>
                    <a href="#" class="dropdown-item delete" id="' . $hire->id . '"><i class="icon-trash"></i>Delete</a>
                </div>
            </div>
        </div>';
                return $button;
            })->setTotalRecords($hire->count())
            ->editColumn('sale_status', function ($hire) {
                return $hire->sale_status === 0 ? '<span class="badge badge-secondary">Pending</span>' : '<span class="badge badge-primary">Sale</span>';
            })

            ->editColumn('auction_name', function ($hire) {
                return 'Auction Name: ' . $hire->auction_name . '<br> Auction Place: ' . $hire->auction_place;
            })

            ->editColumn('car_price', function ($hire) {
                return str_contains($hire->car_price, '.') ? '€ ' . number_format($hire->car_price, 2) : '€ ' . number_format($hire->car_price);
            })

            ->editColumn('reg_no', function ($hire) {
                return '<a style="cursor:pointer" href="/car/hire/' . $hire->id . '"><span class="badge badge-dark badge-pill">' . $hire->reg_no . '</span></a>';
            })

            ->rawColumns(['reg_no', 'action', 'sale_status', 'auction_name'])
            ->make(true);
    }

}