@extends('admin.main')

@section('content')
<div class="admin-content-main-content-product-list">
     @if(session('success'))
            <div class="toast" id="toastSuccess">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
    @endif
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Ảnh</th>
                <th>Tên Sản Phẩm</th>
                <th>Giá Bán</th>
                <th>Giá Giảm</th>
                <th>Ngày Đăng</th>
                <th>Tùy Chỉnh</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td><img style="width:70px;" src="{{ asset($item->image) }}" alt=""></td>
                <td>{{ $item->name }}</td>
               <td>{{ number_format((float)$item->price_normal) }}</td>
                <td>{{ number_format((float)$item->price_sale) }}</td>
                <td>{{ $item->created_at }}</td>
                <td>
                    @if(auth()->check() && auth()->user()->role === 'admin')
                    <a class="edit-class" href="/admin/product/edit/{{$item->id}}" href="">Sửa</a> |
                    <a onclick="removeRow({{ $item->id }}, '{{ url('admin/product/delete') }}')" class="delete-class" href="#">Xóa</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="margin-top: 20px; display: flex; justify-content: center;">
    {{ $products->links() }}
    </div>
</div>
@endsection

@section('footer')
<script>
    function removeRow(product_id, url) {
    if (confirm('Bạn có chắc muốn xóa sản phẩm này không?')) {
        $.ajax({
            url: url,
            data: { product_id },
            method: 'GET',
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    alert('Xóa thành công!');
                    location.reload();
                } else {
                    alert('Xóa thất bại!');
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('Có lỗi xảy ra khi xóa!');
            }
        });
    }
}
</script>
@endsection
