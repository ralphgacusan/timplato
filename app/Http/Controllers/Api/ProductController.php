<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;

use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    // Display all products
    public function index(){

        $products = Product::with(['category', 'primaryImage'])->get();
                    // return ProductResource::collection($products->load(['category', 'images']));

        if($products->count() > 0){
            return ProductResource::collection($products);
        } else {
            return response()->json(['message' => 'No records available'], 200);
        }
    }

    // Create a product
    public function store(Request $request){

        // Product Validation Rules
        $rules = $this->productValidationRules();
        // Product Validator
        $validator = Validator::make($request->all(), $rules);
        // Handles error in validation
        if($validator->fails()) {
            return response()->json([
                'message' => 'All fields are required',
                'errors' => $validator->messages(),
            ], 422);
        }

        $validated = $validator->validated();

        // Create the product
        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'stock_quantity' => $validated['stock_quantity'],
            'restock_level' => $validated['restock_level'] ?? null,
            'category_id' => $validated['category_id'],
        ]);

        // Handle images if provided
        if (!empty($validated['images'])) {
            foreach ($validated['images'] as $img) {
                $product->images()->create([
                    'image_url' => $img['image_url'],
                    'is_primary' => $img['is_primary'] ?? false,
                ]);
            }
        }

        // Return the created product with category and images
        return response()->json([
            'message' => 'Product Created Successfully',
            'data' => new ProductResource($product->load(['category', 'images']))
        ], 200);

        
    }

    // Product Validation Rules
    private function productValidationRules(){
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'restock_level' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,category_id',
            'images' => 'nullable|array',
            'images.*.image_url' => 'required|string',
            'images.*.is_primary' => 'boolean',
        ];

        return $rules;
    }

    // Show a specific product
    public function show(Product $product){
        
        // Return the specific product with category and images
        return response()->json([
            'message' => 'Product Retrived Successfully',
            'data' => new ProductResource($product->load(['category', 'images']))
        ], 200);

    }

    // Edit a product
    public function update(Request $request, Product $product){
        
        // Product Validation Rules
        $rules = $this->productValidationRules();
        // Product Validator
        $validator = Validator::make($request->all(), $rules);
        // Handles Product Validation
        if($validator->fails()) {
            return response()->json([
                'message' => 'All fields are required',
                'errors' => $validator->messages(),
            ], 422);
        }

        $validated = $validator->validated();
        
        // Update the product
        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'stock_quantity' => $validated['stock_quantity'],
            'restock_level' => $validated['restock_level'] ?? null,
            'category_id' => $validated['category_id'],
        ]);

        $existingImageIds = $product->images()->pluck('image_id')->toArray();
        $newImageIds = [];

        foreach ($validated['images'] as $img) {
            if (isset($img['image_id']) && in_array($img['image_id'], $existingImageIds)) {
                // Update existing image
                $product->images()->where('image_id', $img['image_id'])->update([
                    'image_url' => $img['image_url'],
                    'is_primary' => $img['is_primary'] ?? false,
                ]);
                $newImageIds[] = $img['image_id'];
            } else {
                // Create new image
                $new = $product->images()->create([
                    'image_url' => $img['image_url'],
                    'is_primary' => $img['is_primary'] ?? false,
                ]);
                $newImageIds[] = $new->image_id;
            }
        }

        // Delete images not in request
        $product->images()->whereNotIn('image_id', $newImageIds)->delete();

        // Return the updated product with category and images
        return response()->json([
            'message' => 'Product Updated Successfully',
            'data' => new ProductResource($product->load(['category', 'images']))
        ], 200);
    }

    // Delete a product
    public function destroy(Product $product){
        // Delete the product
        $product->delete();
        // Return success message
        return response()->json([
            'message' => 'Product Deleted Successfully',
        ], 200);
    }
}
