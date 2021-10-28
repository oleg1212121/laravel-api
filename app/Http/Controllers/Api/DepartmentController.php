<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentListResource;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Exceptions\HttpResponseException;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::with('employees')->withCount('employees')
            ->withMax('employees', 'salary')->paginate(10);

        return DepartmentListResource::collection($departments);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDepartmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartmentRequest $request)
    {
        $department = Department::create($request->validated());

        return new DepartmentResource($department);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        return new DepartmentResource($department);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDepartmentRequest  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $department->update($request->validated());

        return new DepartmentResource($department);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        if($department->employees()->exists()){
            throw new HttpResponseException(
                response()->json(['message' => 'Нельзя удалить отдел с привязанными сотрудниками'], 422));
        }else{
            $department->delete();

            return response(null, \Illuminate\Http\Response::HTTP_NO_CONTENT);
        }

    }
}
