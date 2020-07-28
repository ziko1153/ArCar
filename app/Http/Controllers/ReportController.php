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
            $result['data'] = $this->getCarAvailableReport($startDate,$endDate);
        }

        return response()->json(['data'=>$result]);

    }

    protected function getCarAvailableReport($startDate,$endDate) {
        $data = array();
        $data['row'] = array();
        $getRow =  Hire::whereBetween('buying_date', [$startDate, $endDate])->get();
        $totalBuyingCar = $totalSellingCar = $totalBuyingPrice = $totalSalePrice  = 0;
        foreach($getRow as $row) {
            $list = array(
                'reg_no' => $row->reg_no,
                "buy" => $row->car_price,
                "sale" => SalesCar::where('car_id',$row->id)->value('sale_price')

            );
           array_push($data['row'],$list);
           $data['statistic']['total_car_buy'] =   ++$totalBuyingCar;
           $data['statistic']['total_buying_price'] = $totalBuyingPrice += $row->car_price;
            $totalSalePrice += $list['sale'];
        }

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

}
