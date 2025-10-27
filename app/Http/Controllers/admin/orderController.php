<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\order;
use App\Models\product;
use Illuminate\Http\Request;

class orderController extends Controller
{
    public function list_order(){
        $orders = order::all();
        return view('admin.order.list',[
            'orders'=>$orders,
            'title' => 'Danh Sách Đơn Hàng'
        ]);
    }
    public function show_order(Request $request){
        $chitiet= json_decode($request->chitiet,true);
        $product_id=array_keys($chitiet);
        $products = product::whereIn('id',$product_id)->get();

        return view('admin.order.details',[
            'title' => 'Thông tin đơn hàng',
            'products' => $products,
            'chitiet'=>$chitiet
        ]);
    }
     public function delete_order($id){
        order::find($id)->delete();

        return response()->json(['success'=>true]);
    }

    public function complete_order($id){
        $order = order::find($id);
        
        if (!$order) {
            return response()->json(['success'=>false, 'message'=>'Đơn hàng không tồn tại']);
        }

        // Chỉ có thể hoàn thành đơn đã được xác nhận
        if (!$order->confirmed_at) {
            return response()->json(['success'=>false, 'message'=>'Đơn hàng chưa được xác nhận']);
        }

        $order->completed_at = now();
        $order->trangthai = 2; // 2 = đã hoàn thành
        $order->save();

        return response()->json(['success'=>true, 'message'=>'Đơn hàng đã được hoàn thành']);
    }

}
