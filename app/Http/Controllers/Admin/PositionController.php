<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PositionRequest;
use App\Http\Traits\HasCrudPermissions;
use App\Models\Grade;
use App\Models\Jop;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
 use HasCrudPermissions;

    public function __construct()
    {
         $this->applyCrudPermissions('position');
    }


        public function index(Request $request)
    {


         $query = Position::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'LIKE', "%{$search}%");

        }



          $positions = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->query());



        return view('admin.position.index', get_defined_vars());

    }



    public function create()
    {

         $jops = Jop::all();
         $grades = Grade::all();


        return view('admin.position.create' , get_defined_vars());

    }

    public function store( PositionRequest $request)
    {

        Position::create($request->all());
        return redirect()->route('position.index')->with('success', __('admin.Created Successfully'));
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
         $position  = Position::findOrFail($id);
        $grades = Grade::all();

        $jops = Jop::all();



        return view('admin.position.edit',  get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PositionRequest $request,  $id)
    {

// return$request;
        $user = Position::findOrFail($id);
         $user->update($request->all());



        return redirect()->route('position.index')->with('success', __('admin.Updated Successfully'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $ex = explode(',', $request->id);



foreach ($ex as $key => $value) {
    $position = Position::findOrFail($value);

    $position->delete();
}



session()->flash('success', __('admin.Deleted Successfully'));

        return redirect()->back();
    }


}
