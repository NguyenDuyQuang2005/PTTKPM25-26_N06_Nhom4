<?php

namespace App\Http\Controllers;

use App\Models\order;
use Illuminate\Http\Request;

class OrderConfirmationController extends Controller
{
    public function confirm($token)
    {
        $order = order::where('token', $token)->first();
        
        if (!$order) {
            return redirect('/')->with('error', 'Token không hợp lệ hoặc đơn hàng không tồn tại!');
        }
        
        // Kiểm tra xem đã xác nhận chưa
        if ($order->confirmed_at) {
            return redirect('/')->with('message', 'Đơn hàng đã được xác nhận trước đó!');
        }
        
        // Xác nhận đơn hàng
        $order->confirmed_at = now();
        $order->trangthai = 1;
        $order->save();
        
        return redirect('/')->with('success', 'Cảm ơn bạn đã xác nhận đơn hàng! Đơn hàng #' . $order->id . ' đã được xử lý.');
    }
}
