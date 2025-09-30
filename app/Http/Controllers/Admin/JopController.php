<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\JopRequest;
use App\Http\Traits\HasCrudPermissions;
use App\Models\Grade;
use App\Models\Jop;
use Illuminate\Http\Request;

class JopController extends Controller
{

 use HasCrudPermissions;

    public function __construct()
    {
         $this->applyCrudPermissions('jobs');
    }

           public function index(Request $request)
    {


         $query = Jop::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'LIKE', "%{$search}%");

        }



          $jobs = $query->with('grade:id,name')->orderBy('created_at', 'desc')->paginate(10)->appends($request->query());



        return view('admin.jobs.index', get_defined_vars());

    }



    public function create()
    {

         $grades = Grade::all();

        return view('admin.jobs.create',  get_defined_vars());

    }

    public function store( JopRequest $request)
    {

        Jop::create($request->all());
        return redirect()->route('jobs.index')->with('success', __('admin.Created Successfully'));
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
         $job  = Jop::findOrFail($id);
        $grades = Grade::all();
        return view('admin.jobs.edit',  get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JopRequest $request,  $id)
    {

// return$request;
        $user = Jop::findOrFail($id);
         $user->update($request->all());



        return redirect()->route('jobs.index')->with('success', __('admin.Updated Successfully'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $ex = explode(',', $request->id);



foreach ($ex as $key => $value) {
    $unit = Jop::findOrFail($value);

    $unit->delete();
}



session()->flash('success', __('admin.Deleted Successfully'));

        return redirect()->back();
    }


}
