<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Resources\EmployeeListResource;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::paginate(10);

        return EmployeeListResource::collection($employees);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEmployeeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest $request)
    {
        $data = $request->validated();
        $employee = new Employee($data);
        \DB::beginTransaction();
        if ($employee->save()) {
            $employee->departments()->sync($data['departments']);
            \DB::commit();
            return new EmployeeResource($employee);
        }else{
            \DB::rollback();
            return response(null, \Illuminate\Http\Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return new EmployeeResource($employee);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreEmployeeRequest  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEmployeeRequest $request, Employee $employee)
    {
        $data = $request->validated();
        \DB::transaction(function () use ($data, $employee) {
            $employee->departments()->sync($data['departments']);
            $employee->update($data);
        });

        return new EmployeeResource($employee);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response(null, \Illuminate\Http\Response::HTTP_NO_CONTENT);
    }
}
