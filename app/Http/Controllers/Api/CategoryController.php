<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{

    // GET ALL CATEGORIES FOR LOGGED IN USER
    public function index(Request $request)
    {
        $categories = Category::where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'categories' => $categories,
        ]);
    }

    // CREATE CATEGORY
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string',
            'icon' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $category = Category::create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'color' => $request->color ?? '#2F5DA8',
            'icon' => $request->icon ?? 'category',
            'description' => $request->description,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Category created successfully',
            'category' => $category,
        ]);
    }

    // UPDATE CATEGORY
    public function update(Request $request, $id)
    {
        $category = Category::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found',
            ], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string',
            'icon' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name' => $request->name,
            'color' => $request->color,
            'icon' => $request->icon,
            'description' => $request->description,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Category updated successfully',
            'category' => $category,
        ]);
    }

    // DELETE CATEGORY
    public function destroy(Request $request, $id)
    {
        $category = Category::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found',
            ], 404);
        }

        $category->delete();

        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully',
        ]);
    }
}