<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory; 
use App\Helpers\ResponseFormatter;

class APIProductCategoryController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 10); 
        $name = $request->input('name'); 
        $show_product = $request->input('show_product'); 

        if ($id) {
            $category = ProductCategory::with(['product'])->find($id);
            if ($category) {
                return ResponseFormatter::success($category, 'Data kategori berhasil diambil');
            } else {
                return ResponseFormatter::error(null, 'Data kategori tidak ada');
            }
        }

        $category = ProductCategory::query();

        if ($name) {
            $category->where('name', 'like', '%' . $name . '%');
        }

        if ($show_product) {
            $category->with('product');
        }

        return ResponseFormatter::success($category->paginate($limit), 'Data kategori berhasil diambil');
    }
}
