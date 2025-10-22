 <div class="logo">
            <img style="width:200px;"src="{{asset('frontend/asset/images/logo.png')}}" alt="Logo">
        </div>
        <button class="mobile-menu-toggle" id="mobileMenuToggle">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <div class="menu" id="menu">
            <ul>
                <li class="menu-dropdown">
                    <a href="#">
                        <i class="fas fa-list"></i>
                        <span>Danh Mục Sách</span>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="/category?category=van-hoc">Sách Văn Học</a></li>
                        <li><a href="/category?category=kinh-te">Sách Kinh Tế</a></li>
                        <li><a href="/category?category=thieu-nhi">Sách Thiếu Nhi</a></li>
                        <li><a href="/category?category=phat-trien">Sách Phát Triển Bản Thân</a></li>
                        <li><a href="/category?category=chuyen-nganh">Sách Chuyên Ngành</a></li>
                    </ul>
                </li>
                <li><a href="/products" class="menu-main-link">
                    <i class="fas fa-book"></i>
                    <span>Tất Cả Sách</span>
                </a></li>
                <li><a href="/category" class="menu-main-link">
                    <i class="fas fa-star"></i>
                    <span>Sách Mới</span>
                </a></li>
                <li><a class="favorites-link">
                    <i class="fas fa-car"></i>
                    <span>Ship COD Trên Toàn Quốc </span>
                </a></li>
                <li><a  class="menu-dropdown">
                    <i class="fas fa-phone"></i>
                    <span>1900 6278</span>
                </a></li>
            </ul>
        </div>
        <div class="others">
            <ul>
                <li>
                    <input placeholder="Tìm kiếm sách...">
                    <a class="fas fa-search" href="#" title="Tìm kiếm"></a>
                </li>
                <li><a class="fa-solid fa-house" href="/" title="Trang chủ"></a></li>
                <li><a class="fa-solid fa-user" href="/login" title="Tài khoản"></a></li>
                 <li class="cart-icon">
                   <a href="/cart" class="fa-solid fa-cart-shopping" title="Giỏ hàng">
                   </a>
                </li>
            </ul>
        </div>