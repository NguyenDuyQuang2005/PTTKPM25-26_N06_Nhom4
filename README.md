# 📚 Bán Sách Online

Ứng dụng web bán sách online được xây dựng bằng Laravel Framework với giao diện hiện đại sử dụng Tailwind CSS và Alpine.js.

## ✨ Tính năng chính

### 👤 Cho người dùng:
- 🏠 **Trang chủ**: Hiển thị danh sách sản phẩm với phân trang
- 📖 **Chi tiết sản phẩm**: Xem thông tin chi tiết sản phẩm
- 🛒 **Giỏ hàng**: Thêm/xóa sản phẩm khỏi giỏ hàng
- 💳 **Thanh toán**: Đặt hàng và nhận email xác nhận
- ⭐ **Đánh giá**: Bình luận và đánh giá sản phẩm (1-5 sao)
- 🔐 **Xác thực**: Đăng ký, đăng nhập, quản lý profile

### 👨‍💼 Cho quản trị viên:
- 📦 **Quản lý sản phẩm**: Thêm, sửa, xóa sản phẩm (AJAX)
- 📋 **Quản lý đơn hàng**: Xem danh sách và chi tiết đơn hàng (AJAX)
- 🖼️ **Upload hình ảnh**: Upload đơn/multiple files với AJAX
- 📊 **Dashboard**: Trang quản trị tổng quan
- ⚡ **AJAX Operations**: Xóa sản phẩm/đơn hàng không reload trang

## 🛠️ Công nghệ sử dụng

### Backend:
- **Laravel 12.x** - PHP Framework
- **PHP 8.2+** - Ngôn ngữ lập trình
- **MySQL/SQLite** - Cơ sở dữ liệu

### Frontend:
- **Tailwind CSS 3.x** - Framework CSS
- **Alpine.js** - JavaScript framework nhẹ
- **jQuery** - JavaScript library cho AJAX
- **Axios** - HTTP client cho AJAX requests
- **Vite** - Build tool hiện đại
- **Blade Templates** - Template engine của Laravel

### Khác:
- **Laravel Breeze** - Authentication scaffolding
- **Laravel Mail** - Gửi email
- **Session** - Quản lý giỏ hàng

## 📋 Yêu cầu hệ thống

- **PHP** >= 8.2
- **Composer** (Package manager cho PHP)
- **Node.js** >= 16.x & **NPM**
- **MySQL** >= 5.7 hoặc **SQLite**
- **Web server** (Apache/Nginx) hoặc sử dụng `php artisan serve`

## 🚀 Hướng dẫn cài đặt chi tiết

### Bước 1: Chuẩn bị môi trường

#### Cài đặt PHP 8.2+
```bash
# Windows (sử dụng XAMPP)
# Tải và cài đặt XAMPP từ: https://www.apachefriends.org/

# Ubuntu/Debian
sudo apt update
sudo apt install php8.2 php8.2-cli php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip

# macOS (sử dụng Homebrew)
brew install php@8.2
```

#### Cài đặt Composer
```bash
# Windows
# Tải từ: https://getcomposer.org/download/

# Ubuntu/Debian
sudo apt install composer

# macOS
brew install composer
```

#### Cài đặt Node.js và NPM
```bash
# Windows/macOS
# Tải từ: https://nodejs.org/

# Ubuntu/Debian
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs
```

### Bước 2: Clone và cài đặt dự án

```bash
# Clone repository
git clone <repository-url>
cd bansachonline

# Cài đặt PHP dependencies
composer install

# Cài đặt Node.js dependencies
npm install
```

### Bước 3: Cấu hình môi trường

```bash
# Copy file cấu hình
cp .env.example .env

# Tạo application key
php artisan key:generate
```

### Bước 4: Cấu hình Database

#### Sử dụng MySQL:
1. Tạo database:
```sql
CREATE DATABASE bansachonline CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Chỉnh sửa file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bansachonline
DB_USERNAME=root
DB_PASSWORD=
```

