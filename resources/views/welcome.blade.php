<!DOCTYPE html>
<html lang="vi">
<head>
 @include('parts.header')
</head>
<body>
    <header>
       @include('parts.menu')
    </header>
<!------------------------slide--------------------------------------------------------------------->
    <section id="slider">
        <div class="aspect-ratio-169">
            <img src="{{asset('frontend/asset/images/slider_item_5_image.jpg')}}">
            <img src="{{asset('frontend/asset/images/slider_item_2_image.jpg')}}">
            <img src="{{asset('frontend/asset/images/slider_item_1_image.jpg')}}">
            <img src="{{asset('frontend/asset/images/slider_item_4_image.jpg')}}">
            <img src="{{asset('frontend/asset/images/slider_item_5_image.jpg')}}">
        </div>
        <div class="dot-container">
            <div class="dot active"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </section>
    
    <!---------------------Hero Section----------------------------->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1>Chào mừng đến với QuangQuoc Book</h1>
                <p>Khám phá thế giới tri thức với hàng nghìn đầu sách chất lượng cao. Từ văn học kinh điển đến những tác phẩm mới nhất, chúng tôi mang đến cho bạn trải nghiệm đọc sách tuyệt vời nhất.</p>
                <div class="hero-stats">
                    <div class="stat-item">
                        <h3>10,000+</h3>
                        <p>Đầu sách</p>
                    </div>
                    <div class="stat-item">
                        <h3>50,000+</h3>
                        <p>Khách hàng</p>
                    </div>
                    <div class="stat-item">
                        <h3>99%</h3>
                        <p>Hài lòng</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!---------------------Featured Products----------------------------->
    <section class="featured-products">
        <div class="container">
            <h2 class="section-title">Sản Phẩm Nổi Bật</h2>
            <div class="products-grid">
               @foreach($products as $product)
                <div class="product-item" data-product-id="book1" data-price="150000">
                    <a href="/product/{{$product ->id}}"><img src="{{asset($product ->image)}}" alt="Tấm Cám - Truyện Cổ Tích"><a>
                    <h3><a href="/product/{{$product ->id}}">{{$product ->name}}</a></h3>
                    <p style="font-size: 12px">MSP: {{$product ->masanpham}}</p>
                    <div class="price">
                        <p><span class="new-price">{{$product ->price_sale}}<sup>đ</sup></span> <span class="old-price">{{$product ->price_normal}}<sup>đ</sup></span></p>
                    </div>
                    <div class="product-actionss">
                       <a href="/product/{{$product ->id}}"> <button class="btn btn-primary btn-view-detail">Xem chi tiết</button></a>
                        <form action="/cart/add" method="post" style="display:inline-block">
                            @csrf
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            <input type="hidden" name="product_qty" value="1">
                            <button type="submit" class="btn btn-secondary">Thêm Vào Giỏ</button>
                        </form>
                    </div>
                </div>
               @endforeach
            </div>
            <div class="text-center" style="margin-top: 30px;">
                <!--<a href="/products" class="btn btn-primary">Xem Tất Cả Sản Phẩm</a>-->
            </div>
        </div>
    </section>

    <!---------------------Categories----------------------------->
    <section class="categories">
        <div class="container">
            <h2 class="section-title">Danh Mục Sách</h2>
            <div class="categories-grid">
                <div class="category-item">
                    <img src="{{asset('frontend/asset/images/sách1.png')}}" alt="Sách Văn Học">
                    <h3>Sách Văn Học</h3>
                    <p>Thơ ca, tiểu thuyết, truyện dài...</p>
                </div>
                <div class="category-item">
                    <img src="{{asset('frontend/asset/images/sách2.png')}}" alt="Sách Kinh Tế">
                    <h3>Sách Kinh Tế</h3>
                    <p>Marketing, quản trị kinh doanh...</p>
                </div>
                <div class="category-item">
                    <img src="{{asset('frontend/asset/images/sách3.jpg')}}" alt="Sách Thiếu Nhi">
                    <h3>Sách Thiếu Nhi</h3>
                    <p>Truyện cổ tích, truyện tranh...</p>
                </div>
                <div class="category-item">
                    <img src="{{asset('frontend/asset/images/sách4.png')}}" alt="Sách Phát Triển Bản Thân">
                    <h3>Phát Triển Bản Thân</h3>
                    <p>Tâm lý, kỹ năng sống...</p>
                </div>
            </div>
        </div>
    </section>

    <!---------------------footer----------------------------->
  @include('parts.footer')
</body>
</html>