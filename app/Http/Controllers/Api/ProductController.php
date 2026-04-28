<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $query = Product::with('category')
            ->latest();

        if (request()->filled('category_id')) {
            $query->where(
                'category_id',
                request()->category_id
            );
        }

        $products = $query->paginate(10);

        return ProductResource::collection($products);
    }

    public function show(Product $product): ProductResource
    {
        $product->load('category');

        return new ProductResource($product);
    }

    public function store(StoreProductRequest $request): ProductResource
    {
        $product = Product::create($request->validated());

        $product->load('category');

        return new ProductResource($product);
    }

    public function update(
        UpdateProductRequest $request,
        Product $product
    ): ProductResource {
        $product->update($request->validated());

        $product->load('category');

        return new ProductResource($product);
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully',
        ], 200);
    }
}
