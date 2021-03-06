@extends('adminlte::page')

@section('title', 'Chỉnh sửa danh mục')

@section('content_header')
    
    
@stop

@section('content')
    <!-- Nội dung chính của trang quản trị -->
  <form action="{{ route('adminCategory.update', $category->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="card card-primary">
      <div class="card-header">
        <h1 class="card-title">Chỉnh sửa danh mục sản phẩm</h1>
      </div>
      <!-- /.card-header -->
      <div class="card-body col-md-8">
        <div class="form-group">
          <label for="categoryName">Tên danh mục</label>
          <input type="text" name="name" class="form-control form-control-border" id="categoryName" value="{{ $category->name }}">
        </div>
        <div class="form-group">
          <label for="Desc">Mô tả</label>
          <input type="text" name="desc" class="form-control" id="Desc" value="{{ $category->desc }}">
        </div>
        <div>          
          <button type="submit" class="btn btn-success float-right" onclick="confirmEdit()">Hoàn thành</button>
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
  <script>
    function confirmEdit() {
        return confirm('Bạn có chắc muốn sửa danh mục sản phẩm này?');
    }
  </script>
@stop