<?php

 namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Http\Traits\HasCrudPermissions;
use App\Models\Department;
use App\Models\DepartmentUser;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
          use HasCrudPermissions;

    public function __construct()
    {
         $this->applyCrudPermissions('departments');
    }

        public function index(Request $request)
    {


         $query = Department::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'LIKE', "%{$search}%");

        }



          $departments = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->query());



        return view('admin.departments.index', get_defined_vars());

    }



    public function create(Request $request )
    {

         $units = Unit::all();
         $users = User::all();


        return view('admin.departments.create' , get_defined_vars());

    }

    public function store( DepartmentRequest $request)
    {

        Department::create($request->all());
        return redirect()->route('departments.index')->with('success', __('admin.Created Successfully'));
    }

    /**
     * Display the specified resource.
     */

public function show(Request $request, $id)
{
    $query = DepartmentUser::with(['user', 'unit', 'department']);

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->whereHas('user', function ($q2) use ($search) {
                $q2->where('name', 'LIKE', "%{$search}%");
            })
            ->orWhereHas('unit', function ($q2) use ($search) {
                $q2->where('name', 'LIKE', "%{$search}%");
            })
            ->orWhereHas('department', function ($q2) use ($search) {
                $q2->where('name', 'LIKE', "%{$search}%");
            });
        });
    }

    $departments = $query
        ->where('department_id', $id)
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->appends($request->query());

    return view('admin.departments.show', get_defined_vars());
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $department  = Department::findOrFail($id);
        $users = User::all();

        $units = Unit::all();



        return view('admin.departments.edit',  get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentRequest $request,  $id)
    {

// return$request;
        $user = Department::findOrFail($id);
         $user->update($request->all());



        return redirect()->route('departments.index')->with('success', __('admin.Updated Successfully'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $ex = explode(',', $request->id);



foreach ($ex as $key => $value) {
    $departments = Department::findOrFail($value);

    $departments->delete();
}



session()->flash('success', __('admin.Deleted Successfully'));

        return redirect()->back();
    }


}
