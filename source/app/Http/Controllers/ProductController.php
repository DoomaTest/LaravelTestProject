<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $products = Product::with('categories')->get();

        return JsonResource::collection($products)->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request): JsonResponse
    {
        $product = Product::make($request->validated());

        DB::transaction(function () use ($request, &$product) {
            $product->save();
            $product->categories()->sync($request->input('category_ids'));
        });
        $product->loadMissing('categories');

        return JsonResource::make($product)->response();
    }

    /**
     * Display the specified resource.
     */
    public function show(int $product_id): JsonResponse
    {
        $product = Product::with('categories')->findOrFail($product_id);

        return JsonResource::make($product)->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, int $product_id): JsonResponse
    {
        $product = Product::findOrFail($product_id);

        DB::transaction(function () use ($request, &$product) {
            $product->update($request->validated());
            $product->categories()->sync($request->input('category_ids'));
        });
        $product->loadMissing('categories');

        return JsonResource::make($product)->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $product_id): JsonResponse
    {
        $product = Product::findOrFail($product_id);
        $product->delete();

        return response()->json([], 204);
    }
}
