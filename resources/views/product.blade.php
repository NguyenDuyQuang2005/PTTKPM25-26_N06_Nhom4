<!DOCTYPE html>
<html lang="vi">
<head>
 @include('parts.header')
</head>
<body>
    <header>
       @include('parts.menu')
    </header>
    <!----------------------------------body--------------------------------------------------------------------->
    <section class="product">
        <form action="/cart/add" method="POST">
            <div class="container">
            <div class="product-top raw">
                <a href="/" title="reload">Trang Chủ</a><span>&#8594;</span>    
                <p>{{$product->name}}</p>
            </div>
            <div class="product-content raw">
                <div class="product-content-left raw">
                   <div class="product-content-left-big-img">
                    <img src="{{$product -> image}}" alt="Tấm Cám"> 
                   </div>
                   <div class="product-content-left-small-img">
                    @php
                        $product_images = explode('*',$product->images)
                    @endphp
                    @foreach($product_images as $product_image)
                        <img src="{{$product_image}}" alt="Tấm Cám">
                    @endforeach
                   </div>
                </div>
            <div class="product-content-right">
                    <h1 class="product-title" id="productTitle">{{$product->name}}</h1>
                    <p class="product-code"><strong style="color:black;">Mã sản phẩm:</strong> <span id="productCode">{{$product->masanpham}}</span></p>
                    <div>
                        <ul class="product-info" style="white-space: pre-line;background-color: #f3f4f6;width:50%;margin-top:-10px;padding:0 0 10px 10px; ">
                            {{$product->description}}   
                        </ul>
                    </div>
                <div class="product-quantity">
                    <label for="quantity"><strong>Số lượng:</strong></label>
                    <input type="number" name="product_qty"  min="1" value="1">
                    <input type="hidden" value="{{ $product ->id }}" name="product_id" >
                </div>
               <div class="product-price">
                        <p><span class="new-price">{{$product ->price_sale}}<sup>đ</sup></span> <span class="old-price">{{$product ->price_normal}}<sup>đ</sup></span></p>
                    </div>
                <div class="product-buttons">

                    <button type="submit" class="btn btn-add-cart">Thêm Vào Giỏ Hàng</button>
                </div>
                <div>
                    @include('parts.productform')
                </div>
                </div>
             </div>
            </div>
        </div>
        @csrf
        </form>    
    </section>

    <!---------------------------------Product Description & Reviews Section------------------------------------->
    <section class="product-tabs">
       @include('parts.comment')
    </section>
    <!---------------------------------footer-------------------------------------------------------------------->
      @include('parts.footer')
      
      <script>
        document.addEventListener('DOMContentLoaded', function() {
            try {
                const productData = JSON.parse(sessionStorage.getItem('selectedProduct'));
                if (productData) {
                    const titleElement = document.getElementById('productTitle');
                    if (titleElement) {
                        titleElement.textContent = productData.name;
                    }
                    const codeElement = document.getElementById('productCode');
                    if (codeElement) {
                        codeElement.textContent = productData.id;
                    }
                    const priceElement = document.getElementById('productPrice');
                    if (priceElement) {
                        priceElement.textContent = new Intl.NumberFormat('vi-VN').format(productData.price) + '₫';
                    }
                    const breadcrumbElement = document.querySelector('.product-top p');
                    if (breadcrumbElement) {
                        breadcrumbElement.textContent = productData.name;
                    }
                }
            } catch (error) {
                console.error('Error loading product data:', error);
            }
        });
      </script>
</body>
</html>