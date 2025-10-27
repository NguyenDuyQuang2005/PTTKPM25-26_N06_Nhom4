 <div class="logo">
<img style="width:130px;"src="{{asset('frontend/asset/images/logo.png')}}" alt="Logo">
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
                <li><a class="favorites-link">
                    <i class="fas fa-truck"></i>
                    <span> Free Ship Trên Toàn Quốc </span>
                </a></li>
                <li><a class="favorites-link">
                    <i class="fa-solid fa-heart"></i>
                    <span>Uy Tín Làm Nên Thương Hiệu </span>
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
                    <input type="text" name="search" id="timkiem" placeholder="Tìm kiếm sách...">
                       <ul class="list_group" id="result" style="display:none;">
                </ul>
                    
                </li>
                <li><a class="fa-solid fa-house" href="/" title="Trang chủ"></a></li>
                <li><a class="fa-solid fa-user" href="/login" title="Tài khoản"></a></li>
                 <li class="cart-icon">
                   <a href="/cart" class="fa-solid fa-cart-shopping" title="Giỏ hàng">
                   </a>
                </li>
            </ul>
        </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
let timer;

$("#timkiem").on("keyup", function () {
    clearTimeout(timer);

    timer = setTimeout(function() {
        searchBook();
    }, 300);
});

function searchBook() {
    $("#result").html('');
    let search = $("#timkiem").val().trim();

    if (search === "") {
        $("#result").hide();
        return;
    }

    let expression = new RegExp(search, "i");

    $.getJSON('/json/book.json', function(data) {
        let found = false;

        $.each(data.data, function (key, value) {
            let nameMatch = value?.name?.search(expression) !== -1;
            let codeMatch = value?.masanpham?.toString().search(expression) !== -1;

            if (nameMatch || codeMatch) {
                found = true;
                $("#result").append(`
                    <li onclick="window.location='/product/${value.id}'">
                        <img src="${value.image}" width="40" height="40">
                        <div>
                            <div>${value.name}</div>
                            <small>${value.masanpham}</small>
                        </div>
                    </li>
                `);
            }
        });

        if (found) $("#result").show();
        else $("#result").hide();
    });
}

// Ẩn dropdown khi click ra ngoài
$(document).click(function(e){
    if(!$(e.target).closest('.others li').length){
        $('#result').hide();
    }
});

</script>
