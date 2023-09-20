<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return response()->json($products);
    }
    public function store(Request $request){
        $validation = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'price' => 'required|max:20',
                'category' => 'required|max:255',
                'color' => 'required|max:255',
                'url' => 'required|url|max:255',
                'description' => 'required|max:255',
            ]
        );
        if ($validation->fails()) {
            $validation_error = "";
            foreach ($validation->errors()->all() as $message) {
                $validation_error .= $message;
            }
            return response()->json(['data' => [], 'message' => $message, 'success' => false], 402);
        }
        $product = new Product;
        $product->name = $request->name;
        $product->slug = \Str::slug($request->name);
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
        $validation = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'price' => 'required|max:20',
                'category' => 'required|max:255',
                'color' => 'required|max:255',
                'url' => 'required|url|max:255',
                'description' => 'required|max:255',
            ]
        );
        if ($validation->fails()) {
            $validation_error = "";
            foreach ($validation->errors()->all() as $message) {
                $validation_error .= $message;
            }
            return response()->json(['data' => [], 'message' => $message, 'success' => false], 402);
        }
        $product = Product::find($request->id);
        $product->name = $request->name;
        $product->slug = \Str::slug($request->name);
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
    public function getBySlug($slug)
    {
        $product = Product::where('slug', $slug)->first();
        return response()->json($product);
    }
}
