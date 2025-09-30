<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasCrudPermissions;
use App\Models\Answer;
use App\Models\Result;
use App\Models\User;
use Illuminate\Http\Request;

class ResultController extends Controller
{
     use HasCrudPermissions;


        public function __construct()
    {
         $this->applyCrudPermissions('result');
          $this->middleware('permission:view hr')->only(['hr']);


    }


        /**
     * Display a listing of the resource.
     */
     public function index(Request $request,$id)
    {



   $query = Result::where(['user_id'=>$id,'status'=>2])  ;
      $results = $query

        ->orderBy('created_at', 'desc')
        ->paginate(10)

        ->appends($request->query());
// return $user->position->name;

// return $user->department_user->first()->unit->name ?? 'No Unit';


         return view('admin.result.index', get_defined_vars());
    }



     public function hr(Request $request )
    {

   $results = Result:: orderBy('created_at', 'desc')
        ->paginate(10)
        ->appends($request->query());
// return $user->position->name;

// return $user->department_user->first()->unit->name ?? 'No Unit';


         return view('admin.result.hr', get_defined_vars());
    }


     public function toggleStatus(Request $request)
{

    $result = Result::findOrFail($request->id);
    if ($result->status == 0 or $result->status == 1) {
         $result->status = 2;

    }else{
        $result->status = 0;
    }
 $result->save();

    return response()->json(['success' => true, 'new_status' => $result->status]);
}


 public function  approved(Request $request)
{
    // return$request;
    $result = Result::findOrFail($request->id);
    $result->status = 1;
    $result->comment3 =  $request->comment3;
    $result->save();

return redirect()->route('hr.index')->with('success', __('admin.Updated Successfully'));}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//  return$request->score;

              $result = Result::create([
                    "score"=>0,
                    "comment"=>$request->comment1,
                    "year"=> now()->format('Y-m-d'),
                    "user_id"=>$request->user_id,
                ]);

                 foreach ($request->comment as $key => $value) {
                //  return$value;
                Answer::create([
                    "score"=>$request->score[$key],
                    "num"=>$key+1,
                    "comment"=>$value,
                    "year"=> now()->format('Y-m-d'),
                    "user_id"=>$request->user_id,
                    "result_id"=>$result->id,
                ]);
            }

                $sum = Answer::where([ "result_id"=>$result->id])->get()->sum("score");


            $result->update([
                    "score"=>$sum,
                ]);
  $user = User::with(['department_user.unit'])->findOrFail($request->user_id);

   return view('admin.result.show', get_defined_vars());


    }

    /**
     * Display the specified resource.
     */
    public function show(Result $result)
    {
// return$result;
                $sum = Answer::where([ "result_id"=>$result->id])->get()->sum("score");




         return view('admin.result.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */

public function edit(Result $result)
    {


         return view('admin.result.edit', get_defined_vars());
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Result $result)
    {

        //   return$result;


                $result1 = Result::create([
                    "score"=>0,
                    "comment"=>$request->comment1,
                    "comment2"=>$request->comment2,
                    "year"=> $result->year,
                    "user_id"=>$result->user_id,
                ]);

                 foreach ($request->comment as $key => $value) {
                //  return$value;
                Answer::create([
                    "score"=>$request->score[$key],
                    "num"=>$key+1,
                    "comment"=>$value,
                    "year"=> $result->year,
                    "user_id"=>$result->user_id,
                    "result_id"=>$result1->id,
                ]);
            }

                $sum = Answer::where([ "result_id"=>$result1->id])->get()->sum("score");


            $result1->update([
                    "score"=>$sum,
                ]);


if ($result1) {
   $result->delete();
}


                return redirect()->route('result.show',$result1->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Result $result)
    {
        //
    }
}