#### Sử dụng SQLite (đơn giản hơn):
1. Chỉnh sửa file `.env`:
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

2. Tạo file database:
```bash
touch database/database.sqlite
```

### Bước 5: Chạy Migrations

```bash
# Chạy migrations để tạo bảng
php artisan migrate
```

### Bước 6: Build Assets

```bash
# Build assets cho production
npm run build

# Hoặc chạy development server với hot reload
npm run dev
```

### Bước 7: Chạy ứng dụng

#### Cách 1: Sử dụng Laravel Development Server
```bash
php artisan serve
```
Truy cập: `http://localhost:8000`

#### Cách 2: Sử dụng script có sẵn (khuyến nghị)
```bash
composer run dev
```
Script này sẽ chạy:
- Laravel server
- Queue worker
- Log viewer
- Vite dev server

#### Cách 3: Sử dụng XAMPP/WAMP
1. Copy thư mục dự án vào `htdocs` (XAMPP) hoặc `www` (WAMP)
2. Truy cập: `http://localhost/bansachonline/public`

### Bước 8: Tạo tài khoản Admin

```bash
# Tạo user đầu tiên
php artisan tinker

# Trong tinker console:
$user = new App\Models\User();
$user->name = 'Admin';
$user->email = 'admin@example.com';
$user->password = bcrypt('password');
$user->role = 'admin';
$user->email_verified_at = now();
$user->save();
exit
```

## 🔧 Cấu hình Email (Tùy chọn)

Để gửi email xác nhận đơn hàng, cấu hình trong `.env`:

```env
# Sử dụng Gmail
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

## 🧪 Kiểm tra cài đặt

```bash
# Kiểm tra cấu hình Laravel
php artisan about

# Chạy tests
composer run test

