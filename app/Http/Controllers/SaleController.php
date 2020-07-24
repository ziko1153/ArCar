<?php

namespace App\Http\Controllers;
use App\Customer;
use App\Hire;
use App\Sale;
use App\SalesCar;
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
        return view('pages.car.sale.index', ['customerList' => $customerList, 'carList' => $carList]);

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
               return true;

        });

        return response()->json(['success' => true, 'data' => $db]);

        
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

}