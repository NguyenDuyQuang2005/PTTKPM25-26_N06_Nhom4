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

}
