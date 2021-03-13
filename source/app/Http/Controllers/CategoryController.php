<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $categories = Category::with('products')->get();

        return JsonResource::collection($categories)->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request): JsonResponse
    {
//        dump(123);
        $category = Category::make($request->validated());

        DB::transaction(function () use ($request, &$category) {
            $category->save();
            $category->products()->sync($request->input('product_ids'));
        });
        $category->loadMissing('products');

        return JsonResource::make($category)->response();
    }

    /**
     * Display the specified resource.
     */
    public function show(int $category_id): JsonResponse
    {
        $category = Category::with('products')->findOrFail($category_id);

        return JsonResource::make($category)->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, int $category_id): JsonResponse
    {
        $category = Category::findOrFail($category_id);

        DB::transaction(function () use ($request, &$category) {
            $category->update($request->validated());
            $category->products()->sync($request->input('product_ids'));
        });
        $category->loadMissing('products');

        return JsonResource::make($category)->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $category_id): JsonResponse
    {
        $category = Category::findOrFail($category_id);
        $category->delete();

        return response()->json([], 204);
    }
}
