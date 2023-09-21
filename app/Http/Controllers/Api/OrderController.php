<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $orders = Order::where('user_id',$user_id)->get();
        return response()->json($orders);
    }

    public function all()
    {
        $orders = Order::orderBy('status','ASC')->get();
        return response()->json($orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'email' => 'required|max:255',
                'phone' => 'required|max:255',
                'address' => 'required|max:255',
                'sub_total' => 'required',
                'tax' => 'required',
                'delivery' => 'required',
                'total' => 'required',
            ]
        );
        if ($validation->fails()) {
            $validation_error = "";
            foreach ($validation->errors()->all() as $message) {
                $validation_error .= $message;
            }
            return response()->json(['data' => [], 'message' => $message, 'success' => false], 402);
        }
        $order = new Order;
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->user_id = $request->user_id;
        $order->sub_total = $request->sub_total;
        $order->tax = $request->tax;
        $order->discount = $request->discount;
        $order->delivery = $request->delivery;
        $order->total = $request->total;
        $order->status = 1;
        $order->comment = $request->comment;
        $order->save();
        $cart = Cart::where('user_id', $request->user_id)->get();
        foreach ($cart as $key => $item) {
            $order_detail = new OrderDetail;
            $order_detail->order_id = $order->id;
            $order_detail->product_id = $item->product_id;
            $order_detail->name = $item->name;
            $order_detail->slug = $item->slug;
            $order_detail->price = $item->price;
            $order_detail->category = $item->category;
            $order_detail->color = $item->color;
            $order_detail->url = $item->url;
            $order_detail->description = $item->description;
            $order_detail->quantity = $item->quantity;
            $order_detail->user_id = $item->user_id;
            $order_detail->save();
        }
        $cart = Cart::where('user_id', $request->user_id)->delete();
        return response()->json(['data' => $order, 'message' => 'Order Place Successfully!', 'success' => true], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Order::find($id)->delete();
        return response()->json(['data' => [], 'message' => 'Order Deleted Successfully!', 'success' => true], 200);
    }
    public function status($id,$status_id)
    {
        $order = Order::find($id);
        $order->status = $status_id;
        $order->update();
        return response()->json(['data' => [], 'message' => 'Order Status Change Successfully!', 'success' => true], 200);
    }
}
