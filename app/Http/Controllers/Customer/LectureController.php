<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

use App\Http\Requests\LectureRequest;
use App\Models\Customer;
use App\Models\Group;
use App\Models\Lecture;
use App\Models\LectureFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LectureController extends Controller
{
    public function index(Request $request )
    {



       $group_id = Auth::guard('customer')->user()->group_id;


       $search = $request->query('search');


       $query = Lecture::query();


  $query->whereHas('group', function ($q) use ($group_id) {
               $q->where('group_id', $group_id);
           });


       if (!empty($search)) {
           $query->where(function ($q) use ($search) {
               $q->where('name', 'LIKE', "%$search%") ;
           });
       }

        $lectures = $query->where('status',1)->orderBy('created_at', 'desc')->paginate(10);


       $groups = Group::get(['id', 'title' ]);

//   return get_defined_vars();
        return view('customer.lecture.index', get_defined_vars());
    }


    /**
     * Show the form for creating a new resource.
     */
    public function show($id)
    {
          $lectures = Lecture::findOrFail($id);
          if ($lectures->status==2) {
            return redirect()->route('lecture1.index');
          }
        return view('customer.lecture.show',  get_defined_vars());

    }

}
