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
                                    $qty = $cart[$product->id] ?? 1;
                                    $subtotal = $product->price_sale * $qty;
                                @endphp
                                <tr data-id="{{ $product->id }}">
                                    <td>
                                        <img src="{{ asset($product->image) }}" alt="" style="width:80px">
                                        <p>{{ $product->name }}</p>
                                    </td>
                                    <td>{{ number_format($product->price_normal) }}₫</td>
                                    <td>{{ number_format($product->price_sale) }}₫</td>
                                    <td>
                                        <div class="qty-control">
                                           <button type="button" class="qty-decrease" data-id="{{ $product->id }}" style="padding:2px;">−</button> 
                                            <input type="number" class="qty-input" data-id="{{ $product->id }}" value="{{ $qty }}" min="1">
                                            <button type="button" class="qty-increase" data-id="{{ $product->id }}" style="padding:2px;">+</button>
                                        </div>
                                    </td>
                                    <td class="subtotal">{{ number_format($subtotal) }}₫</td>
                                    <td><a href="/cart/remove/{{ $product->id }}">X</a></td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>

                </table>
            </section>
            <aside class="cart-summary">
                <h3>Tóm tắt đơn hàng</h3>

                <div class="summary-row">
                    <span>Số lượng</span>
                    <strong id="cartQuantity">{{ $total_qty }}</strong>
                </div>
                <div class="summary-row">
                    <span>Tạm tính</span>
                    <strong id="cartSubtotal">{{ number_format($total_amount) }}₫</strong>
                </div>
                <div class="summary-row">
                    <span>Phí vận chuyển</span>
                    <strong>Miễn phí</strong>
                </div>
                <div class="summary-row">
                    <span>Thành tiền</span>
                    <strong id="cartTotal">{{ number_format($total_amount) }}₫</strong>
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
<script>
document.addEventListener('DOMContentLoaded', () => {
    const csrf = '{{ csrf_token() }}';

    document.querySelectorAll('.qty-decrease').forEach(btn => {
        btn.addEventListener('click', () => changeQty(btn, -1));
    });
    document.querySelectorAll('.qty-increase').forEach(btn => {
        btn.addEventListener('click', () => changeQty(btn, 1));
    });
    document.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('change', () => updateCart(input.dataset.id, input.value));
    });

    function changeQty(btn, delta) {
        const input = btn.parentElement.querySelector('.qty-input');
        let value = parseInt(input.value) + delta;
        if (value < 1) value = 1;
        input.value = value;
        updateCart(input.dataset.id, value);
    }

    function updateCart(productId, qty) {
        fetch('{{ route("cart.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify({ product_id: productId, qty: qty })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Cập nhật subtotal của từng sản phẩm
                const row = document.querySelector(`tr[data-id="${productId}"]`);
                const priceSale = parseInt(
                    row.querySelector('td:nth-child(3)').innerText.replace(/[^\d]/g, '')
                );
                const newSubtotal = priceSale * qty;
                row.querySelector('.subtotal').innerText = newSubtotal.toLocaleString() + '₫';

                // 🧮 Cập nhật phần tóm tắt
                document.getElementById('cartQuantity').innerText = data.total_qty;
                document.getElementById('cartSubtotal').innerText = data.subtotal + '₫';
                document.getElementById('cartTotal').innerText = data.total + '₫';

                showToast('Đã cập nhật giỏ hàng');
            }
        });
    }

    // Hiển thị thông báo nhỏ
    function showToast(message) {
        let toast = document.createElement('div');
        toast.className = 'toast toast-success';
        toast.innerHTML = `<i class="fa-solid fa-circle-check"></i> ${message}`;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 2500);
    }
});
</script>


    </body>
</html>
