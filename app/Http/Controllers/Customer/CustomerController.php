<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customer_id = Auth::guard('customer')->user()->id;
        $customers = Customer::where('id',$customer_id)->withCount('booking')
        ->withSum('booking', 'total')->paginate(10);
        return view('customer.customer.index',get_defined_vars());
    }

    public function data()
    {
        $customer_id = Auth::guard('customer')->user()->id;
        $customer = Customer::with('country:id,name', 'orders', 'booking') // إذا كنت تستخدم علاقة مع جدول الطلبات
        ->withCount('orders')
        ->withSum('orders', 'total')
        ->withCount('booking')

        ->withSum('booking', 'total')
        ->where('id',$customer_id)
        ->orderBy('created_at', 'desc')
        ->get(['id', 'name', 'phone', 'country_id', 'photo']);



        return DataTables::of($customer)

            ->make(true);
    }


    public function show($id)
    {
        $customer =Customer::findOrFail($id);

        $customer_id = Auth::guard('customer')->user()->id;

        if ($id == $customer_id) {








    $count = $customer->orders->count();
    $total = $customer->orders->sum('total');
    $count1 = $customer->booking->count();
    $total1 = $customer->booking->sum('total');



    $order =$customer->order;
    $date = Carbon::parse($customer->created_at)->format('M d, Y, h:i A (ET)');
    $country = Country::all();

    return view('customer.customer.show',get_defined_vars());
}else{
    abort(404);
}

    }
    public function getorder($id)
    {

        $order = Order::where('customer_id',$id)->get( );



        return DataTables::of($order)

            ->make(true);
    }
     /**
     * Display the specified resource.
     */
    public function show2($id)
    {
        // $recentDevices = recent_devices::where('customer_id',$id)->orderBy('activity_time', 'desc')->get();

        $customer =Customer::findOrFail($id);

    $count = $customer->orders->count();
    $total = $customer->orders->sum('total');

    $count1 = $customer->booking->where('status', 1)->count();
    $total1 = $customer->booking->where('status', 1)->sum('total');




    $order =$customer->order;
    $country = Country::all();
    $order =$customer->order;
    $date = Carbon::parse($customer->created_at)->format('M d, Y, h:i A (ET)');
    return view('customer.customer.show2',get_defined_vars());

    }


     /**
     * Display the specified resource.
     */
    public function show3($id)
    {
        $customer =Customer::findOrFail($id);

        $count = $customer->order->count();
        $total = $customer->order->sum('total');

        $order =$customer->order;


        $address =$customer->address;
        $visa =$customer->visa;
        $country = Country::all();
        $order =$customer->order;
        $date = Carbon::parse($customer->created_at)->format('M d, Y, h:i A (ET)');

        return view('customer.customer.show3',get_defined_vars());

    }


     /**
     * Display the specified resource.
     */
    public function show4($id)
    {
        $customer =Customer::findOrFail($id);

        $count = $customer->orders->count();
        $total = $customer->orders->sum('total');

        $order =$customer->order;
        $country = Country::all();
        $order =$customer->order;
        $date = Carbon::parse($customer->created_at)->format('M d, Y, h:i A (ET)');
        return view('customer.customer.show4',get_defined_vars());

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatepass(Request $request )
    {
        // return $request;
        $request->validate([
            'newPassword' => 'required|string|min:8|confirmed',

        ]);


          $customer = Customer::where("id",$request->id);
        $customer->update([
            'password'=>Hash::make($request->newPassword)
        ]);


    session()->flash('success',  __('admin.Updated Successfully'));

        return redirect()->back(); // يمكنك إعادة توجيه المستخدم إلى الصفحة السابقة
    }


    public function update(CustomerRequest $request,$id)
    {

        // return $request;
        $customer = Customer::findOrFail($id);
        $customer->update($request->all());

        return redirect()->back()->with('success',__('admin.Updated Successfully'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
