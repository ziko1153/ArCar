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

        // dd(request()->delivery);
        Hire::create(request()->validate([
            'car_name' => 'required',
            'car_price' => 'required|numeric|min:1',
            'auction_fee' => 'numeric|min:0',
            'storage_fee' => 'numeric|min:0',
            'transport_fee' => 'numeric|min:0',
            'expense_fee' => 'numeric|min:0',
            'reg_no' => 'required',
            'auction_name' => 'required',
            'buying_date' => 'required|date_format:Y-m-d',
            'auction_place' => '',
            'parking_place' => '',
            'delivery' => '',
            'comment' => '',

        ]) + ['user_id' => request()->user()->id,

              'auction_fee' => request()->auction_fee,
              'storage_fee' => request()->storage_fee,
              'transport_fee' => request()->transport_fee,
              'expense_fee' => request()->expense_fee,
              'total_car_price' => request()->car_price+request()->auction_fee+request()->storage_fee+request()->transport_fee+request()->expense_fee
        
        ]);

        return redirect('/car/hire')->with(['message' => 'Successfully Added Car']);

    }

    public function edit(Hire $id) {

        if (request()->ajax()) {
            return response()->json(['response' => 'success', 'data' => $id]);
        }

    }

    public function update() {
        
        $rules = array(
            'car_name' => 'required',
            'car_price' => 'required|numeric|min:1',
            'auction_fee' => 'numeric|min:0',
            'storage_fee' => 'numeric|min:0',
            'transport_fee' => 'numeric|min:0',
            'expense_fee' => 'numeric|min:0',
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

        $total_car_price = request()->car_price + request()->auction_fee + request()->storage_fee + request()->transport_fee + request()->expense_fee;
        $form_data = array(
            'car_name' => request()->car_name,
            'car_price' => request()->car_price,
            'reg_no' => request()->reg_no,
            'auction_name' => request()->auction_name,
            'buying_date' => request()->buying_date,
            'auction_place' => request()->auction_place,
            'parking_place' => request()->parking_place,
            'auction_fee' => request()->auction_fee,
            'storage_fee' => request()->storage_fee,
            'transport_fee' => request()->transport_fee,
            'expense_fee' => request()->expense_fee,
            'total_car_price' => $total_car_price,
            'delivery' => request()->delivery,
            'comment' => request()->comment,
            'user_id' => request()->user()->id,
        );


        Hire::whereId(request()->hidden_id)->update($form_data);

        return response()->json(['success' => 'Buying Car is successfully updated']);

    }

    public function destroy() {
        $data = Hire::where('id',request()->id)->where('sale_status',0);
        if ($data->delete()) {
            return response()->json(['success' => 'Deleted Successfully']);
        }
        return response()->json(['error' => 'Sorry Bad Request Something Went Wrong']);
    }

    protected function getDataTablesView($hire) {
        return DataTables::of($hire)
            ->addIndexColumn()
            ->addColumn('action', function ($hire) {
                $delBtn = ($hire->sale_status==0) ? ' <a href="#" class="dropdown-item delete" id="' . $hire->id . '"><i class="icon-trash"></i>Delete</a>' : '';
                $button = '<div class="list-icons">
            <div class="dropdown">
                <a href="#" class="list-icons-item" data-toggle="dropdown" aria-expanded="false">
                    <i class="icon-menu9"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(22px, 19px, 0px);">
                    <a href="#" class="dropdown-item edit" id="' . $hire->id . '"><i class="icon-pencil"></i>Edit</a>
                   '.$delBtn.'
                </div>
            </div>
        </div>';
                return $button;
            })->setTotalRecords($hire->count())
            ->editColumn('sale_status', function ($hire) {
                return $hire->sale_status == 0 ? '<span class="badge badge-secondary">Pending</span>' : '<span class="badge badge-primary">Sale</span>';
            })

            ->editColumn('auction_name', function ($hire) {
                return 'Auction Name: ' . $hire->auction_name . '<br> Auction Place: ' . $hire->auction_place;
            })

            ->editColumn('car_price', function ($hire) {
                $list = '';

                $list .= 'Car Price :'.$this->euroMoneyFormat($hire->car_price)."</br>";
                $list .= 'Auction Fee :'.$this->euroMoneyFormat($hire->auction_fee)."</br>";
                $list .= 'Storage Fee :'.$this->euroMoneyFormat($hire->storage_fee)."</br>";
                $list .= 'Transport Fee :'.$this->euroMoneyFormat($hire->transport_fee)."</br>";
                $list .= 'Expense Fee :'.$this->euroMoneyFormat($hire->expense_fee)."</br>";
                $list .= 'Total :'.$this->euroMoneyFormat($hire->total_car_price);
                return $list;
            })

            ->editColumn('reg_no', function ($hire) {
                return '<a style="cursor:pointer" href="/car/hire/' . $hire->id . '"><span class="badge badge-dark badge-pill">' . $hire->reg_no . '</span></a>';
            })
            ->editColumn('buying_date', function ($hire) {

                return date('d-M-Y', strtotime($hire->buying_date));
            })

            ->rawColumns(['reg_no', 'action', 'sale_status', 'auction_name','car_price'])
            ->make(true);
    }

    protected function euroMoneyFormat($value) {

        $data = str_contains($value, '.') ? '£ ' . number_format($value, 2) : '£ ' . number_format($value);

        return $data;
    }

}