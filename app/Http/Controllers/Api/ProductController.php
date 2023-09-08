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
        $product->description = $request->description;
        $product->save();
        return response()->json(['data' => $product, 'message' => 'Product Added Successfully!', 'success' => true], 200);
    }
    public function edit($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }
    public function update(Request $request)
    {
        $product = Product::find($request->id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->category = $request->category;
        $product->color = $request->color;
        $product->url = $request->url;
        $product->description = $request->description;
        $product->save();
        return response()->json(['data' => $product, 'message' => 'Product Updated Successfully!', 'success' => true], 200);
    }
    public function delete($id)
    {
        Product::find($id)->delete();
        return response()->json(['data' => [], 'message' => 'Product Deleted Successfully!', 'success' => true], 200);
    }
}
