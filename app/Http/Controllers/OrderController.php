<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
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

        dd($request);
        $data = $request->validate([
            
            'payment_method' =>'required',
            'shipping_address' =>'required',
            'phone' =>'required',
            'person_name' =>'required',
        ]);


        


        $data['user_id'] = auth()->user()->id;
        $data['order_date'] = date('Y-m-d');
        $data['status'] = "Pending";
        $cartids = cart::where('user_id',$data['user_id'])->where('is_ordered',false)->get();
        $totalamount = 0;
        foreach($cartids as $cartid)
        {
            $total = $cartid->qty * $cartid->product->price;
            $totalamount += $total;
        }
        $data['amount'] = $totalamount;
        $ids = $cartids->pluck('id')->toArray();
        $data['cart_id'] = implode(',',$ids);
        order::create($data);
        cart::whereIn('id',$ids)->update(['is_ordered'=>true]);

        $data=[
            'name'=> auth()->user()->name,
            'mailmessage'=>'New Order has been placed',
        
        ];

        Mail::send('email.email',$data,function($message){
            $message->to(auth()->user()->email)
            ->subject('New Order Placed');
        });
        return back()->with('success','Order placed succesfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(order $order)
    {
        //
    }

    public function index()
    {

        $orders = order::all();
        return view('orders.index',compact('orders'));
    }

    public function details($orderid)
    {   

        
        $order = order::find($orderid);
        $carts = cart::whereIn('id',explode(',',$order->cart_id))->get();
        return view('orders.details',compact('carts','order'));

        
        
    }

    public function status($id,$status)
    {
        $order = order::find($id);
        $order->status = $status;
        $order->save();
        return redirect(route('order.index'))->with('success','Status changed to'.$status);
        
    }


    public function orderstatus($status)
    {
                  
    }
}
