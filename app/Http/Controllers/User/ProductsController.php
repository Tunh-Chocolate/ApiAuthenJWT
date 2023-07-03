<?php

namespace App\Http\Controllers\User;

use App\Models\Products;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ProductsController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Sử dụng phương thức paginate để phân trang
        $products = Products::paginate(10);

        return view('products.index', compact('products'));
    }

    /**
     * Hiển thị form tạo sản phẩm mới.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Lưu sản phẩm mới vào database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $validatedData = $request->validate([
            'sku' => 'required',
            'name' => 'required',
            'stock' => 'required|integer',
            'avatar' => 'required|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

         // Lưu hình ảnh vào thư mục public/upload
         $imageHash = substr(md5(uniqid()), 0, 2);
         $imageName = date('Ymd') . $imageHash . '.' . $request->file('avatar')->getClientOriginalExtension();
         $request->avatar->move(public_path('upload/' . date('Y') . '/' . date('n')), $imageName);

        // Tạo sản phẩm mới trong database
        $product = new Products;
        $product->sku = $validatedData['sku'];
        $product->name = $validatedData['name'];
        $product->stock = $validatedData['stock'];
        $product->avatar = $imageName;
        $product->save();

        return redirect()->route('products.index')
            ->with('success', 'Sản phẩm đã được tạo thành công.');
    }

    /**
     * Hiển thị thông tin chi tiết của sản phẩm.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Products::find($id);
        return view('products.show', compact('product'));
    }

    /**
     * Hiển thị form chỉnh sửa sản phẩm.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Products::find($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Cập nhật thông tin sản phẩm trong database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    // Kiểm tra dữ liệu đầu vào
    $validatedData = $request->validate([
        'sku' => 'required',
        'name' => 'required',
        'stock' => 'required|integer',
        'avatar' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:10240',
    ]);

    $product = Products::find($id);
    $product->sku = $validatedData['sku'];
    $product->name = $validatedData['name'];
    $product->stock = $validatedData['stock'];

    // Cập nhật hình ảnh mới nếu có
    if ($request->hasFile('avatar')) {
        // Xóa hình ảnh cũ
        if (file_exists(public_path('images/' . $product->avatar))) {
            unlink(public_path('images/' . $product->avatar));
        }

        // Lưu hình ảnh mới
        $imageName = time() . '.' . $request->avatar->extension();
        $request->avatar->move(public_path('images'), $imageName);
        $product->avatar = $imageName;
    }

    $product->save();


    return redirect()->route('products.index')
        ->with('success', 'Sản phẩm đã được cập nhật thành công.');
}
    /**
     * Xóa sản phẩm khỏi database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Products::find($id);

        // Xóa hình ảnh của sản phẩm
        if (file_exists(public_path('images/' . $product->avatar))) {
            unlink(public_path('images/' . $product->avatar));
        }

        
        $product->delete();


        return redirect()->route('products.index')
            ->with('success', 'Sản phẩm đã được xóa thành công.');
    }
}