# Kiểm tra routes
php artisan route:list
```

## 📁 Cấu trúc dự án

```
bansachonline/
├── app/
│   ├── Http/Controllers/
│   │   ├── admin/          # Controllers cho admin
│   │   │   ├── orderController.php
│   │   │   ├── productController.php
│   │   │   └── UploadController.php
│   │   ├── Auth/           # Authentication controllers
│   │   ├── FrontendController.php
│   │   ├── CommentController.php
│   │   └── ProfileController.php
│   ├── Models/
│   │   ├── product.php     # Model sản phẩm
│   │   ├── order.php       # Model đơn hàng
│   │   ├── comment.php     # Model bình luận
│   │   └── User.php        # Model người dùng
│   ├── Mail/
│   │   └── TestMail.php    # Email xác nhận đơn hàng
│   └── Providers/
│       └── AppServiceProvider.php
├── resources/
│   ├── views/
│   │   ├── admin/          # Views cho admin
│   │   ├── auth/           # Views authentication
│   │   ├── components/     # Blade components
│   │   ├── layouts/        # Layout templates
│   │   ├── parts/          # Partial views
│   │   └── profile/        # Profile views
│   ├── css/
│   │   └── app.css
│   └── js/
│       ├── app.js
│       └── bootstrap.js
├── routes/
│   ├── web.php             # Routes chính
│   ├── admin.php           # Routes admin
│   └── auth.php            # Routes authentication
├── database/
│   └── migrations/         # Database migrations
├── public/                 # Public assets
├── storage/                # Storage files
├── vendor/                 # Composer dependencies
├── node_modules/           # NPM dependencies
├── composer.json           # PHP dependencies
├── package.json            # Node.js dependencies
├── tailwind.config.js      # Tailwind configuration
├── vite.config.js          # Vite configuration
└── artisan                 # Laravel command line tool
```

## 🗄️ Cơ sở dữ liệu

### Bảng chính:

#### 📊 users
- `id` - Primary key
- `name` - Tên người dùng
- `email` - Email (unique)
- `password` - Mật khẩu (hashed)
- `role` - Vai trò (user/admin)
- `email_verified_at` - Thời gian xác thực email
- `created_at`, `updated_at` - Timestamps

#### 📚 products
- `id` - Primary key
- `name` - Tên sản phẩm
- `masanpham` - Mã sản phẩm
- `price_normal` - Giá gốc
- `price_sale` - Giá khuyến mãi
- `description` - Mô tả ngắn
- `content` - Nội dung chi tiết
- `image` - Hình ảnh chính
- `images` - Hình ảnh phụ (nhiều ảnh)
- `created_at`, `updated_at` - Timestamps

#### 🛒 orders
- `id` - Primary key
- `name` - Tên khách hàng
- `phone` - Số điện thoại
- `email` - Email
- `address` - Địa chỉ giao hàng
- `chitiet` - Chi tiết đơn hàng (JSON)
- `trangthai` - Trạng thái đơn hàng (0: chờ xử lý)
- `token` - Token xác thực
- `created_at`, `updated_at` - Timestamps

#### 💬 comments
- `id` - Primary key
- `product_id` - Foreign key đến products
- `content` - Nội dung bình luận
- `rating` - Đánh giá (1-5 sao)
- `author_id` - Foreign key đến users (nullable)
- `created_at`, `updated_at` - Timestamps

### Quan hệ:
- `products` hasMany `comments`
- `users` hasMany `comments` (author)
- `comments` belongsTo `products`
- `comments` belongsTo `users` (author)

## 🔐 Phân quyền và Routes

### 👤 Guest (Không cần đăng nhập):
- `/` - Trang chủ
- `/product/{id}` - Chi tiết sản phẩm
- `/register` - Đăng ký
- `/login` - Đăng nhập

### 🔑 User (Cần đăng nhập):
- `/dashboard` - Dashboard cá nhân
- `/profile` - Quản lý profile
- `/cart` - Giỏ hàng
- `/cart/add` - Thêm vào giỏ hàng
- `/cart/remove/{id}` - Xóa khỏi giỏ hàng
- `/cart/showcheck` - Thanh toán
- `/cart/send` - Gửi đơn hàng
- `/comment/store` - Thêm bình luận
- `/comment/{id}` - Xóa bình luận

### 👨‍💼 Admin (Cần đăng nhập + role admin):
- `/admin` - Trang admin
- `/admin/home` - Dashboard admin
- `/admin/product/create` - Thêm sản phẩm
- `/admin/product/list` - Danh sách sản phẩm
- `/admin/product/edit/{id}` - Sửa sản phẩm
- `/admin/product/delete` - Xóa sản phẩm
- `/admin/order/list` - Danh sách đơn hàng
- `/admin/order/details/{chitiet}` - Chi tiết đơn hàng
- `/admin/order/delete/{id}` - Xóa đơn hàng
- `/upload` - Upload hình ảnh

## 📧 Tính năng Email

Ứng dụng tự động gửi email xác nhận khi khách hàng đặt hàng thành công thông qua `TestMail` class.

### Cấu hình email trong `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

## 🎨 Giao diện và UI

- **Responsive design** với Tailwind CSS
- **Modern UI components** với Alpine.js
- **Mobile-friendly** design
- **Dark/Light mode** support
- **Interactive elements** với JavaScript và AJAX

### Các trang chính:
- **Trang chủ**: Hiển thị sản phẩm với pagination
- **Chi tiết sản phẩm**: Thông tin đầy đủ + bình luận
- **Giỏ hàng**: Quản lý sản phẩm đã chọn
- **Thanh toán**: Form đặt hàng
- **Admin panel**: Quản lý sản phẩm và đơn hàng với AJAX

## ⚡ Tính năng AJAX

Dự án sử dụng AJAX để tăng trải nghiệm người dùng với các tính năng:

### 🔧 AJAX trong Admin Panel:

#### 1. **Xóa sản phẩm** (jQuery AJAX):
```javascript
$.ajax({
    url: url,
    data: { product_id },
    method: 'GET',
    dataType: 'json',
    success: function (res) {
        if (res.success) {
            alert('Xóa thành công!');
            location.reload();
        }
    }
});
```

