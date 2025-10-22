 <div class="admin-sidebar-top">
     <a href="/admin"><img src="{{asset('backend/asset/img/logo.png')}}" alt="logo"></a>
</div>
<div class="admin-sidebar-content">
                    <ul>
                        <li><a href="/admin"><i class="ri-dashboard-line"></i>Dashboard</a></li>
                        </li>
                        @if(auth()->check() && auth()->user()->role === 'admin')
                        <li><a href=""><i class="ri-file-list-line"></i>Đơn Hàng</a>
                            <ul class="sub-menu">
                                <li>
                                    <div class="sub-menu-items">
                                            <a href="/admin/order/list"><i class="ri-arrow-right-s-line"></i>Danh Sách</a>   
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li><a href=""><i class="ri-file-list-2-line"></i>Sản Phẩm</a>
                            <ul class="sub-menu">
                                <div class="sub-menu-items">
                                    <li>
                                        <a href="/admin/product/list"><i class="ri-arrow-right-s-line"></i>Danh Sách</a>   
                                    </li>
                                    <li>
                                        <a href="/admin/product/create"><i class="ri-arrow-right-s-line"></i>Thêm Sản Phẩm</a>
                                    </li>
                                </div>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </div>
                