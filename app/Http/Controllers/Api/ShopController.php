<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop;

class ShopController extends Controller
{

    // GET ALL SHOPS FOR LOGGED IN USER
    public function index(Request $request)
    {
        $shops = Shop::where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'shops' => $shops,
        ]);
    }

    // CREATE SHOP
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $shop = Shop::create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'description' => $request->description,
            'is_active' => true,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Shop created successfully',
            'shop' => $shop,
        ]);
    }

    // UPDATE SHOP
    public function update(Request $request, $id)
    {
        $shop = Shop::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$shop) {
            return response()->json([
                'status' => false,
                'message' => 'Shop not found',
            ], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $shop->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'description' => $request->description,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Shop updated successfully',
            'shop' => $shop,
        ]);
    }

    // DELETE SHOP
    public function destroy(Request $request, $id)
    {
        $shop = Shop::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$shop) {
            return response()->json([
                'status' => false,
                'message' => 'Shop not found',
            ], 404);
        }

        $shop->delete();

        return response()->json([
            'status' => true,
            'message' => 'Shop deleted successfully',
        ]);
    }
}