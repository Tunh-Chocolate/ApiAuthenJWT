@extends('layout.layout')

@section('content')
    <h1>Thêm sản phẩm mới</h1>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="sku">SKU:</label>
            <input type="text" name="sku" id="sku" value="{{ old('sku') }}" required>
        </div>
        <div>
            <label for="name">Tên sản phẩm:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
        </div>
        <div>
            <label for="stock">Số lượng:</label>
            <input type="number" name="stock" id="stock" value="{{ old('stock') }}" required>
        </div>
        <div>
            <label for="avatar">Ảnh đại diện:</label>
            <input type="file" name="avatar" id="avatar" required>
        </div>
        <button type="submit">Thêm sản phẩm</button>
    </form>
@endsection