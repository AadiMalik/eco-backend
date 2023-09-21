<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('category_name')->get();
        return response()->json($blogs);
    }
    public function store(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'title' => 'required|max:255',
                'category_id' => 'required',
                'url' => 'required|url|max:1000',
                'description' => 'required|max:1000',
            ]
        );
        if ($validation->fails()) {
            $validation_error = "";
            foreach ($validation->errors()->all() as $message) {
                $validation_error .= $message;
            }
            return response()->json(['data' => [], 'message' => $message, 'success' => false], 402);
        }
        $blog = new Blog;
        $blog->title = $request->title;
        $blog->slug = \Str::slug($request->title);
        $blog->category_id = $request->category_id;
        $blog->url = $request->url;
        $blog->description = $request->description;
        $blog->save();
        return response()->json(['data' => $blog, 'message' => 'Blog Added Successfully!', 'success' => true], 200);
    }
    public function edit($id)
    {
        $blog = Blog::find($id);
        return response()->json($blog);
    }
    public function update(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'title' => 'required|max:255',
                'category_id' => 'required',
                'url' => 'required|url|max:1000',
                'description' => 'required|max:1000',
            ]
        );
        if ($validation->fails()) {
            $validation_error = "";
            foreach ($validation->errors()->all() as $message) {
                $validation_error .= $message;
            }
            return response()->json(['data' => [], 'message' => $message, 'success' => false], 402);
        }
        $blog = Blog::find($request->id);
        $blog->title = $request->title;
        $blog->slug = \Str::slug($request->title);
        $blog->category_id = $request->category_id;
        $blog->url = $request->url;
        $blog->description = $request->description;
        $blog->save();
        return response()->json(['data' => $blog, 'message' => 'Blog Updated Successfully!', 'success' => true], 200);
    }
    public function destroy($id)
    {
        Blog::find($id)->delete();
        return response()->json(['data' => [], 'message' => 'Blog Deleted Successfully!', 'success' => true], 200);
    }

    public function getByCategory($id)
    {
        if($id==0){
            $blog = Blog::get();
        }else{
            $blog = Blog::where('category_id', $id)->get();
        }
        return response()->json($blog);
    }
    public function getBlogBySearch(Request $request)
    {
        $blog = Blog::where('title', 'LIKE', '%' . $request->search . '%')->get();
        return response()->json($blog);
    }
    public function getBySlug($slug)
    {
        $blog = Blog::where('slug', $slug)->first();
        return response()->json($blog);
    }
}
