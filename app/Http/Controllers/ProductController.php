<?php

namespace App\Http\Controllers;

use App\Http\Resources\ListProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function list_products()
    {
        $list_products = Product::get();
        if (count($list_products) > 0) {
            return [
                'data' => ListProductResource::collection($list_products),
                'page' => Product::paginate(10)
            ];
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'dont have data',
                'data' => $list_products
            ]);
        }
    }

    public function store(Request $request)
    {
        if ($request != null) {
            $new_product = new Product;
            $new_product->name = $request->name;
            $new_product->image_path = $request->image_path;
            $new_product->amount = $request->amount;
            $new_product->status = 0;
            $new_product->category_id = $request->category_id;
            if ($image_path = $request->file('image_path')) {
                $filename = Carbon::now()->format('Y-m-d') . '.' . $image_path->getClientOriginalExtension();
                $new_product->image_path = $filename;
            }
            $new_product->save();
            return response()->json([
                'success' => true,
                'msg' => 'Create Product Successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Cannot Create Product',
                'data' => $this->new_product
            ]);
        }
        // } else {
        // return response()->json([
        // 'success' => false,
        // 'msg' => 'Name must be unique',
        // 'data' => $data_input
        // ]);
        // }
    }
}