#### 2. **Xóa đơn hàng** (jQuery AJAX):
```javascript
$.ajax({
    url: url,
    method: 'DELETE',
    data: {
        _token: $('meta[name="csrf-token"]').attr('content')
    },
    dataType: 'JSON',
    success: function(res){
        if(res.success){
            location.reload();
        }
    }
});
```

#### 3. **Upload hình ảnh** (jQuery AJAX):
- **Upload đơn file**: `/upload` endpoint
- **Upload multiple files**: `/uploads` endpoint
- Trả về JSON response với đường dẫn file

### 🛠️ Cấu hình AJAX:

#### Axios Setup (resources/js/bootstrap.js):
```javascript
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
```

#### jQuery Setup:
- jQuery 3.7.1 được load từ CDN
- CSRF token được cấu hình cho tất cả AJAX requests
- Font Awesome icons cho UI

### 📡 API Endpoints trả về JSON:

#### UploadController:
- `POST /upload` - Upload single image
- `POST /uploads` - Upload multiple images

#### ProductController:
- `GET /admin/product/delete` - Xóa sản phẩm

#### OrderController:
- `DELETE /admin/order/delete/{id}` - Xóa đơn hàng

### 🎯 Lợi ích của AJAX:
- **Không reload trang**: Thao tác mượt mà hơn
- **Tăng tốc độ**: Chỉ load dữ liệu cần thiết
- **UX tốt hơn**: Người dùng không bị gián đoạn
- **Tiết kiệm băng thông**: Chỉ gửi/nhận dữ liệu cần thiết

## 🧪 Testing và Debug

```bash
# Chạy tests
composer run test

# Kiểm tra cấu hình Laravel
php artisan about

# Kiểm tra routes
php artisan route:list

# Xem logs
php artisan pail

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## 📝 Scripts có sẵn

### Composer Scripts:
```bash
# Setup dự án hoàn chỉnh
composer run setup

# Chạy development với hot reload
composer run dev

# Chạy tests
composer run test
```

### NPM Scripts:
```bash
# Build assets cho production
npm run build

# Chạy development server
npm run dev
```

## 🚨 Troubleshooting

### Lỗi thường gặp:

#### 1. Lỗi "Class not found"
```bash
composer dump-autoload
```

#### 2. Lỗi permission storage
```bash
# Linux/macOS
chmod -R 775 storage bootstrap/cache

# Windows (XAMPP)
# Đảm bảo Apache có quyền đọc/ghi
```

#### 3. Lỗi database connection
- Kiểm tra cấu hình trong `.env`
- Đảm bảo database đã được tạo
- Kiểm tra MySQL service đang chạy

#### 4. Lỗi assets không load
```bash
npm run build
# hoặc
npm run dev
```

#### 5. Lỗi email không gửi được
- Kiểm tra cấu hình SMTP trong `.env`
- Sử dụng App Password cho Gmail
- Kiểm tra firewall/antivirus

## 🔧 Cấu hình nâng cao

### 1. Cấu hình Queue (Tùy chọn)
```bash
# Chạy queue worker
php artisan queue:work

# Hoặc sử dụng supervisor cho production
```

### 2. Cấu hình Cache
```bash
# Sử dụng Redis
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. Cấu hình Production
```bash
# Optimize cho production
composer install --optimize-autoloader --no-dev
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🤝 Đóng góp

1. Fork dự án
2. Tạo feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Mở Pull Request

## 📄 License

Dự án này được phân phối dưới MIT License. Xem file `LICENSE` để biết thêm chi tiết.

## 👥 Tác giả

- **Developer** - [Tên tác giả]

## 📞 Liên hệ

- Email: [email@example.com]
- Project Link: [https://github.com/username/bansachonline]

---

⭐ Nếu dự án này hữu ích, hãy cho một star!
