<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return response()->json($products);
    }
    public function store(Request $request){
        $product = new Product;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->category = $request->category;
        $product->color = $request->color;
        $product->url = $request->url;
        $product->save();
        return response()->json(['data' => $product, 'message' => 'Product Added Successfully!', 'success' => true], 200);
    }
}
