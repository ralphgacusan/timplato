<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\StockTransaction;

use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // Landing Page
    public function landingPage(){
        return view('customer.home');
    }
    
    // CUSTOMER SIDE
    public function products(Request $request)
    {
        // Start query
        $query = Product::with(['category', 'images']);

        // 🔎 Search filter
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // 📂 Category filter
        if ($request->has('category') && !empty($request->category)) {
            $category = Category::where('name', $request->category)->first();

            if ($category) {
                $ids = $category->allChildrenIds(); // include parent + children
                $query->whereIn('category_id', $ids);
            }
        }

        // ↕️ Sorting
        if ($request->has('sort') && !empty($request->sort)) {
            switch ($request->sort) {
                case 'az':
                    $query->orderBy('name', 'asc');
                    break;
                case 'za':
                    $query->orderBy('name', 'desc');
                    break;
                case 'price-asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price-desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'date-asc': // Oldest first
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'date-desc': // Newest first
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            // Default sort by newest
            $query->orderBy('created_at', 'desc');
        }

        // Fetch products
        $products = $query->paginate(30)->withQueryString();

        return view('customer.products', compact('products'));
    }


    // Show a specific product
    public function specificProduct(Product $product)
    {
        $product->load([
            'category',
            'images',
            'reviews.user',
        ]);

        // Calculate stats
        $averageRating = $product->reviews()->avg('rating') ?? 0;
        $totalReviews  = $product->reviews()->count();

        return view('customer.specific-product', compact('product', 'averageRating', 'totalReviews'));
    }


    


    // ADMIN SIDE
    public function showProductManagement(Request $request)
    {
        // Start query
        $query = Product::with(['category', 'images']);

        // 🔎 Search filter
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 📂 Category filter
        if ($request->has('category') && !empty($request->category)) {
            $category = Category::where('name', $request->category)->first();

            if ($category) {
                $ids = $category->allChildrenIds(); // include parent + children
                $query->whereIn('category_id', $ids);
            }
        }

        // ↕️ Sorting
        if ($request->has('sort') && !empty($request->sort)) {
            switch ($request->sort) {
                case 'az':
                    $query->orderBy('name', 'asc');
                    break;
                case 'za':
                    $query->orderBy('name', 'desc');
                    break;
                case 'price-asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price-desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'date-desc':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'date-asc':
                    $query->orderBy('created_at', 'asc');
                    break;
            }
        }

        // Fetch products
        $products = $query->paginate(20)->withQueryString();

        return view('admin.product-management', compact('products'));
    }

    

    /**
     * Show a specific product (Admin / Customer side).
     */
    public function show(Product $product)
    {
        $product->load(['category', 'images', 'reviews.user']);

        $averageRating = $product->reviews()->avg('rating') ?? 0;
        $totalReviews  = $product->reviews()->count();

        return view('admin.product-specific', compact('product', 'averageRating', 'totalReviews'));
    }


    /**
     * Show the add product form.
     */
    public function create()
    {
        $categories = Category::all();

        // Group subcategories by parent_id
        $subcategoriesByParent = [];
        foreach ($categories as $cat) {
            if ($cat->parent_id) {
                $subcategoriesByParent[$cat->parent_id][] = $cat;
            }
        }

        return view('admin.product-add', compact('categories', 'subcategoriesByParent'));
    }


    /**
     * Store a new product.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        // Create the product
        $product = Product::create([
            'name'           => $validated['name'],
            'description'    => $validated['description'] ?? null,
            'price'          => $validated['price'],
            'stock_quantity' => $validated['stock_quantity'],
            'restock_level'  => $validated['restock_level'] ?? null,
            'category_id'    => $validated['subcategory_id'],
        ]);

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            $files = $request->file('images');

            foreach ($files as $index => $file) {
                // Generate unique filename
                $filename = uniqid() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

                // Store file in public/images/products/
                $file->move(public_path('images/products'), $filename);

                // Save image record in DB
                $product->images()->create([
                    'image_url'  => 'products/' . $filename, // relative to public
                    'is_primary' => $index === 0, // first uploaded image = primary
                ]);
            }
        }


        return redirect()->route('admin.product-management')
                        ->with('success', 'Product created successfully!');
    }


    /**
     * Show the edit product form.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();

        // Group subcategories by parent_id for Blade/JS
        $subcategoriesByParent = [];
        foreach ($categories as $cat) {
            if ($cat->parent_id) {
                $subcategoriesByParent[$cat->parent_id][] = $cat;
            }
        }

        // Determine parent and subcategory IDs
        $parentCategoryId = $product->category?->parent_id ?? $product->category_id;
        $selectedSubcategoryId = $product->category?->parent_id ? $product->category_id : null;

        // Load images if needed
        $product->load('images');

        return view('admin.product-edit', compact(
            'product',
            'categories',
            'subcategoriesByParent',
            'parentCategoryId',
            'selectedSubcategoryId'
        ));
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        // Update the product
        $product->update([
            'name'           => $validated['name'],
            'description'    => $validated['description'] ?? null,
            'price'          => $validated['price'],
            'stock_quantity' => $validated['stock_quantity'],
            'restock_level'  => $validated['restock_level'] ?? null,
            'category_id'    => $validated['subcategory_id'] ?? $validated['category_id'],
        ]);

        // Handle deleted images
        if ($request->filled('deleted_images')) {
            $deletedIds = array_filter(explode(',', $request->deleted_images)); // filter out blanks
            $imagesToDelete = $product->images()->whereIn('image_id', $deletedIds)->get();

            foreach ($imagesToDelete as $img) {
                $filePath = public_path('images/' . $img->image_url);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $img->delete();
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            $files = $request->file('images');

            foreach ($files as $file) {
                $filename = uniqid() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                $file->move(public_path('images/products'), $filename);

                $product->images()->create([
                    'image_url'  => 'products/' . $filename,
                    'is_primary' => false,
                ]);
            }
        }

        return redirect()->route('admin.product-management')
                        ->with('success', 'Product updated successfully!');
        // dd($request->deleted_images);
    }


    /**
     * Delete a product.
     */
    public function destroy(Product $product)
    {
        $product->images()->delete(); // delete images first if you want
        $product->delete();
        return redirect()->route('admin.product-management')->with('success', 'Product deleted successfully!');
    }

    /**
     * Validation rules.
     */
    private function rules()
    {
        return [
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'restock_level'  => 'nullable|integer|min:0',
            'category_id'    => 'required|exists:categories,category_id',
            'subcategory_id' => 'required|exists:categories,category_id',
            'images'         => 'nullable|array',
            'images.*.image_url'  => 'required|string',
            'images.*.is_primary' => 'boolean',
        ];
    }




   // Inventory Management
   
   public function showInventoryManagement(Request $request)
    {
        $query = Product::with(['category', 'latestStockTransaction']);

        // Search by product name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by stock status
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'in-stock':
                    $query->where('stock_quantity', '>', 5); // adjust threshold
                    break;
                case 'low-stock':
                    $query->whereBetween('stock_quantity', [1, 5]);
                    break;
                case 'out-of-stock':
                    $query->where('stock_quantity', 0);
                    break;
            }
        }

        // Sorting
        switch ($request->sort) {
            case 'name-asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name-desc':
                $query->orderBy('name', 'desc');
                break;
            case 'stock-asc':
                $query->orderBy('stock_quantity', 'asc');
                break;
            case 'stock-desc':
                $query->orderBy('stock_quantity', 'desc');
                break;
            case 'latest-restock':
                $query->orderByDesc(
                    StockTransaction::select('created_at')
                        ->whereColumn('product_id', 'products.product_id')
                        ->latest()
                );
                break;
            default:
                $query->orderBy('product_id', 'desc');
                break;
        }

        $products = $query->paginate(30)->withQueryString();

        return view('admin.inventory-management', compact('products'));
    }





    // Handle Adjust Stock (Add or Deduct)
    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer',
            'type' => 'required|in:add,deduct',
        ]);

        if ($request->type === 'add') {
            $product->stock_quantity += $request->quantity;
        } else {
            $product->stock_quantity -= $request->quantity;
        }

        $product->save();

        // Record stock transaction
        StockTransaction::create([
            'product_id' => $product->product_id,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'performed_by' => Auth::user()->getFullName(), // store full name of auth user
        ]);

        return redirect()->route('admin.inventory-management')->with('success', 'Stock updated successfully.');
    }

    public function viewStockHistory(Product $product)
    {
        $transactions = StockTransaction::where('product_id', $product->product_id)
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('admin.inventory-history', compact('product', 'transactions'));
    }

    // // View Stock History
    // public function stockHistory(Product $product)
    // {
    //     $transactions = StockTransaction::where('product_id', $product->product_id)
    //         ->latest()
    //         ->paginate(10);

    //     return view('admin.inventory.history', compact('product', 'transactions'));
    // }

    // // Delete product (optional)
    // public function destroy(Product $product)
    // {
    //     $product->delete();
    //     return redirect()->route('admin.inventory.index')->with('success', 'Product deleted successfully.');
    // }


}
