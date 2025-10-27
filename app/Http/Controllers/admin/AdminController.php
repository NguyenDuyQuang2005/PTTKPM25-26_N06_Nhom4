<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\product;
use App\Models\order;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get statistics
        $totalProducts = product::count();
        $totalOrders = order::count();
        $totalUsers = User::count();
        $totalComments = Comment::count();
        
        // Get recent orders
        $recentOrders = order::orderBy('created_at', 'desc')->limit(5)->get();
        
        // Get orders by status
        $confirmedOrders = order::whereNotNull('confirmed_at')->whereNull('completed_at')->count();
        $pendingConfirmationOrders = order::whereNull('confirmed_at')->count();
        $completedOrders = order::whereNotNull('completed_at')->count();
        
        // Get latest products
        $latestProducts = product::orderBy('created_at', 'desc')->limit(5)->get();
        
        // Calculate revenue from completed orders only
        $revenue = 0;
        $completedOrdersList = order::whereNotNull('completed_at')->get();
        
        foreach($completedOrdersList as $order) {
            if($order->chitiet) {
                $chitiet = json_decode($order->chitiet, true);
                if(is_array($chitiet)) {
                    // chitiet format: {"product_id": quantity, ...}
                    // Example: {"1": 2, "2": 3}
                    $productIds = array_keys($chitiet);
                    $products = product::whereIn('id', $productIds)->get();
                    
                    foreach($products as $product) {
                        $quantity = isset($chitiet[$product->id]) ? (int)$chitiet[$product->id] : 0;
                        // Tính tổng tiền dựa trên giá khuyến mãi
                        $price = is_numeric($product->price_sale) ? $product->price_sale : 0;
                        $revenue += $price * $quantity;
                    }
                }
            }
        }

        return view('admin.home', [
            'title' => 'Dashboard',
            'totalProducts' => $totalProducts,
            'totalOrders' => $totalOrders,
            'totalUsers' => $totalUsers,
            'totalComments' => $totalComments,
            'recentOrders' => $recentOrders,
            'pendingConfirmationOrders' => $pendingConfirmationOrders,
            'confirmedOrders' => $confirmedOrders,
            'completedOrders' => $completedOrders,
            'latestProducts' => $latestProducts,
            'revenue' => $revenue
        ]);
    }
}

