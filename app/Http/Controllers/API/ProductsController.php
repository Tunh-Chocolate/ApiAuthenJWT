<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Storage;
use App\Models\Products;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Lấy danh sách sản phẩm.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::all();

        return response()->json([
            'Products' => $products
        ]);
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
        $request->avatar->move(public_path('upload/' . date('Y') . '/' . date('m') . '/' . date('d')), $imageName);
        $imagePath = 'upload/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $imageName;
        $imageUrl = url($imagePath);

        // Tạo sản phẩm mới trong database
        $product = new Products;
        $product->sku = $validatedData['sku'];
        $product->name = $validatedData['name'];
        $product->stock = $validatedData['stock'];
        $product->avatar = $imageName;
        $product->$imageUrl;
        // $product->path = 'upload/' . date('Y') . '/' . date('m') . '/' . date('d');  
        $product->save();
        // Xóa ảnh đã tải lên nếu không lưu vào thư mục
        // Storage::disk('public')->delete($path);

        return response()->json([
            'New product' => $product,
            'path'        => $imagePath,
            'Url_Image'   => $imageUrl
        ]);
    }

    // $imageHash = substr(md5(uniqid()), 0, 2);
    // $imageName = date('Ymd') . $imageHash . '.' . $request->file('image')->getClientOriginalExtension();
    // $request->image->move(public_path('upload/' . date('Y') . '/' . date('n')), $imageName);
    // $blog->image = $imageName;
    /**
     * Lấy thông tin chi tiết của sản phẩm.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Products::find($id);
        return response()->json($product);
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
            'avatar' => 'required|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        $product = Products::find($id);
        $product->sku = $validatedData['sku'];
        $product->name = $validatedData['name'];
        $product->stock = $validatedData['stock'];

        // Cập nhật hình ảnh mới nếu có
        if ($request->hasFile('avatar')) {
            if ($product->avatar) {
                $imagePath = public_path('upload/' . date('Y', strtotime($product->created_at)) . '/' . date('m', strtotime($product->created_at)) . '/' . date('d', strtotime($product->created_at)) . '/' . $product->avatar);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $imageHash = substr(md5(uniqid()), 0, 2);
            $imageName = date('Ymd') . $imageHash . '.' . $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(public_path('upload/' . date('Y', strtotime($product->created_at)) . '/' . date('m', strtotime($product->created_at)) . '/' . date('d', strtotime($product->created_at))), $imageName);
            $product->avatar = $imageName;
            $imagePath = 'upload/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $imageName;
            $imageUrl = url($imagePath);
        }

        $product->save();
        
        return  response()->json([
            'New product' => $product,
            'path'        => $imagePath,
            'Url_Image'   => $imageUrl         
        ]);
    }

    /**
     * Xóa sản phẩm khỏi database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Products::findOrFail($id);

        if ($product->avatar) {
            $imagePath = public_path('upload/' . date('Y', strtotime($product->created_at)) . '/' . date('m', strtotime($product->created_at)) . '/' . date('d', strtotime($product->created_at)) . '/' . $product->avatar);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $product->delete();

        return response()->json(['message' => 'Products deleted successfully']);
    }
}
