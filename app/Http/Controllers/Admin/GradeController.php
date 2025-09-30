<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GradeRequest;
use App\Http\Traits\HasCrudPermissions;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
 use HasCrudPermissions;

    public function __construct()
    {
         $this->applyCrudPermissions('grades');
    }

        public function index(Request $request)
    {


         $query = Grade::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'LIKE', "%{$search}%");

        }



          $grades = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->query());



        return view('admin.grades.index', get_defined_vars());

    }



    public function create()
    {


        return view('admin.grades.create');

    }

    public function store( GradeRequest $request)
    {

        Grade::create($request->all());
        return redirect()->route('grades.index')->with('success', __('admin.Created Successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $grade  = Grade::findOrFail($id);

        return view('admin.grades.edit',  get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GradeRequest $request,  $id)
    {

// return$request;
        $user = Grade::findOrFail($id);
         $user->update($request->all());



        return redirect()->route('grades.index')->with('success', __('admin.Updated Successfully'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $ex = explode(',', $request->id);



foreach ($ex as $key => $value) {
    $grades = Grade::findOrFail($value);

    $grades->delete();
}



session()->flash('success', __('admin.Deleted Successfully'));

        return redirect()->back();
    }


}
