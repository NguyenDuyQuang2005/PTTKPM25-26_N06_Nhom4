@extends('admin.main')
@section('content')
<form action="/admin/product/edit/{{ $product->id }}" enctype="multipart/form-data" method="post">
     @csrf
    <div class="admin-content-main-content-product-add">
                                <div class="admin-content-main-content-left">
                                    <div class="admin-content-main-content-input-two">
                                        <input type="text" value="{{$product->name}}" name="name" placeholder="Tên Sản Phẩm">
                                        <input type="text" value="{{$product->masanpham}}" name="masanpham" placeholder="Mã Sản Phẩm">
                                    </div>
                                    <div class="admin-content-main-content-input-two">
                                        <input type="text" value="{{$product->price_normal}}" name="price_normal" placeholder="Giá giảm">
                                        <input type="text" value="{{$product->price_sale}}" name="price_sale" placeholder="Giá bán">
                                    </div>
                                    <laber for="">Thông tin sản phẩm <span style="color: red;  ">* </span></laber>
                                    <textarea required value="" name="description" id="" >{{$product->description}}</textarea>
                                    <laber for="">Mô tả sản phẩm <span style="color: red;  ">* </span></laber>
                                    <textarea required name="content">{{ $product->content }}</textarea>
                                    <button type="submit" class="main-btn">Cập Nhật Sản Phẩm</button>
                                </div>
                                <div class="admin-content-main-content-right">
                                    <div class="admin-content-main-content-right-img">
                                        <label for="file">Ảnh Sản Phẩm</label>
                                        <input id="file" type="file">
                                        <input type="hidden" value="{{$product->image}}" name="image" id="input-file-img-hidden">
                                        <div class="image-show" id="input-file-img">
                                            <img src="{{$product->image}}" alt="">
                                        </div>
                                    </div>
                                    <div class="admin-content-main-content-right-imgs">
                                        <label for="files">Ảnh Mô Tả</label>
                                        <input type="file" id="files" name="files[]" multiple accept="image/*">
                                        <input type="hidden" name="images[]" id="images-hidden">
                                        <div class="images-show" id="input-file-imgs">
                                            @php
                                                // Lấy chuỗi ảnh và lọc phần tử rỗng
                                                $image_string = $product->images;
                                                $raw_images = explode("*", $image_string);
                                                $product_images = array_filter($raw_images, function($value) {
                                                    return !empty(trim($value));
                                                });
                                            @endphp
                                            
                                            @foreach($product_images as $product_image)
                                                @php 
                                                    $image_url = trim($product_image); 
                                                    $display_url = asset($image_url); 
                                                    if (str_starts_with($image_url, 'http')) {
                                                        $display_url = $image_url;
                                                    }
                                                @endphp
                                                
                                                @if(!empty($image_url))
                                                    <div class="image-preview" style="display: inline-block; margin-right: 5px;">
                                                        <img src="{{ $display_url }}" alt="Ảnh mô tả" style="max-width: 100px; height: auto;">
                                                        
                                                        <input type="hidden" value="{{ $image_url }}" name="images[]">
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
 </div>
 @csrf
</form>                      
@endsection
{{-- up 1 anh san pham --}}
@section('scripts')
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$("#file").on('change',()=>{
    var formData = new FormData();
    var file = $("#file")[0].files[0]
    formData.append('file',file)
    $.ajax({
        url: '/upload',
        processData: false,
        dataType: 'json',
        data: formData,
        method: 'POST',
        contentType: false,
        success: function(result){
            if(result.success == true){
               let html = "";
                html += '<img src="'+result.path+'" alt="">';
                $('#input-file-img').html(html)
                $('#input-file-img-hidden').val(result.path)
            }
        }
    })
})
</script>
{{-- up nhieu anh mo ta san pham --}}
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$('#files').on('change', function() {
    let formData = new FormData();
    let files = $('#files')[0].files;

    for (let i = 0; i < files.length; i++) {
        formData.append('files[]', files[i]);
    }

    $.ajax({
        url: '/uploads',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(result) {
            if (result.success === true) {
                let html = '';
                // Hiển thị ảnh preview và thêm input hidden
                for (let i = 0; i < result.paths.length; i++) {
                    html += `
                        <div class="image-preview">
                            <img src="${result.paths[i]}" alt="Ảnh mô tả">
                            <input type="hidden" name="images[]" value="${result.paths[i]}">
                        </div>
                    `;
                }
                $('#input-file-imgs').html(html);
            } else {
                console.error('Upload thất bại:', result.message);
            }
        },
        error: function(xhr) {
            console.error("Lỗi upload nhiều ảnh:", xhr.responseText);
        }
    });
});
</script>

@endsection