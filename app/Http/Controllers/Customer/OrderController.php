<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Traits\PaypalTrait;
use App\Http\Traits\StripeTrait;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Order_Pro;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class OrderController extends Controller
{

    public function index()
    {


        return view('customer.order.index',get_defined_vars());
    }

    public function data()
    {

        $customer_id = Auth::guard('customer')->user()->id;
        $order = Order::with([
            'customer:id,name,phone,photo',



        ])->where('customer_id',$customer_id)->orderBy('created_at', 'desc')->get();

        return DataTables::of($order)



          ->make(true);
     }












    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $customer_id = Auth::guard('customer')->user()->id;
        $order = Order::where(['customer_id'=>$customer_id, 'id'=>$id])->first();



         if ($order) {




        $date = Carbon::parse($order->created_at)->format('M d, Y, h:i A (ET)');

        return view('customer.order.show',get_defined_vars());
    }else{
        abort(404);
    }




    }
    public function getorder($id)
    {
        $customer_id = Auth::guard('customer')->user()->id;
        $order = Order_Pro::with([
            'product:id,title_en,title_ar,photo,price,price1',




        ])->where('customer_id',$customer_id)->where('order_id',$id)->get();

        return DataTables::of($order)

            ->make(true);


        // $order = Order_Pro::where('order_id',$id)->get( );



        // return DataTables::of($order)

        //     ->make(true);
    }


}
