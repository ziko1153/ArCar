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

    protected function getCustomerList() {
        $customerList  = array();
        $customers = Customer::orderBy('id', 'desc')->get();
        foreach ($customers as $customer) {
            $list['id'] = $customer->id;
            $list['value'] = $customer->cust_name;
            $list['email'] = $customer->cust_email;
            $list['address'] = $customer->cust_address;
            array_push($customerList, $list);
        }

        return $customerList;
    }

    protected  function getHireCarList() {
        $carList  = array();
        $cars = Hire::where('sale_status','=','0')->orderBy('id', 'desc')->get();

        foreach ($cars as $car) {
            $list['id'] = $car->id;
            $list['value'] = $car->reg_no . ' || ' . $car->car_name . ' || ' . $car->auction_name;
            $list['reg_no'] = $car->reg_no;
            $list['car_price'] = $car->car_price;
            $list['auction_name'] = $car->auction_name;
            array_push($carList, $list);
        }
        return $carList;
    }

    public function index() {
        if (request()->ajax()) {
            $sale = Sale::orderBy('id', 'desc')->get();
            return $this->getDataTablesView($sale);
        }
        return view('pages.car.sale.index');
    }

    public function create() {
        $customerList = $this->getCustomerList();
        $carList = $this->getHireCarList();
      
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
                Hire::where('id', $data['car_id'])->update(array('sale_status' => '1'));
            }

            SalesPayment::create(['sale_id'=>$sale_id,'payment'=>$request->paymentAmount]);

            return true;

        });

        if($db) return response()->json(['success' => true, 'data' => $salesData]);
        else return response()->json(['success' => false]);


        
    }

    public function edit($id) {
        $customerList = $this->getCustomerList();
        $carList = $this->getHireCarList();
        $saleCarList = $this->getSalesCarData($id);
        $saleData = DB::select('SELECT * FROM sales inner join sales_payments on sales.id = sales_payments.sale_id where sales.id = ? limit 1',[$id]);
      
        return view('pages.car.sale.edit', ['customerList' => $customerList, 'carList' => $carList,'saleCarList' => $saleCarList,'saleData'=>$saleData]);

       
    }
    public function update(Request $request) {

        $db =   DB::transaction(function() use($request) {
            //$error = $this->validateSaleData($request);

            /// First Reverse Old Sales Car Sale Status = 0
                 $carData =  array_map(function($data) {return $data['id'];}, $request['oldCarList']);
                 $this->reverseSalesCarData($carData);

              
            //// Secondly Check Validation For Edit Sales Data
                $error = $this->validateSaleData($request);


                if ($error->fails()) {
                    DB::rollback();
                    return array('errors' => $error->errors()->all());
                }

            /// Thirdly Delete All Sales Data

                $sales =  $this->deleteAllSalesData($request['id']);
            /// Forthly Insert New Sales Car data and Payment
                foreach ($request['carList'] as $key => $value) {

                    $data = array(
                        'sale_id' => $sales->id,
                        'car_id' => $request['carList'][$key]['id'],
                        'sale_price' => $request['carList'][$key]['salePrice'],
                    );
                    SalesCar::create($data);
                    Hire::where('id', $data['car_id'])->update(array('sale_status' => '1'));
                }
    
                SalesPayment::create(['sale_id'=>$sales->id,'payment'=>$request->paymentAmount]);

                /// Fiflty Update Sales table data


       $salesData = array(
            'user_id' => Auth::id(),
            'customer_id' => $request->customerId,
            'sale_date' => $request->saleDate,
            'discount' => $request->discountAmount,
            'sale_status' => 2
        );
 
        Sale::whereId($request->id)->update($salesData);

        return array('success' => true);

        });
       
            
        return response()->json($db);
    }

    public function destroy() {
      
      $result =   DB::transaction(function () {
        $saleCarData = SalesCar::where('sale_id',request()->id);
        $this->reverseSalesCarData($saleCarData->get(['car_id'])->pluck('car_id'));
        $salePaymentData = SalesPayment::where('sale_id',request()->id)->delete();
        $saleCarData->delete();
        $saleData = Sale::where('id',request()->id)->delete();

        return true;
              
         });

         if($result) return response()->json(['success' => 'Deleted Successfully']);
         else return response()->json(['error' => 'Sorry Bad Request Something Went Wrong']);
            
    }

    protected function validateSaleData($request) {
        $rules = array(
            'customerId' => 'required|exists:customers,id',
            'paymentAmount' => 'numeric|min:0',
            'discountAmount' => 'numeric|min:0',
            'saleDate' => 'required|date_format:Y-m-d',
            'carList' => 'array|min:1',
            'carList.*.id' => 'numeric|distinct|exists:hires,id,sale_status,0',
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

                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(22px, 19px, 0px);">
                <a href="#"  class="dropdown-item addPayment" id="' . $sale->id . '"><i class="icon-coin-pound"></i>Take Payment</a>

                    <a href="sale/edit/'.$sale->id.'" target="_blank" class="dropdown-item edit" id="' . $sale->id . '"><i class="icon-pencil"></i>Edit</a>

                    <a href="#" class="dropdown-item delete" id="' . $sale->id . '"><i class="icon-trash"></i>Delete</a>
                </div>
            </div>
        </div>';
                return $button;
            })->setTotalRecords($sale->count())
            ->editColumn('sale_status', function ($sale) {
                $edited = ($sale->sale_status == 2) ?  '<span class="badge badge-flat border-warning text-warning-600 ml-2">Edited</span>' : '';

                return $sale->sale_status == 0 ? '<span class="badge badge-secondary">Draft</span>' : '<span class="badge badge-primary">Sale</span>'.$edited;

            })

            ->editColumn('date', function ($sale) {
                $saleInstance;
                return date('d-M-Y', strtotime($sale->sale_date));
            })
            ->editColumn('car_list', function ($sale){
                $data = '<div class="carList">';
                $no = 1;
                $totalBuy = 0;
                $totalSale = 0;
              $carList = $this->getSalesCarData($sale->id);
              $sale->carList = $carList;
                foreach($carList as $car) {
                    $data .=  '<span  onClick="showCar(this)" id='.$car->id.'  class="badge badge-light badge-striped badge-striped-left border-left-info">'.$car->car_name.'</span><br>';
                    $totalBuy  += $car->car_price;
                    $totalSale  += $car->sale_price;
                }
               
                $data .= '</div>Buy: '. $this->euroMoneyFormat($totalBuy).'<br>';
                $data .= '</div>Sale: '.$this->euroMoneyFormat($totalSale);
                return $data;
            })
            ->editColumn('customer', function ($sale) {
                return Sale::find($sale->id)->customer->cust_name;
            })

            ->editColumn('payment_history', function ($sale) {
                $data = '<ul class="dataList">';
               
               $paymentList =  $sale->paymentList;
               $total = 0;
               foreach($paymentList as $payment) {
                   
                $pay = $this->euroMoneyFormat($payment->payment);
                    $data .= '<li>' .$pay.' </li>';
                    $total  += $payment->payment;
               }
               $data .= '</ul>';
               $totalPay = $this->euroMoneyFormat($total);
               $data .= 'Total : '.$totalPay;
               return $data;
            })
            ->editColumn('due', function ($row){
               $due =  (array_sum(array_column($row->carList, 'sale_price'))-$row->discount) - $row->paymentList->sum('payment');

               if($due>0) {
                   $dueAmount = str_contains($due, '.') ? '£ ' . number_format($due, 2) : '£ ' . number_format($due);
                   return '<span class="badge badge-danger d-block">'.$dueAmount.'</span>';
               }
                
            })->editColumn('discount',function($sale){
                
                return '£ '.$sale->discount;
            })


            ->rawColumns(['action','sale_status','car_list','payment_history','due'])
            ->make(true);
    }

    protected function euroMoneyFormat($value) {

        $data = str_contains($value, '.') ? '£ ' . number_format($value, 2) : '£ ' . number_format($value);

        return $data;
    }

    protected function reverseSalesCarData($carsId) {

           return Hire::whereIn('id',$carsId)
                ->update([
                    'sale_status' => 0 
                ]);

    }

    protected function getSalesCarData($id) {
       return DB::select('SELECT * from  sales_cars inner join hires on sales_cars.car_id = hires.id where sales_cars.sale_id = ? order by sales_cars.id desc',[$id]);
    }

    protected function deleteAllSalesData($id) {

            $sale = Sale::findOrfail($id);

             $sale->paymentList()->delete();
             $sale->saleList()->delete();

             return $sale;

    }
   

}