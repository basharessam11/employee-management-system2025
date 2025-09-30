<?php


namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Traits\MeetingZoomTrait;
use App\Models\Meeting;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Jubaer\Zoom\Facades\Zoom;
use Yajra\DataTables\Facades\DataTables;

class MeetingController extends Controller
{
    use MeetingZoomTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('customer.meeting.index'  );
    }
    public function data()
    {

        $customer_id = Auth::guard('customer')->user()->id;


        $meeting = Meeting::with([
            'customer:id,name,phone,photo',

 ])->where('customer_id',$customer_id)->orderBy('created_at', 'desc')

 ->get(['id','topic','start_at','join_url','start_url','customer_id'] );

        return DataTables::of($meeting)

            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create($customer_id,$booking_id)
    {
        return view('customer.meeting.create' ,get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $meeting = $this->createMeeting($request);

        //   return$meeting['data'] ;
             Meeting::create([

                'booking_id' => $request->booking_id,
                'customer_id' => $request->customer_id,

                'meeting_id' => $meeting['data']['id'],
                'topic' => $request->topic,
                'start_at' => $request->start_at,
                'duration' => $meeting['data']['duration'],

                'start_url' => $meeting['data']['start_url'],
                'join_url' =>$meeting['data']['join_url'],
            ]);

            session()->flash('success',  __('customer.Created Successfully'));
            return redirect()->route('meeting.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Meeting $meeting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $zoom = Setting::findOrFail(1);
        return view('customer.zoom.index',get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'ZOOM_CLIENT_KEY' => 'required|string',
            'ZOOM_CLIENT_SECRET' => 'required|string',
            'ZOOM_ACCOUNT_ID' => 'required|string',
        ]);

        $zoom = Setting::findOrFail(1);
        $zoom->update($request->all());



        return redirect()->route('meeting.edit')->with('success', __('customer.Updated Successfully'));
    }


}
