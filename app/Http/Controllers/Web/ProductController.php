<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // Landing Page
    public function landingPage(){
        return view('customer.home');
    }
    
    // Display all products
    public function products()
    {
        $products = Product::with(['category', 'images'])->get();

        if ($products->count() > 0) {
            return view('customer.products', compact('products'));
        } else {
            return view('customer.products')->with('message', 'No records available');
        }
    }

    // Show a specific product
    public function specificProduct(Product $product)
    {
        $product->load(['category', 'images']);
        return view('customer.specific-product', compact('product'));
    }

    // // Show a specific product - TEST
    // public function specificProduct()
    // {
       
    //     return view('customer.specific-product');
    // }

    // // Show the create form
    // public function create()
    // {
    //     $categories = Category::all();
    //     return view('products.create', compact('categories'));
    // }

    // // Create a product
    // public function store(Request $request)
    // {
    //     // Product Validation Rules
    //     $rules = $this->productValidationRules();

    //     // Product Validator
    //     $validator = Validator::make($request->all(), $rules);

    //     // Handles error in validation
    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     $validated = $validator->validated();

    //     // Create the product
    //     $product = Product::create([
    //         'name' => $validated['name'],
    //         'description' => $validated['description'] ?? null,
    //         'price' => $validated['price'],
    //         'stock_quantity' => $validated['stock_quantity'],
    //         'restock_level' => $validated['restock_level'] ?? null,
    //         'category_id' => $validated['category_id'],
    //     ]);

    //     // Handle images if provided
    //     if (!empty($validated['images'])) {
    //         foreach ($validated['images'] as $img) {
    //             $product->images()->create([
    //                 'image_url' => $img['image_url'],
    //                 'is_primary' => $img['is_primary'] ?? false,
    //             ]);
    //         }
    //     }

    //     return redirect()->route('products.index')->with('success', 'Product Created Successfully');
    // }

    // // Product Validation Rules
    // private function productValidationRules()
    // {
    //     $rules = [
    //         'name' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'price' => 'required|numeric|min:0',
    //         'stock_quantity' => 'required|integer|min:0',
    //         'restock_level' => 'nullable|integer|min:0',
    //         'category_id' => 'required|exists:categories,category_id',
    //         'images' => 'nullable|array',
    //         'images.*.image_url' => 'required|string',
    //         'images.*.is_primary' => 'boolean',
    //     ];

    //     return $rules;
    // }

    

    // // Show the edit form
    // public function edit(Product $product)
    // {
    //     $categories = Category::all();
    //     $product->load('images');
    //     return view('products.edit', compact('product', 'categories'));
    // }

    // // Edit a product
    // public function update(Request $request, Product $product)
    // {
    //     // Product Validation Rules
    //     $rules = $this->productValidationRules();

    //     // Product Validator
    //     $validator = Validator::make($request->all(), $rules);

    //     // Handles Product Validation
    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     $validated = $validator->validated();

    //     // Update the product
    //     $product->update([
    //         'name' => $validated['name'],
    //         'description' => $validated['description'] ?? null,
    //         'price' => $validated['price'],
    //         'stock_quantity' => $validated['stock_quantity'],
    //         'restock_level' => $validated['restock_level'] ?? null,
    //         'category_id' => $validated['category_id'],
    //     ]);

    //     $existingImageIds = $product->images()->pluck('image_id')->toArray();
    //     $newImageIds = [];

    //     if (!empty($validated['images'])) {
    //         foreach ($validated['images'] as $img) {
    //             if (isset($img['image_id']) && in_array($img['image_id'], $existingImageIds)) {
    //                 // Update existing image
    //                 $product->images()->where('image_id', $img['image_id'])->update([
    //                     'image_url' => $img['image_url'],
    //                     'is_primary' => $img['is_primary'] ?? false,
    //                 ]);
    //                 $newImageIds[] = $img['image_id'];
    //             } else {
    //                 // Create new image
    //                 $new = $product->images()->create([
    //                     'image_url' => $img['image_url'],
    //                     'is_primary' => $img['is_primary'] ?? false,
    //                 ]);
    //                 $newImageIds[] = $new->image_id;
    //             }
    //         }
    //     }

    //     // Delete images not in request
    //     $product->images()->whereNotIn('image_id', $newImageIds)->delete();

    //     return redirect()->route('products.index')->with('success', 'Product Updated Successfully');
    // }

    // // Delete a product
    // public function destroy(Product $product)
    // {
    //     $product->delete();
    //     return redirect()->route('products.index')->with('success', 'Product Deleted Successfully');
    // }
}
