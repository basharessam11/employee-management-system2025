<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocationRequest;
use App\Http\Traits\HasCrudPermissions;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
 use HasCrudPermissions;

    public function __construct()
    {
         $this->applyCrudPermissions('location');
    }


        public function index(Request $request)
    {


         $query = Location::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'LIKE', "%{$search}%");

        }



          $location = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->query());



        return view('admin.location.index', get_defined_vars());

    }



    public function create()
    {


        return view('admin.location.create');

    }

    public function store( LocationRequest $request)
    {

        Location::create($request->all());
        return redirect()->route('location.index')->with('success', __('admin.Created Successfully'));
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
         $location  = Location::findOrFail($id);

        return view('admin.location.edit',  get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LocationRequest $request,  $id)
    {

// return$request;
        $user = Location::findOrFail($id);
         $user->update($request->all());



        return redirect()->route('location.index')->with('success', __('admin.Updated Successfully'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $ex = explode(',', $request->id);



foreach ($ex as $key => $value) {
    $location = Location::findOrFail($value);

    $location->delete();
}



session()->flash('success', __('admin.Deleted Successfully'));

        return redirect()->back();
    }


}
