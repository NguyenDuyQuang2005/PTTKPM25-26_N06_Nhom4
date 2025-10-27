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
                    <td>
                        @if($order->completed_at)
                            <span class="confirm-oder" style="background-color: #10b981;">Đã Hoàn Thành</span>
                        @elseif($order->confirmed_at)
                            <span class="confirm-oder" style="background-color: #3b82f6;">Đã Xác Nhận</span>
                        @else
                            <span class="nonconfirm-oder">Chưa Xác Nhận</span>
                        @endif
                    </td>
                    <td>
                        @if($order->confirmed_at && !$order->completed_at)
                            <a onclick="completeOrder({{ $order->id }})" class="confirm-oder" style="cursor: pointer; background-color: #10b981;">Hoàn Thành</a>
                        @endif
                        <a onclick="removeRow({{ $order->id }}, '{{ url('/admin/order/delete/'.$order->id) }}')" class="delete-class" href="#">Xóa</a>
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
    if(confirm('Bạn có chắc muốn xóa đơn hàng này?')){

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

function completeOrder(id){
    if(confirm('Bạn có chắc muốn hoàn thành đơn hàng này?')){
        $.ajax({
            url: '/admin/order/complete/' + id,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'JSON',
            success: function(res){
                if(res.success){
                    alert('Đơn hàng đã được hoàn thành! Revenue sẽ được cập nhật trên Dashboard.');
                    location.reload();
                } else {
                    alert(res.message);
                }
            },
            error: function(){
                alert('Có lỗi xảy ra khi hoàn thành đơn hàng!');
            }
        })
    }
}

</script>
@endsection