<?php

namespace App\Http\Controllers;

use App\Http\Resources\ListCategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Exception;
use Throwable;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function list_categories()
    {
        $list_categories = Category::get();
        if (count($list_categories) > 0) {
            $pageSize = 24;
            return [
                'data' => ListCategoryResource::collection($list_categories),
                'page' => Category::paginate(10)
            ];
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'something went wrong,Maybe dont have data',
                'data' => $list_categories
            ]);
            // echo 'Uhhh dont have data';
        }
    }

    public function store(Request $request)
    {
        $data_input = Category::where('name', $request->name)->get();
        if (count($data_input) == 0) {
            if ($request->name != null) {
                $new_category = new Category;
                $new_category->name = $request->name;
                $new_category->save();
                return response()->json([
                    'success' => true,
                    'msg' => 'Create Category Successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'msg' => 'field name is null'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Name must be unique',
                'data' => $data_input
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $category = Category::where('id', $request->id)->first();
        $data_unique = Category::where('name', $request->name)->get();
        if ($category) {
            if ($request->name != null && count($data_unique) == 0) {
                $category->name = $request->get('name');
                $category->update();
                return response()->json([
                    'success' => true,
                    'msg' => 'Update Category Successfully',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'msg' => 'Can not Update Category, field name is null or duplicate name',
                    'data' => $category
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Can not find id',
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $id = Category::where('id', $request->id)->first();
        if ($id) {
            $id->delete();
            return response()->json([
                'success' => true,
                'msg' => 'delete category successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'cannot find id'
            ]);
        }
    }
}
