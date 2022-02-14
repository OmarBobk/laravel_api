<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $employees = Employee::all();

        return response([
            'employees' => EmployeeResource::collection($employees),
            'message'   => 'Successful'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|max:50',
            'age' => 'required',
            'job' => 'required|max:50',
            'salary' => 'required'
        ]);

        if($validator->fails()){
            return response([
                'error' => $validator->errors(),
                'Validation Error']);
        }

        $employee = Employee::create($data);

        return response([
            'employee' => new EmployeeResource($employee),
            'message'  => 'Success', 200,
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return Response
     */
    public function show(Employee $employee)
    {
        return response([
            'employee' => new EmployeeResource($employee),
            'message'  => 'Success',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Models\Employee  $employee
     * @return Response
     */
    public function update(Request $request, Employee $employee)
    {
        $employee->update($request->all());

        return response([
            'employee' => new EmployeeResource($employee),
            'message' => 'Success'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response(['message' => 'Employee deleted']);
    }
}
