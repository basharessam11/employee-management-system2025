<?php



 namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentUserRequest;
use App\Http\Traits\HasCrudPermissions;
use App\Models\Department;
use App\Models\DepartmentUser;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentUserController extends Controller
{

              use HasCrudPermissions;

    public function __construct()
    {
         $this->applyCrudPermissions('department_user');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,$id)
    {
 $user = User::with(['department_user.unit'])->findOrFail($id);
// return $user->position->name;

// return $user->department_user->first()->unit->name ?? 'No Unit';


         return view('admin.department_user.index', get_defined_vars());
    }









    /**
     * Display the specified resource.
     */

public function show(Request $request, $id)
{


  $user = Auth::user();

if (!$user->hasRole('admin')) {
foreach ($user->department_user as $du) {
        $department_id = $du->department->id;


    }
    $query = DepartmentUser::with(['user', 'unit', 'department']);

   if ($request->has('user_id') && $request->user_id != '' && $request->user_id != 'all') {

            $query->where('user_id', $request->user_id);

        }

    $departments = $query
        ->where('department_id', $department_id)
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->appends($request->query());
$users = DepartmentUser::where('department_id', $department_id)->with(['user:id,name_ar,name_en' ])->get(['id','user_id']);

}else{
        $query = DepartmentUser::with(['user', 'unit', 'department']);

   if ($request->has('user_id') && $request->user_id != '' && $request->user_id != 'all') {

            $query->where('user_id', $request->user_id);

        }

    $departments = $query
        ->where('department_id', $id)
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->appends($request->query());
    $users = DepartmentUser::where('department_id',$id)->with(['user:id,name_ar,name_en' ])->get(['id','user_id']);
}



    return view('admin.department_user.show', get_defined_vars());
}


    public function create($id)
    {

         $units = Unit::all();
         $departments = Department::all();
         $users = User::all();


        return view('admin.department_user.create' , get_defined_vars());

    }

    public function store( DepartmentUserRequest $request,$id)
    {


         $department = Department::where('id',$id)->first();
        DepartmentUser::create([
            'user_id'=>$request->user_id,
            'unit_id'=>$department->unit_id,
            'department_id'=>$id,
        ]);
        return redirect()->route('department_user.show',$id)->with('success', __('admin.Created Successfully'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $department  = DepartmentUser::findOrFail($id);
        $users = User::all();





        return view('admin.department_user.edit',  get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentUserRequest $request,  $id)
    {

// return$request;
        $user = DepartmentUser::findOrFail($id);
         $user->update($request->all());



        return redirect()->route('department_user.show',$user->department_id)->with('success', __('admin.Updated Successfully'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $ex = explode(',', $request->id);



foreach ($ex as $key => $value) {
    $departments = DepartmentUser::findOrFail($value);

    $departments->delete();
}



session()->flash('success', __('admin.Deleted Successfully'));

        return redirect()->back();
    }


}
