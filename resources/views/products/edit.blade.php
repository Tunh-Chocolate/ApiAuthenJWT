
@extends('layout.layout')

@section('content')
    <h1>Chỉnh sửa sản phẩm</h1>
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <label for="sku">SKU:</label>
            <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" required>
        </div>
        <div>
            <label for="name">Tên sản phẩm:</label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required>
        </div>
        <div>
            <label for="stock">Số lượng:</label>
            <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" required>
        </div>
        <div>
            <label for="avatar">Ảnh đại diện:</label>
            <input type="file" name="avatar" id="avatar">
            @if ($product->avatar)
                <img src="{{ asset('images/'.$product->avatar) }}" alt="{{ $product->name }}" width="100">
            @endif
        </div>
        <button type="submit">Cập nhật sản phẩm</button>
    </form>
@endsection