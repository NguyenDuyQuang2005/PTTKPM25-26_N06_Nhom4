<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\product;
use Illuminate\Http\Request;

class productController extends Controller
{
    public function insert_product(Request $request){
        $product = new product();
        $product->name = $request->input('name');
        $product->masanpham = $request->input('masanpham');
        $product->price_normal = $request->input('price_normal');
        $product->price_sale = $request->input('price_sale');
        $product->description = $request->input('description');
        $product->content = $request->input('content');
        $product->image = $request->input('image');
        $product_images = implode('*', (array) $request->input('images'));
        $product -> images = $product_images;
        $product -> save();
        return redirect('/admin/product/list')->with('success', 'Thêm sản phẩm thành công');
    }
     public function add_product(Request $request){
        return view('admin/product/add',[
            'title' => 'Thêm Sản Phẩm'
        ]);
    }
      public function list_product(Request $request){
        $product = product::latest()->paginate(4);

        return view('admin/product/list',[
            'title' => 'Danh Sách Sản Phẩm',
            'products'=>$product
        ]);
    }
     public function delete_product(Request $request){
        product::find($request -> product_id)->delete();

        return response()-> json([
            'success'=>true
        ]);
    }   
    public function edit_product(Request $request){
        product::find($request -> id);
         $product = product::find($request->id);
         return view('admin.product.edit',[
            'title' =>'Sửa sản phẩm',
            'product' => $product
         ]);
    }  
     public function update_product(Request $request){
        $product = product::find($request -> id);
        $product->name = $request->input('name');
        $product->masanpham = $request->input('masanpham');
        $product->price_normal = $request->input('price_normal');
        $product->price_sale = $request->input('price_sale');
        $product->description = $request->input('description');
        $product->content = $request->input('content');
        $product->image = $request->input('image');
        $product_images = implode('*', (array) $request->input('images'));
        $product -> images = $product_images;
        $product -> save();
        return redirect('/admin/product/list')->with('success', 'Cập nhật sản phẩm thành công');
    }
}