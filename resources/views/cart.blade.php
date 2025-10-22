<!DOCTYPE html>
<html lang="vi">
<head>
   @include('parts.header')
</head>
<body>
    <header>
       @include('parts.menu')
         @if(session('success'))
            <div class="toast" id="toastSuccess">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif
        @if(session('message'))
            <div class="toast1" id="toastSuccess">
                <i class="fa-solid fa-xmark"></i>
                {{ session('message') }}
            </div>
    @endif
    </header>
    <main class="cart-page">
        <form action="/cart/showcheck" method="POST">
            <div class="container cart-container">
            <section class="cart-items">
                <table id="cartTable" class="cart-list">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Giá Giảm</th>
                            <th>Số lượng</th>
                            <th>Tạm tính</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($products) && count($products) > 0)

                            @foreach($products as $product)
                                @php
                                    $qty = $cart[$product->id] ?? 0;
                                    $subtotal = $product->price_sale * $qty;
                                @endphp
                                <tr>
                                    <td>
                                        <img src="{{ asset($product->image) }}" alt="" style="width:80px">
                                        <p>{{ $product->name }}</p>
                                    </td>
                                    <td>{{ number_format($product->price_normal) }}₫</td>
                                    <td>{{ number_format($product->price_sale) }}₫</td>
                                    <td>{{ $qty }}</td>
                                    <td>{{ number_format($subtotal) }}₫</td>
                                    <td><a href="/cart/remove/{{ $product->id }}">X</a></td>
                                </tr>
                                <input type="hidden" name="product_id[]" value="{{ $product->id }}">
                                <input type="hidden" name="qty[]" value="{{ $qty }}">
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </section>
            <aside class="cart-summary">
                <h3>Tóm tắt đơn hàng</h3>
                @php
                    $total_qty = 0;
                    $total_amount = 0;
                    if(isset($products) && isset($cart)) {
                        foreach($products as $product) {
                            $qty = $cart[$product->id] ?? 0;
                            $total_qty += $qty;
                            $total_amount += $product->price_sale * $qty;
                        }
                    }
                @endphp
                <div class="summary-row">
                    <span>Số lượng</span>
                    <strong>{{ $total_qty }}</strong>
                </div>
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
                <div class="cart-actions">
                    <button type="submit" class="btn">Thanh toán</button>
                </div>
            </aside>
        </div>
        @csrf
        </form>   
    </main>
<footer>
    <script src="{{asset('frontend/asset/js/frontend-optimized.js')}}"></script>
</footer>
<script>
    setTimeout(() => {
        const toast = document.getElementById('toastSuccess');
        if (toast) {
            toast.remove();
        }
    }, 3500);
</script>

    </body>
</html>
