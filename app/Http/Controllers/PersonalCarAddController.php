<?php

namespace App\Http\Controllers;
use App\PersonalCarAdd;
use DataTables;
use Illuminate\Http\Request;
use Validator;

class PersonalCarAddController extends Controller {
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
            $car = PersonalCarAdd::orderBy('id', 'desc')->get();
            return $this->getDataTablesView($car);
        }
        return view('pages.personal.add.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $error = $this->validateCar($request);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'car_name' => $request->car_name,
            'reg_no' => $request->reg_no,
            'hire_status' => 0,
        );

        PersonalCarAdd::create($form_data);

        return response()->json(['success' => 'Car Added successfully.']);

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

            ->editColumn('hire_status', function ($car) {
                $status = ($car->hire_status == 0) ? '<span class="badge badge-flat border-success text-success-600">Available</span>' : '<span class="badge badge-flat badge-icon border-pink text-pink-600 rounded-circle"><i class="icon-bus"></i></span>';

                return $status;
            })

            ->rawColumns(['action', 'hire_status'])
            ->make(true);
    }

    protected function validateCar($request) {
        $rules = array(
            'car_name' => 'required|min:3',
            'reg_no' => 'required|min:3',

        );
        $attr = array(
            'cust_name' => 'Car Name',
            'reg_no' => 'Registration No',
        );

        $validator = Validator::make($request->all(), $rules);
        return $validator->setAttributeNames($attr);
    }
}