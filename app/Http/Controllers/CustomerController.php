<?php

namespace App\Http\Controllers;
use App\Customer;
use DataTables;
use Illuminate\Http\Request;
use Validator;

class CustomerController extends Controller {
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
            $customer = Customer::orderBy('id', 'desc')->get();
            return $this->getDataTablesView($customer);
        }
        return view('pages.customer.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $error = $this->validateCustomer($request);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'cust_name' => $request->cust_name,
            'cust_email' => $request->cust_email,
            'cust_mobile' => $request->cust_mobile,
            'cust_address' => $request->cust_address,
        );

        Customer::create($form_data);

        return response()->json(['success' => 'Customer Added successfully.']);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $Customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        if (request()->ajax()) {
            $data = Customer::findOrFail($id);
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

        $error = $this->validateCustomer($request);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'cust_name' => $request->cust_name,
            'cust_email' => $request->cust_email,
            'cust_mobile' => $request->cust_mobile,
            'cust_address' => $request->cust_address,
        );

        Customer::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Customer Data is successfully updated']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sample_data  $sample_data
     * @return \Illuminate\Http\Response
     */
    public function destroy() {
        $data = Customer::findOrFail(request()->id);
        if ($data->delete()) {
            return response()->json(['success' => 'Deleted Successfully']);
        }
        return response()->json(['error' => 'Sorry Bad Request Something Went Wrong']);
    }
    protected function getDataTablesView($customer) {
        return DataTables::of($customer)
            ->addIndexColumn()
            ->addColumn('action', function ($customer) {
                $button = '<div class="list-icons">
            <div class="dropdown">
                <a href="#" class="list-icons-item" data-toggle="dropdown" aria-expanded="false">
                    <i class="icon-menu9"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(22px, 19px, 0px);">
                    <a href="#" class="dropdown-item edit" id="' . $customer->id . '"><i class="icon-pencil"></i>Edit</a>
                    <a href="#" class="dropdown-item delete" id="' . $customer->id . '"><i class="icon-trash"></i>Delete</a>
                </div>
            </div>
        </div>';
                return $button;
            })->setTotalRecords($customer->count())

            ->editColumn('cust_email', function ($customer) {
                return $customer->cust_email;
            })

            ->rawColumns(['action', 'cust_email'])
            ->make(true);
    }

    protected function validateCustomer($request) {
        $rules = array(
            'cust_name' => 'required|min:3',
            'cust_email' => 'nullable|email|unique:customers,cust_email,' . $request->hidden_id,
            'cust_mobile' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'cust_address' => 'nullable|min:3',
        );
        $attr = array(
            'cust_name' => 'Customer Name',
            'cust_email' => 'Customer Email',
            'cust_mobile' => 'Customer Mobile',
            'cust_address' => 'Customer Address',
        );

        $validator = Validator::make($request->all(), $rules);
        return $validator->setAttributeNames($attr);
    }
}