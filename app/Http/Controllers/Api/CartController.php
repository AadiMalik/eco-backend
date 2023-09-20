<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    
    public function index($id)
    {
        $cart = Cart::where('user_id', $id)->get();
        return response()->json($cart);
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'user_id' => 'required',
                'product_id' => 'required',
            ]
        );
        if ($validation->fails()) {
            $validation_error = "";
            foreach ($validation->errors()->all() as $message) {
                $validation_error .= $message;
            }
            return response()->json(['data' => [], 'message' => $message, 'success' => false], 402);
        }
        $cart_exit = Cart::where('product_id', $request->product_id)->where('user_id', $request->user_id)->first();
        if($cart_exit!=null)
        {
            $cart_exit->quantity = $cart_exit->quantity + $request->quantity;
            $cart_exit->update();
        }else{
            $cart = new Cart;
            $cart->product_id = $request->product_id;
            $cart->name = $request->name;
            $cart->slug = $request->slug;
            $cart->price = $request->price;
            $cart->category = $request->category;
            $cart->color = $request->color;
            $cart->url = $request->url;
            $cart->description = $request->description;
            $cart->quantity = $request->quantity;
            $cart->user_id = $request->user_id;
            $cart->save();
        }
        
        return response()->json(['data' => [], 'message' => 'Cart Added Successfully!', 'success' => true], 200);
    }

    
    public function show(Cart $category)
    {
        //
    }

    public function update(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
            ]
        );
        if ($validation->fails()) {
            $validation_error = "";
            foreach ($validation->errors()->all() as $message) {
                $validation_error .= $message;
            }
            return response()->json(['data' => [], 'message' => $message, 'success' => false], 402);
        }
        $cart = Cart::find($request->id);
        $cart->product_id = $request->product_id;
        $cart->name = $request->name;
        $cart->slug = $request->slug;
        $cart->price = $request->price;
        $cart->category = $request->category;
        $cart->color = $request->color;
        $cart->url = $request->url;
        $cart->description = $request->description;
        $cart->quantity = $request->quantity;
        $cart->user_id = $request->user_id;
        $cart->update();
        return response()->json(['data' => $cart, 'message' => 'Cart Updated Successfully!', 'success' => true], 200);
    }

    
    public function destroy($id,$user_id)
    {
        Cart::where('product_id',$id)->where('user_id', $user_id)->delete();
        return response()->json(['data' => [], 'message' => 'Cart Product Deleted Successfully!', 'success' => true], 200);
    }
}
