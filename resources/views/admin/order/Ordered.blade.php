@extends('adminlte::page')

@section('title', 'Quản lý đơn hàng')

@section('content_header')
    <h1>Đơn hàng chờ xác nhận</h1>
@stop

@section('content')
    <!-- Nội dung chính của trang quản trị -->
    <div class="card">
        
        <table class="table table-bordered">
            <thead>
            <tr>
                <th style="width: 5%">#</th>
                <th style="width: 25%">Người mua hàng</th>
                <th style="width: 25%">Mặt hàng</th>
                <th style="width: 26%">Mô tả</th>
                <th style="width: 13%">Thao tác</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($listOrdered as $order)
            <tr>
                <td>{{ $loop->index+1 }}</td>
                <td>
                <p>{{ $order->user->name }}</p>
                <p>({{ $order->user->email }})</p>
                </td>
                <td>{{ $order->product->name }}</td>
                <td>
                  <p>Id đơn hàng: {{ $order->id }}</p>
                  <p>Số lượng: {{ $order->quantity }}</p>
                  <p>Đơn giá: {{ $order->sale_price }}</p>
                  <p>SĐT: {{ $order->phone_order }}</p>
                  <p>Địa chỉ nhận hàng: {{ $order->address_order }}</p>
                  <p>Thời điểm đặt hàng: {{ $order->created_at }}</p>
                </td>
                <td >
                    <a href="{{ route('confirmOrder', [$order->id]) }}" class="btn btn-warning btn-sm" >Xác nhận</a>                    
                    <form action="{{ route('deleteOrder', [$order->id]) }}" method="POST" style="display: inline;">
                        @method('PUT')
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm float-right" onclick="return confirmDelete()">Hủy</button>
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop

@section('css')
    <!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
@stop

@section('js')
    <script>
        function confirmDelete() {
            return confirm('Bạn có chắc muốn xóa danh mục sản phẩm này khỏi hệ thống?');
        }
    </script>
@stop