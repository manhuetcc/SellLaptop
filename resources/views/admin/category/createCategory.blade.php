@extends('adminlte::page')

@section('title', 'Tạo danh mục')

@section('content_header')
    
    
@stop

@section('content')
    <!-- Nội dung chính của trang quản trị -->
  <form action="{{ route('adminCategory.store') }}" method="POST">
    @csrf
    <div class="card card-primary">
      <div class="card-header">
        <h1 class="card-title">Thêm mới danh mục sản phẩm</h1>
      </div>
      <!-- /.card-header -->
      <div class="card-body col-md-8">
        <div class="form-group">
          <label for="categoryName">Tên danh mục mới</label>
          <input type="text" name="name" class="form-control form-control-border" id="categoryName" placeholder="Tên Hãng">
        </div>
        <div class="form-group">
          <label for="desc">Mô tả </label>
          <input type="text" name="desc" class="form-control form-control-border" id="desc" placeholder="Tập hợp các dòng laptop">
        </div>
        <div>          
          <button type="submit" class="btn btn-success float-right">Xác nhận</button>
          <a href="{{ route('adminCategory.index') }}" class="btn btn-danger float-right">Hủy bỏ</a>
        </div>        
      </div>
      <!-- /.card-body -->
    </div>
  </form>
@stop

@section('css')
    <!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
@stop

@section('js')
  
@stop