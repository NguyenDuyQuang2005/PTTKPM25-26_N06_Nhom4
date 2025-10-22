@extends('admin.main')
@section('content')
 <div class="admin-content-main-content-product-list">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Ảnh</th>
                <th>Tên</th>
                <th>Giá</th>
                <th>Số Lượng</th>
                <th>Thành Tiền</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total=0;
            @endphp
            @foreach($products as $product)
            @php
                $price = $product-> price_sale * $chitiet[$product->id];
                $total+=$price;
            @endphp
                 <tr>
                    <td>{{$product->id}}</td>
                    <td><img style="width:80px; height: 100px;" src="{{asset($product->image)}}"></td>
                    <td>{{$product->name}}</td>
                    <td>{{number_format($product->price_sale)}}</td>
                    <td>{{$chitiet[$product->id]}}</td>
                    <td>{{number_format($price)}}</td>
                </tr>
            @endforeach
             <tr>
                    <td style="font-weight: 700;" colspan="5">Tổng cộng</td>
                    <td style="font-weight: 700;">{{number_format($total)}}</td>
                </tr>
        </tbody>
    </table>
    </div>
    @endsection