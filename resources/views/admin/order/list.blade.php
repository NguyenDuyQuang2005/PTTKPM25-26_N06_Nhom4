@extends('admin.main')
@section('content')
<div class="admin-content-main-content-product-list">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Địa Chỉ</th>
                <th>Chi Tiết</th>
                <th>Ngày Đặt</th>
                <th>Trạng thái</th>
                <th>Tùy biến</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order )
                 <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->name}}</td>
                    <td>{{$order->phone}}</td>
                    <td>{{$order->email}}</td>
                    <td>{{$order->address}}</td>
                    <td>
                        <a class="edit-class" href="/admin/order/details/{{ $order->chitiet }}">Xem</a>
                    </td>
                    <td>{{$order->created_at}}</td>
                    <td><a class="confirm-oder" href=>Đã Xác Nhận</a></td>
                    <td>
                        <a onclick="removeRow({{ $order->id }}, '{{ url('admin/order/delete/'.$order->id) }}')"class="delete-class" href="#">Xóa</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
@endsection
@section('scripts')
<script>
function removeRow(id, url){
    if(confirm('Ok')){

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
        })
    }
}

</script>
@endsection