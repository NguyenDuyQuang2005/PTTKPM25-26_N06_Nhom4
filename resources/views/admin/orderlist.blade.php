@extends('admin.main')
@section('content')
<div class="admin-content-main-content-product-list">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Ten</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Dia Chi</th>
                                            <th>Chi Tiet</th>
                                            <th>Ngay dat</th>
                                            <th>Trang thai</th>
                                            <th>Tuy bien</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Ngo Sy Ngyen</td>
                                            <td>07928237723</td>
                                            <td>a@gmail.com</td>
                                            <td>72, ha dong, ha noi</td>
                                            <td><a class="edit-class" href="/admin/orderdetails">Xem</a></td>
                                            <td>23-7-2023</td>
                                            <td><a class="confirm-oder" href=>Da Xac Nhan</a></td>
                                            <td><a class="delete-class" href>Xoa</a></td>
                                        </tr>
                                         <tr>
                                            <td>1</td>
                                            <td>Ngo Sy Ngyen</td>
                                            <td>07928237723</td>
                                            <td>a@gmail.com</td>
                                            <td>72, ha dong, ha noi</td>
                                            <td><a class="edit-class" href="/admin/orderdetails">Xem</a></td>
                                            <td>23-7-2023</td>
                                            <td><a class="nonconfirm-oder" href=>Chua Xac Nhan</a></td>
                                            <td><a class="delete-class" href>Xoa</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                             </div>
@endsection