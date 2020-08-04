<?php

namespace App\Http\Controllers;
use App\Customer;
use App\PersonalCarAdd;
use App\PersonalCarHire;
use Auth;
use DataTables;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Validator;

class PersonalCarHireController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        $this->middleware('auth');
    }

    protected function getCustomerList() {
        $customerList = array();
        $customers = Customer::orderBy('id', 'desc')->get();
        foreach ($customers as $customer) {
            $list['id'] = $customer->id;
            $list['value'] = $customer->cust_name;
            $list['name'] = $customer->cust_name;
            $list['mobile'] = $customer->cust_mobile;
            $list['email'] = $customer->cust_email;
            $list['ni'] = $customer->cust_ni;
            $list['address'] = $customer->cust_address;
            array_push($customerList, $list);
        }

        return $customerList;
    }

    protected function getPersonalCarList() {
        $carList = array();
        $cars = PersonalCarAdd::where('hire_status', '=', '0')->orderBy('id', 'desc')->get();

        foreach ($cars as $car) {
            $list['id'] = $car->id;
            $list['name'] = $car->car_name;
            $list['value'] = $car->reg_no . ' || ' . $car->car_name;
            $list['reg_no'] = $car->reg_no;
            array_push($carList, $list);
        }
        return $carList;
    }

    public function index() {
        if (request()->ajax()) {
            $i = 0;
            $car = PersonalCarHire::orderBy('id', 'desc')->get();
            return $this->getDataTablesView($car);
        }

        $customerList = $this->getCustomerList();
        $carList = $this->getPersonalCarList();
        return view('pages.personal.hire.index', ['customerList' => $customerList, 'carList' => $carList]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        // dd($request->all());
        $error = $this->validateHireData($request);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $hiresData = array(
            'user_id' => Auth::id(),
            'customer_id' => $request->customer,
            'car_id' => $request->car,
            'hire_start_date' => $request->hire_start_date,
            'hire_rate' => $request->hire_rate,
            'reg_no' => PersonalCarAdd::find($request->car)->reg_no,
        );

        $db = DB::transaction(function () use ($hiresData, $request) {
            $hire_id = PersonalCarHire::create($hiresData)->id;
            PersonalCarAdd::where('id', $request->car)->update(array('hire_status' => '1'));
            // SalesPayment::create([
            //     'hire_id' => $hire_id,
            //     'payment' => $request->paymentAmount,
            //     'created_at' => $request->saleDate,
            // ]);

            return true;

        });

        if ($db) {
            return response()->json(['success' => 'Successfully Added Hire', 'data' => $hiresData]);
        } else {
            return response()->json(['success' => false]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $Customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        if (request()->ajax()) {
            $data = PersonalCarAdd::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $Customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {

        $error = $this->validateCar($request);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'car_name' => $request->car_name,
            'reg_no' => $request->reg_no,
        );

        PersonalCarAdd::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Car Data is successfully updated']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sample_data  $sample_data
     * @return \Illuminate\Http\Response
     */
    public function destroy() {
        $data = PersonalCarAdd::findOrFail(request()->id);
        if ($data->delete()) {
            return response()->json(['success' => 'Deleted Successfully']);
        }
        return response()->json(['error' => 'Sorry Bad Request Something Went Wrong']);
    }

    protected function validateHireData($request) {
        $rules = array(
            'customer' => 'required|exists:customers,id',
            'car' => 'required|exists:personal_car_adds,id,hire_status,0',
            'hire_start_date' => 'required|date_format:Y-m-d',
            'hire_rate' => 'numeric|min:1',
        );
        $attr = array(
            'customer' => 'Customer Selection ',
            'car' => 'Personal Car Selection',
            'hire_start_date' => 'Hire Start Date',
            'hire_rate' => 'Weekly Hire Rate',
        );

        $messages = array(
            'numeric' => ':attribute will be Numeric',
            'exists' => 'Selected Car Already Hired',
        );

        $validator = Validator::make($request->all(), $rules, $messages);
        return $validator->setAttributeNames($attr);
    }

    protected function euroMoneyFormat($value) {

        $data = str_contains($value, '.') ? '£ ' . number_format($value, 2) : '£ ' . number_format($value);

        return $data;
    }

    protected function getDataTablesView($car) {
        return DataTables::of($car)
            ->addIndexColumn()
            ->addColumn('action', function ($car) {
                $button = '<div class="list-icons">
            <div class="dropdown">
                <a href="#" class="list-icons-item" data-toggle="dropdown" aria-expanded="false">
                    <i class="icon-menu9"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(22px, 19px, 0px);">
                    <a href="#" class="dropdown-item edit" id="' . $car->id . '"><i class="icon-pencil"></i>Edit</a>
                    <a href="#" class="dropdown-item delete" id="' . $car->id . '"><i class="icon-trash"></i>Delete</a>
                </div>
            </div>
        </div>';
                return $button;
            })->setTotalRecords($car->count())

            ->editColumn('date', function ($car) {

                $data = 'Hire Start Date : ' . date('F d,Y', strtotime($car->hire_start_date)) . '<br>';
                $data .= 'Hire End Date : ' . date('F d,Y', strtotime($car->hire_end_date));
                return $data;
            })
            ->editColumn('reg_no', function ($car) {

                return '<span class="badge bg-purple">' . $car->reg_no . '</span>';
            })

            ->editColumn('customer', function ($car) {

                return PersonalCarHire::find($car->id)->customer->cust_name;
            })
            ->editColumn('hire_rate', function ($car) {

                return $this->euroMoneyFormat($car->hire_rate);
            })

            ->editColumn('weeks', function ($car) {
                $result = $this->calculateTotalWeeks($car->hire_start_date, $car->hire_end_date, $car->hire_rate);
                $car->totalPayable = $result['total_rate'];
                $data = '<span class="badge bg-pink badge-pill">' . $result['weeks'] . ' weeks</span>';

                $data .= '<span class="badge badge-light"> = ' . $this->euroMoneyFormat($result['total_rate']) . '</span><br>';
                $data .= 'Total ' . $result['days'] . ' days </span>';

                return $data;
            })
            ->editColumn('payment', function ($car) {

                $data = '<ul class="dataList">';

                $paymentList = $car->paymentList;
                $total = 0;
                foreach ($paymentList as $payment) {

                    $pay = $this->euroMoneyFormat($payment->payment);
                    $data .= '<li>' . $pay . ' </li>';
                    $total += $payment->payment;
                }
                $data .= '</ul>';
                $totalPay = $this->euroMoneyFormat($total);
                $data .= 'Total : ' . $totalPay;
                return $data;
            })
            ->editColumn('due', function ($row) {

                $due = $row->totalPayable - $row->paymentList->sum('payment');

                if ($due > 0) {
                    $dueAmount = str_contains($due, '.') ? '£ ' . number_format($due, 2) : '£ ' . number_format($due);
                    return '<span class="badge badge-danger d-block">' . $dueAmount . '</span>';
                }
            })

            ->rawColumns(['action', 'date', 'reg_no', 'weeks', 'payment', 'due'])
            ->make(true);
    }

    protected function calculateTotalWeeks($start_date, $end_date, $rate) {

        $earlier = new DateTime($start_date);

        ($end_date) ? $later = new DateTime($end_date) : $later = new DateTime();

        $diff = $earlier->diff($later)->format("%r%a");
        ($diff <= 7) ? $days = 7 : $days = $diff;

        $weeks = ceil($days / 7);
        return array(
            'days' => $diff,
            'weeks' => $weeks,
            'total_rate' => $weeks * $rate,
        );
    }

}