<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use App\Models\order;
use Illuminate\Http\Request;
use App\Models\product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Expr\Cast\String_;
use Stringable;
use Symfony\Component\HttpFoundation\Session\Session as SessionSession;

use function PHPUnit\Framework\isNull;

class FrontendController extends Controller
{
    public function index(){
        $products= product::paginate(8);
        
        return view('welcome',[
            'products'=>$products
        ]);
    }
    public function showproduct(Request $request){
        $product = product::find($request->id);
        $products= product::paginate(8);
        return view('product',[
            'product'=>$product,
            'products'=>$products
        ]);
    }
    //cart
     public function addcart(Request $request)
    {
        $product_id = $request->product_id;
        $product_qty = $request->product_qty;
        $cart = Session::get('cart', []);

        //  cộng thêm số lượng
        if (isset($cart[$product_id])) {
            $cart[$product_id] += $product_qty;
        } else {
            $cart[$product_id] = $product_qty;
        }

        Session::put('cart', $cart);
        return redirect('/cart');
    }

    public function showcart()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return view('cart', ['products' => [], 'cart' => []]);
        }

        $product_ids = array_keys($cart);
        $products = Product::whereIn('id', $product_ids)->get();
        return view('cart', [
            'products' => $products,
            'cart' => $cart
        ]);
    }
    public function removecart(Request $request){
        $cart=Session::get('cart');
        $product_id=$request -> id;
        unset($cart[$product_id]);
         Session::put('cart', $cart);
         return redirect('/cart');
    }

    public function showcheck(Request $request){
        // Lấy giỏ hàng từ Session
        $cart = Session::get('cart', []);

        if(empty($cart)) {
            return redirect('/cart')->with('message', 'Giỏ hàng trống, không thể thanh toán!');
        }

        // Lấy thông tin sản phẩm từ database
        $products = Product::whereIn('id', array_keys($cart))->get();
        return view('checkout', compact('cart', 'products'));
    }
    //send cart
    public function cart_send(Request $request){
        $token = Str::random(12);
        $order = new order;
        $order -> name = $request->input('name');
        $order -> phone = $request->input('phone');
        $order -> email = $request->input('email');
        $order -> address = $request->input('address');
        $order_chitiet = json_encode($request->input('product_id'));
        $order->chitiet= $order_chitiet;
        $order -> token = $token;
        $order->save();
        $mailifor = $order ->email;
        $nameifor = $order ->name;
        $Mail = Mail::to($mailifor) ->send(new TestMail($nameifor));
        Session::forget('cart');
        return redirect('/cart')->with('success', 'Đặt hàng thành công!');

    }
}
