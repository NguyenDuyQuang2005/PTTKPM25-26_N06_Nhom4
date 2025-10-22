<!DOCTYPE html>
<html lang="vi">
<head>
    @include('parts.header')
</head>
<body>
<header>
    @include('parts.menu')
</header>

<main class="checkout-page">
    <form action="/cart/send" method="POST" class="container checkout-container">
        @csrf
        {{-- thong tin khach hang --}}
        <section class="checkout-section">
            <h3>Thông tin giao hàng</h3>
            <div class="form-group">
                <label>Họ và tên</label>
                <input class="form-input" type="text" name="name" required placeholder="Nguyễn Văn A">
            </div>
            <div class="form-group">
                <label>Số điện thoại</label>
                <input class="form-input" type="tel" name="phone" required placeholder="0901234567">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input class="form-input" type="email" name="email" placeholder="email@domain.com">
            </div>
            <div class="form-group">
                <label>Địa chỉ</label>
                <input class="form-input" type="text" name="address" required placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành">
            </div>

            <h3>Phương thức thanh toán</h3>
            <div class="form-group">
                <label><input type="radio" name="payment" value="cod" checked> Thanh toán khi nhận hàng (COD)</label>
            </div>
        </section>
        {{-- thong tin don hang --}}
        <aside class="checkout-section">
            <h3>Đơn hàng</h3>
            @php
                $total_qty = 0;
                $total_amount = 0;
            @endphp
            @foreach($products as $product)
                @php
                    $qty = $cart[$product->id] ?? 0;
                    $subtotal = $product->price_sale * $qty;
                    $total_qty += $qty;
                    $total_amount += $subtotal;
                @endphp
                <div style="display:flex; justify-content:space-between; align-items:center; padding:10px; border-bottom:1px solid #eee">
                    <div>
                        <div style="font-weight:600">{{ $product->name }}</div>
                        <div style="color:#666; font-size:12px">x{{ $qty }}</div>
                    </div>
                    <div style="font-weight:600">{{ number_format($subtotal) }}₫</div>
                </div>
                <input type="hidden" name="product_id[{{ $product->id }}]" value="{{$qty  }}">
            @endforeach

            <div class="summary-row">
                <span>Tạm tính</span>
                <strong>{{ number_format($total_amount) }}₫</strong>
            </div>
            <div class="summary-row">
                <span>Phí vận chuyển</span>
                <strong>Miễn phí</strong>
            </div>
            <div class="summary-row">
                <span>Thành tiền</span>
                <strong>{{ number_format($total_amount) }}₫</strong>
            </div>

            <button type="submit" class="btn" style="width:100%; margin-top:12px">Đặt hàng</button>
        </aside>
    </form>
</main>
<footer>
    <script src="{{asset('frontend/asset/js/frontend-optimized.js')}}"></script>
</footer>
</body>
</html>
