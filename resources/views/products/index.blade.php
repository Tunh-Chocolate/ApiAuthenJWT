@extends('layout.layout')


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Danh sách sản phẩm</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('products.create') }}"> Tạo sản phẩm mới</a>
                </div>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>SKU</th>
                <th>Tên sản phẩm</th>
                <th>Số lượng tồn kho</th>
                <th>Hình ảnh</th>
                <th width="280px">Thao tác</th>
            </tr>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->sku }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->stock }}</td>
                <td><img src="{{ asset('upload/2023/7/'.$product->avatar) }}" alt="{{ $product->stock }}" width="100"></td>
                <td>
                    <form action="{{ route('products.destroy',$product->id) }}" method="POST">
                        <a class="btn btn-primary" href="{{ route('products.edit',$product->id) }}">Sửa</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>

        <!-- Hiển thị phân trang -->
<div class="pagination">
    {{ $products->links() }}
</div>
    </div>
@endsection