<?php

namespace App\Http\Controllers;
use App\Customer;
use App\Hire;
use DataTables;
use App\Sale;
use App\SalesCar;
use App\SalesPayment;
use Auth;
use DB;
use Illuminate\Http\Request;
use Validator;

class SaleController extends Controller {
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
            $sale = Sale::orderBy('id', 'desc')->get();
            return $this->getDataTablesView($sale);
        }
        return view('pages.car.sale.index');
    }

    public function create() {
        $customerList = $carList = array();
        $customers = Customer::orderBy('id', 'desc')->get();
        $cars = Hire::orderBy('id', 'desc')->get();

        foreach ($customers as $customer) {
            $list['id'] = $customer->id;
            $list['value'] = $customer->cust_name;
            $list['email'] = $customer->cust_email;
            $list['address'] = $customer->cust_address;
            array_push($customerList, $list);
        }

        foreach ($cars as $car) {
            $list['id'] = $car->id;
            $list['value'] = $car->reg_no . ' || ' . $car->car_name . ' || ' . $car->auction_name;
            $list['reg_no'] = $car->reg_no;
            $list['car_price'] = $car->car_price;
            $list['auction_name'] = $car->auction_name;
            array_push($carList, $list);
        }
        return view('pages.car.sale.create', ['customerList' => $customerList, 'carList' => $carList]);

    }

    public function store(Request $request) {

        $error = $this->validateSaleData($request);


        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $salesData = array(
            'user_id' => Auth::id(),
            'customer_id' => $request->customerId,
            'sale_date' => $request->saleDate,
            'discount' => $request->discountAmount,
            'sale_status' => ($request->type == 'save' || $request->type == 'print')? 1 : 0
        );



       $db =   DB::transaction(function () use ($salesData,$request) {
            $sale_id = Sale::create($salesData)->id;
            foreach ($request['carList'] as $key => $value) {

                $data = array(
                    'sale_id' => $sale_id,
                    'car_id' => $request['carList'][$key]['id'],
                    'sale_price' => $request['carList'][$key]['salePrice'],
                );
                SalesCar::create($data);
            }

            SalesPayment::create(['sale_id'=>$sale_id,'payment'=>$request->paymentAmount]);

            return true;

        });

        if($db) return response()->json(['success' => true, 'data' => $salesData]);
        else return response()->json(['success' => false]);


        
    }

    protected function validateSaleData($request) {
        $rules = array(
            'customerId' => 'required|exists:customers,id',
            'paymentAmount' => 'numeric|min:0',
            'discountAmount' => 'numeric|min:0',
            'saleDate' => 'required|date_format:Y-m-d',
            'carList' => 'array|min:1',
            'carList.*.id' => 'numeric|distinct|exists:hires,id',
        );
        $attr = array(
            'customerId' => 'Customer',
            'paymentAmount' => 'Payment Amount',
            'discountAmount' => 'Discount Amount',
            'carList.*.id' => 'Hire Car',
        );

        // foreach ($request->get('carList') as $key => $val) {
        //     $rules['carList.' . $key . '.id'] = 'exists:hires,id';
        //     $rules['carList.' . $key . '.salePrice'] = 'numeric|min:1';

        //     $attr['carList.' . $key . '.id'] = 'Car List ';
        // }

        $validator = Validator::make($request->all(), $rules);
        return $validator->setAttributeNames($attr);
    }

    protected function getDataTablesView($sale) {

        return DataTables::of($sale)
            ->addIndexColumn()
            ->addColumn('action', function ($sale) {
                $extraButton = ($sale->sale_status == 0) ? '  <a href="#" class="dropdown-item delete" id="' . $sale->id . '"><i class="icon-file-check"></i>Save Sale</a>' : '';
                $button = '<div class="list-icons">
            <div class="dropdown">
                <a href="#" class="list-icons-item" data-toggle="dropdown" aria-expanded="false">
                    <i class="icon-menu9"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(22px, 19px, 0px);">'.
                $extraButton 
                .'
                    <a href="#" class="dropdown-item edit" id="' . $sale->id . '"><i class="icon-pencil"></i>Edit</a>
                    <a href="#" class="dropdown-item delete" id="' . $sale->id . '"><i class="icon-trash"></i>Delete</a>
                </div>
            </div>
        </div>';
                return $button;
            })->setTotalRecords($sale->count())
            ->editColumn('sale_status', function ($sale) {
                return $sale->sale_status == 0 ? '<span class="badge badge-secondary">Draft</span>' : '<span class="badge badge-primary">Sale</span>';

            })

            ->editColumn('date', function ($sale) {
                $saleInstance;
                return date('d-M-Y', strtotime($sale->sale_date));
            })
            ->editColumn('car_list', function ($sale){
                $data = '';
                $no = 1;
                $carList = Sale::find($sale->id)->carList;
                foreach($carList as $car) {
                    $data .=  '<span style="cursor:pointer" onClick="showCar()" id='.$car->id.' class="badge badge-flat border-grey text-grey-600">'.$car->car_name.'</span><br>';
                }
                return $data;
            })
            ->editColumn('customer', function ($sale) {
                return Sale::find($sale->id)->customer->cust_name;
            })

            ->editColumn('payment_history', function ($sale) {
                $data = '<ul class="dataList">';
               $paymentList =  Sale::find($sale->id)->paymentList;
               $total = 0;
               foreach($paymentList as $payment) {

                    $data .= '<li>' .$payment->payment.' </li>';
                    $total  += $payment->payment;
               }
               $data .= '</ul>';
               $data .= 'Total :'.$total;
               return $data;
            })
            ->editColumn('due', function ($sale){

                return 'Due';
            })

            ->rawColumns(['action','sale_status','car_list','payment_history'])
            ->make(true);
    }

}