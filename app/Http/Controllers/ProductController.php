<?php

namespace App\Http\Controllers;

use App\Http\Resources\ListProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProductController extends Controller
{
    public function list_products()
    {
        $list_products = Product::get();
        if (count($list_products) > 0) {
            return [
                'data' => ListProductResource::collection($list_products),
                'page' => Product::paginate(24)
            ];
        } else {
            return response()->json([
                'success' => false,
                'msg' => "Not found data about product",
                'data' => $list_products
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            $new_product = new Product;
            $new_product->name = $request->name;
            $new_product->image_path = $request->image_path;
            $new_product->amount = $request->amount;
            $new_product->status = 0;
            $new_product->category_id = $request->category_id;
            if ($image_path = $request->file('image_path')) {
                $image = $image_path->store('public/attachments/'.Carbon::now()->format('Y').'/products/' . Carbon::now()->format('Y-m-d'));
                $new_product->image_path = $image;
            }
            $new_product->save();
            return response()->json([
                'success' => true,
                'msg' => 'Store Product Successfully'
            ]);
        } catch (Throwable $ex) {
            Log::error($ex);
            return response()->json([
                'success' => false,
                'msg' => 'Cannot Store Product',
                'data' => $new_product
            ]);
        }
    }

    public function update(Request $request)
    {
        try {
            $product = Product::where('id', $request->id)->first();
            $product->name = $request->name == null ? $product->name : $request->name;
            $product->amount = $request->amount == null ? $product->amount : $request->amount;
            $product->status = $request->status == null ? $product->status : $request->status;
            $product->category_id = $request->category_id == null ? $product->category_id : $request->category_id;
            if ($image_path = $request->file('image_path')) {
                $image = $image_path->store('public/products/' . Carbon::now()->format('Y-m-d'));
                // $url = Storage::url($image);
                $product->image_path = $image;
            }
            // return $product;

            $product->update();
            if ($product) {
                return response()->json([
                    'success' => true,
                    'msg' => 'Update Product Successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'msg' => 'Cannot Update Product Maybe some data is invalid or incorrect'
                ]);
            }
        } catch (Throwable $ex) {
            return response()->json([
                'success' => false,
                'msg' => 'Some Error,Not found data'
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $product = Product::where('id', $request->id)->first();
        //$path = explode('/', $product->image_path);
        // return storage_path($product->image_path);
        if ($product) {
            Storage::delete($product->image_path);
            // return $product->image_path;
            $product->delete();
            return response()->json([
                'success' => true,
                'msg' => 'Delete data successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Cannot delete data(Not found data or data is wrong)'
            ]);
        }
    }
}
