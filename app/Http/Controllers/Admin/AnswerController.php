<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasCrudPermissions;
use App\Models\Answer;
use App\Models\Result;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    use HasCrudPermissions;


            public function __construct()
    {
         $this->applyCrudPermissions('answer');

    }
    /**
     * Display a listing of the resource.
     */
     public function index(Request $request,$id)
    {

 $user = User::with(['department_user.unit'])->findOrFail($id);
// return $user->position->name;

// return $user->department_user->first()->unit->name ?? 'No Unit';


         return view('admin.answer.index', get_defined_vars());
    }


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
//    return$request;
            // foreach ($request->comment as $key => $value) {
            //     //  return$value;
            //     Answer::create([
            //         "score"=>$request->score[$key],
            //         "num"=>$key+1,
            //         "comment"=>$value,
            //         "year"=> now()->year,
            //         "user_id"=>$request->user_id,
            //     ]);
            // }



                $validated = $request->validate([

        'comment'   => 'required|array|min:1',
        'comment.*' => 'required|string|max:500', // كل تعليق يجب أن يكون نصي
        'score'     => 'required|array|min:1',
        'score.*'   => 'required|integer|min:1|max:5', // كل score بين 1 و 5
        'comment1'  => 'nullable|string|max:500',
        'user_id'   => 'required|integer|exists:users,id', // user_id يجب أن يكون موجود في جدول users
    ]);




$year = Carbon::now()->year;

 $result1 = Result::whereYear('year', $year) // ✅ مقارنة السنة فقط
    ->where('user_id', $request->user_id)
    ->count();

if (!$result1) {
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
}else{
      return redirect()->back()->with('error', __('admin.You cannot add more than 1 evaluation for an employee in the same year!'));
}




   return redirect()->route("result.show",$result->id) ;


    }

    /**
     * Display the specified resource.
     */
    public function show(Answer $answer)
    {
         return view('admin.result.print', ["result_id"=>$answer]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Answer $answer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Answer $answer)
    {
        //
    }
}
