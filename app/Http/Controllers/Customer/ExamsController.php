<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Answers;
use App\Models\CustomerExam;
use App\Models\Exams;
use App\Models\QuestionOptions;
use App\Models\Questions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamsController extends Controller
{









    public function index(Request $request)
    {

        $query = CustomerExam::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('title', 'LIKE', "%{$search}%") ;

        }
        $customer_id = Auth::guard('customer')->user()->id;



        $exams = $query->where('customer_id',$customer_id)-> orderBy('created_at', 'desc')->paginate(10); // هنا يتم تفعيل التصفح



        return view('customer.exam.index', get_defined_vars());
    }

    public function show(Request $request,$exam_id )
    {

        //    return$request ;

        $customer_id = Auth::guard('customer')->user()->id;

          $lastRecord = CustomerExam::where(['id' => $request->customer_exams_id])->first();

    if ($lastRecord) {
        $lastRecord->update(['status' => 1,'time' => $request->time??'00:00:00']);
    }




if ($request->answer and $request->answer !=null) {
    # code...

  if ($request->has(['answer', 'type', 'question_id']) ) {
    $validated = $request->validate([
         'index' => 'required|integer ',
        'type' => 'required|in:1,2,3',
        'question_id' => 'required|exists:questions,id',
    ]);
    $answer = $request->answer;
    $type = $request->type;
    $question_id = $request->question_id;

      $exists = Answers::where('exam_id', $exam_id) ->where([
        'exam_id'=> $exam_id,
            'question_id'=> $question_id,
            'customer_id' => $customer_id,
            'customer_exams_id' => $request->customer_exams_id,

        ] )->first();

    if (!$exists) {
        if ( $type == 1) {
         $status = QuestionOptions::where('status', 1)
            ->where('question_id', $question_id)
            ->first();
            // return $status->name;
            if ($status->name == $answer) {
                Answers::create([
                    'customer_id' => $customer_id,
                    'answer' => $answer,
                    'type' => $type,
                    'exam_id' => $exam_id,
                    'status' => 1,
                    'question_id' => $question_id,
            'customer_exams_id' => $request->customer_exams_id,

                ]);
            }else{
                Answers::create([
                    'customer_id' => $customer_id,
                    'answer' => $answer,
                    'type' => $type,
                    'exam_id' => $exam_id,
                    'question_id' => $question_id,
            'customer_exams_id' => $request->customer_exams_id,

                ]);
            }

        }else{
            Answers::create([
                'customer_id' => $customer_id,
                'answer' => $answer,
                'type' => $type,
                'exam_id' => $exam_id,
                'question_id' => $question_id,
            'customer_exams_id' => $request->customer_exams_id,

            ]);
        }

    }else{


        if ( $type == 1) {
            $status = QuestionOptions::where('status', 1)
               ->where('question_id', $question_id)
               ->first();
               if ($status->name == $answer) {
                $exists->update([
                       'customer_id' => $customer_id,
                       'answer' => $answer,
                       'type' => $type,
                       'exam_id' => $exam_id,
                       'status' => 1,
                       'question_id' => $question_id,
            'customer_exams_id' => $request->customer_exams_id,

                   ]);

               }




    }else{

                // return$answer  ;
                $exists->update([
                    'customer_id' => $customer_id,
                    'answer' => $answer,
                    'type' => $type,
                    'exam_id' => $exam_id,
                    'status' => 0,

                    'question_id' => $question_id,
            'customer_exams_id' => $request->customer_exams_id,

                ]);
               }
}
}

}


// return$request;
        $savedAnswer = Answers::where(['customer_id'=> $customer_id,'exam_id'=>$exam_id])->latest('id')->first();
        $questions = Questions::where('exam_id', $exam_id)->get();

        $index = $request->index??0;

        if ($index < 0 || $index >= $questions->count()) {
            return redirect()->route('exam1.index');
        }

        $question = $questions[$index];

         $options = $question->options() ->where('question_id', $question->id)->get();

        $answer2 = Answers::where(['question_id'=>$question->id,'customer_id'=> $customer_id,'exam_id'=>$exam_id])->first();



    //  return get_defined_vars();
        return view('customer.exam.show',get_defined_vars());
    }


    public function create()
    {

        return view('customer.exam.create' );
    }

    public function store( Request $request)
    {
    //    return    $request;
 #############################Product###########################################
 $request->validate([
    'title' => 'required|string|max:255',
]);

  Exams::create(['title' => $request->title,]);
#############################End Product########################################



         session()->flash('success', __('admin.Created Successfully'));
        return redirect()->route('exam.index', $request->exam_id);



    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $exam = Exams::find($id);
        return view('customer.exam.edit',get_defined_vars());

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // return $request;
         $exam = Exams::findOrFail($id);

        ############################# تحديث السؤال ###########################################
        $exam->update(['title' => $request->title,]);

//   return $exam->type .'<br>'. $request->type ;


        ############################# End تحديث السؤال ########################################



        session()->flash('success', __('admin.Updated Successfully'));
        return redirect()->route('customer.index');
    }



    public function destroy(Request $request)
    {
        $ex = explode(',', $request->id);



        Exams::destroy($ex);


        session()->flash('success', __('admin.Deleted Successfully'));

        return redirect()->back();
    }
}
