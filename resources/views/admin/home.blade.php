<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.part.header')
</head>
<body>
    <section class="admin">
      <div class="row-grid">
        <div class="admin-sidebar">
                   @include('admin.part.slide')
            </div>
            <div class="admin-content">
                <div class="admin-content-top">
                    @include('admin.part.maincontenttop')
                </div>
                 <div class="admin-content-main">
                        <div class="admin-content-main-title">
                            <h1>Dashboard</h1>    
                        </div>
                        <div class="admin-content-main-content">
                            <!-- Thống kê tổng quan -->
                            <div class="dashboard-stats">
                                <div class="stat-card">
                                    <div class="stat-icon" style="background-color: #3b82f6;">
                                        <i class="ri-shopping-bag-line"></i>
                                    </div>
                                    <div class="stat-content">
                                        <h3 class="stat-value">{{ $totalProducts }}</h3>
                                        <p class="stat-label">Tổng Sản Phẩm</p>
                                    </div>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-icon" style="background-color: #10b981;">
                                        <i class="ri-file-list-line"></i>
                                    </div>
                                    <div class="stat-content">
                                        <h3 class="stat-value">{{ $totalOrders }}</h3>
                                        <p class="stat-label">Tổng Đơn Hàng</p>
                                    </div>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-icon" style="background-color: #f59e0b;">
                                        <i class="ri-user-line"></i>
                                    </div>
                                    <div class="stat-content">
                                        <h3 class="stat-value">{{ $totalUsers }}</h3>
                                        <p class="stat-label">Tổng Người Dùng</p>
                                    </div>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-icon" style="background-color: #8b5cf6;">
                                        <i class="ri-chat-3-line"></i>
                                    </div>
                                    <div class="stat-content">
                                        <h3 class="stat-value">{{ $totalComments }}</h3>
                                        <p class="stat-label">Tổng Bình Luận</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Thống kê đơn hàng -->
                            <div class="dashboard-charts">
                                <div class="chart-card">
                                    <div class="chart-header">
                                        <h3><i class="ri-pie-chart-line"></i> Trạng Thái Đơn Hàng</h3>
                                    </div>
                                    <div class="chart-content">
                                        <div class="status-item">
                                            <div class="status-bar" style="background-color: #f59e0b;">
                                                <span class="status-label">Chưa Xác Nhận Email</span>
                                                <span class="status-value">{{ $pendingConfirmationOrders }}</span>
                                            </div>
                                        </div>
                                        <div class="status-item">
                                            <div class="status-bar" style="background-color: #3b82f6;">
                                                <span class="status-label">Đã Xác Nhận</span>
                                                <span class="status-value">{{ $confirmedOrders }}</span>
                                            </div>
                                        </div>
                                        <div class="status-item">
                                            <div class="status-bar" style="background-color: #10b981;">
                                                <span class="status-label">Đã Hoàn Thành</span>
                                                <span class="status-value">{{ $completedOrders }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="chart-card">
                                    <div class="chart-header">
                                        <h3><i class="ri-money-dollar-circle-line"></i> Doanh Thu</h3>
                                    </div>
                                    <div class="revenue-content">
                                        <h2 class="revenue-amount">{{ number_format($revenue, 0, ',', '.') }} đ</h2>
                                        <p class="revenue-label">Tổng doanh thu từ các đơn đã hoàn thành ({{ $completedOrders }} đơn)</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Đơn hàng gần đây và Sản phẩm mới -->
                            <div class="dashboard-tables">
                                <div class="table-card">
                                    <div class="table-header">
                                        <h3><i class="ri-time-line"></i> Đơn Hàng Gần Đây</h3>
                                        <a href="/admin/order/list" class="view-all">Xem tất cả</a>
                                    </div>
                                    <div class="table-content">
                                        @if(count($recentOrders) > 0)
                                            <table class="data-table">
                                                <thead>
                                                    <tr>
                                                        <th>Mã Đơn</th>
                                                        <th>Tên Khách Hàng</th>
                                                        <th>Điện Thoại</th>
                                                        <th>Trạng Thái</th>
                                                        <th>Ngày Tạo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($recentOrders as $order)
                                                    <tr>
                                                        <td>#{{ $order->id }}</td>
                                                        <td>{{ $order->name }}</td>
                                                        <td>{{ $order->phone }}</td>
                                                        <td>
                                                            @if($order->completed_at)
                                                                <span class="status-badge completed">Đã Hoàn Thành</span>
                                                            @elseif($order->confirmed_at)
                                                                <span class="status-badge confirmed">Đã Xác Nhận</span>
                                                            @else
                                                                <span class="status-badge pending">Chưa Xác Nhận</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p style="padding: 20px; text-align: center;">Chưa có đơn hàng nào</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="table-card">
                                    <div class="table-header">
                                        <h3><i class="ri-product-hunt-line"></i> Sản Phẩm Mới Nhất</h3>
                                        <a href="/admin/product/list" class="view-all">Xem tất cả</a>
                                    </div>
                                    <div class="table-content">
                                        @if(count($latestProducts) > 0)
                                            <table class="data-table">
                                                <thead>
                                                    <tr>
                                                        <th>Tên Sản Phẩm</th>
                                                        <th>Mã Sản Phẩm</th>
                                                        <th>Giá Bán</th>
                                                        <th>Giá Khuyến Mãi</th>
                                                        <th>Ngày Thêm</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($latestProducts as $product)
                                                    <tr>
                                                        <td>{{ $product->name }}</td>
                                                        <td>{{ $product->masanpham }}</td>
                                                        <td>{{ number_format($product->price_normal, 0, ',', '.') }} đ</td>
                                                        <td>{{ number_format($product->price_sale, 0, ',', '.') }} đ</td>
                                                        <td>{{ $product->created_at->format('d/m/Y') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p style="padding: 20px; text-align: center;">Chưa có sản phẩm nào</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
       </div>
    </section>
    <footer>
        @include('admin.part.footer')
    </footer>
</body>
</html>