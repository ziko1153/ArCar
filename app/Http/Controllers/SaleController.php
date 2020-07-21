<?php

namespace App\Http\Controllers;
use App\Customer;
use App\Hire;

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
            $list['value'] = $car->car_name;
            $list['reg_no'] = $car->reg_no;
            $list['car_price'] = $car->car_price;
            $list['auction_name'] = $car->auction_name;
            array_push($carList, $list);
        }
        return view('pages.car.sale.index', ['customerList' => $customerList, 'carList' => $carList]);

    }

}