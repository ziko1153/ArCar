<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Hire;
use App\SalesCar;
class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        $this->middleware('auth');
    }

    public function index() {

        return view('pages.report.index');
    }

    public function getReport() {

        $error = $this->validateRportData(request());
        $result = [];

        if ($error->fails()) {
          
            return array('errors' => $error->errors()->all());
        }

        $report = request()->get('reportSelect');
        $startDate = date('Y-m-d',strtotime(request()->get('startDate')));
        $endDate = date('Y-m-d',strtotime(request()->get('endDate')));

        if($report == 1) {
            $result = $this->getCarAvailableReport($startDate,$endDate);
        }

        return response()->json($result);

    }

    protected function getCarAvailableReport($startDate,$endDate) {
        $data = array();
        $data['row'] = array();
        $getRow =  Hire::whereBetween('buying_date', [$startDate, $endDate])->orderBy('buying_date','desc')->get();
      $availableCarPrice =   $totalBuyingCar = $totalSellingCar = $totalBuyingPrice = $totalSalePrice  = 0 ;
        foreach($getRow as $row) {
            $salePrice = SalesCar::where('car_id',$row->id)->value('sale_price');

            $list = array(
                'hire_date' => date('F d,Y',strtotime($row->buying_date)),
                'name' => $row->car_name,
                'auction' => $row->auction_name,
                'reg_no' => $row->reg_no,
                "buy" => $this->euroMoneyFormat($row->car_price),
                "sale" => ($salePrice)?$this->euroMoneyFormat($salePrice):'',
                "sale_status" => ($row->sale_status == 1)? '<span class="badge badge-primary">Sale</span>' : '<span class="badge badge-secondary">Pending</span>'

            );
            array_push($data['row'],$list);
            ++$totalBuyingCar;
            $totalBuyingPrice += $row->car_price;
           if($row->sale_status == 1) {
              $totalSalePrice += $salePrice;
              ++$totalSellingCar;
               
           }else {
                $availableCarPrice += $row->car_price;
           }
        }

        $data['statistic']['car_available'] = $totalBuyingCar - $totalSellingCar;
        $data['statistic']['available_price'] = $this->euroMoneyFormat($availableCarPrice);
        $data['statistic']['total_car_sale']  =  $totalSellingCar;
        $data['statistic']['total_selling_price'] =  $this->euroMoneyFormat($totalSalePrice);
        $data['statistic']['total_car_buy'] =   $totalBuyingCar;
        $data['statistic']['total_buying_price'] = $this->euroMoneyFormat($totalBuyingPrice);

        $data['type'] = 'car_available';

        return $data;
    }

    protected function validateRportData($request) {
        $rules = array(
            'reportSelect' => 'required|in:1,2',
            'startDate' => 'required',
            'endDate' => 'required',
        );
        $attr = array(
            'reportSelect' => 'Selected Report',
            'startDate' => 'Start Date',
            'endDate' => 'End Date',
        );

        $validator = Validator::make($request->all(), $rules);
        return $validator->setAttributeNames($attr);
    }
    protected function euroMoneyFormat($value) {

        $data = str_contains($value, '.') ? '£ ' . number_format($value, 2) : '£ ' . number_format($value);

        return $data;
    }

}
