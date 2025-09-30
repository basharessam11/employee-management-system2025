<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnitRequest;
use App\Http\Traits\HasCrudPermissions;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;

class UnitController extends Controller
{
      use HasCrudPermissions;

    public function __construct()
    {
         $this->applyCrudPermissions('units');
    }

       public function index(Request $request)
    {


         $query = Unit::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'LIKE', "%{$search}%");

        }



          $units = $query->with('manager:id,name_ar,name_en')->orderBy('created_at', 'desc')->paginate(10)->appends($request->query());



        return view('admin.units.index', get_defined_vars());

    }



    public function create()
    {

         $users = User::all();

        return view('admin.units.create',  get_defined_vars());

    }

    public function store( UnitRequest $request)
    {

        Unit::create($request->all());
        return redirect()->route('units.index')->with('success', __('admin.Created Successfully'));
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
         $unit  = Unit::findOrFail($id);
        $users = User::all();
        return view('admin.units.edit',  get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UnitRequest $request,  $id)
    {

// return$request;
        $user = Unit::findOrFail($id);
         $user->update($request->all());



        return redirect()->route('units.index')->with('success', __('admin.Updated Successfully'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $ex = explode(',', $request->id);



foreach ($ex as $key => $value) {
    $unit = Unit::findOrFail($value);

    $unit->delete();
}



session()->flash('success', __('admin.Deleted Successfully'));

        return redirect()->back();
    }


}
