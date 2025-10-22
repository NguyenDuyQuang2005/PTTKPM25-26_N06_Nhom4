@extends('admin.main')
@section('content')
 <div class="admin-content-main-content-product-list">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Anh</th>
                                            <th>Ten</th>
                                            <th>Gia</th>
                                            <th>So Luong</th>
                                            <th>Thanh Tien</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td><img style="width:80px; height: 100px;" src="../BACKEND/asset/img/9_ac9ea7c51f474f3f9e52fccc0dfe936d_large.png"></td>
                                            <td>Ngo Sy Nguyen</td>
                                            <td>56000đ</td>
                                            <td>3</td>
                                            <td>168000đ</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: 700;" colspan="5">Tong cong</td>
                                            <td style="font-weight: 700;">168000đ</td>
                                        </tr>
                                    </tbody>
                                </table>
                             </div>
@endsection