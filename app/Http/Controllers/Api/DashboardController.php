<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $orders=Order::count();
        $sale_products = OrderDetail::sum('quantity');
        $products = Product::count();
        $category = Category::count();
        $blogs=Blog::count();
        $users = User::where('role',2)->count();
        $sales = Order::sum('total');
        $total_orders = Order::where('status',1)->get();
        $data = [
            "sales"=>$sales,
            "orders"=>$orders,
            "sale_products"=>$sale_products,
            "products"=>$products,
            "category"=>$category,
            "blogs"=>$blogs,
            "users"=>$users,
            "total_orders"=> $total_orders
        ];
        return response()->json($data);
    }
    public function userIndex($id)
    {
        $orders = Order::where('user_id',$id)->count();
        $sales = Order::where('user_id', $id)->sum('total');
        $data = [
            "sales" => $sales,
            "orders" => $orders
        ];
        return response()->json($data);
    }
}
