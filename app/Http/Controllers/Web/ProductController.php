<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;
use App\Models\Banner;
use App\Models\Page;
use App\Models\AdminLog;


use App\Models\ProductImage;
use App\Models\StockTransaction;

use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
public function landingPage()
{
    $categories = Category::with('parent')->get();

    $bestSellers = Product::with('primaryImage')
        ->where('status', true)
        ->orderByDesc('sold')
        ->take(10)
        ->get();

    $newArrivals = Product::with('primaryImage')
        ->where('status', true)
        ->latest()
        ->take(10)
        ->get();


    $banners = Banner::where('slug', 'home')
        ->where('active', true)
        ->orderBy('order', 'asc')
        ->get();

    // ✅ Fetch separate hero content for guest and auth
    $heroGuest = Page::where('slug', 'home-hero-guest')->first();
    $heroAuth = Page::where('slug', 'home-hero-auth')->first();

    return view('customer.home', compact('categories', 'bestSellers', 'newArrivals', 'banners', 'heroGuest', 'heroAuth'));
}

public function products(Request $request)
{
    $query = Product::with(['category', 'images'])->where('status', true); // only active products

    // 🔍 Search Filter
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
        });
    }

    // 📂 Main Categories Filter (multiple)
    if ($request->filled('main_category')) {
        $mainCategories = Category::whereIn('name', $request->main_category)->get();
        $mainCategoryIds = [];
        foreach ($mainCategories as $cat) {
            $mainCategoryIds = array_merge($mainCategoryIds, $cat->allChildrenIds());
        }
        $query->whereIn('category_id', $mainCategoryIds);
    }

    // 📂 Sub Categories Filter (multiple)
    if ($request->filled('sub_category')) {
        $subCategories = Category::whereIn('name', $request->sub_category)->get();
        $subCategoryIds = $subCategories->pluck('category_id')->toArray();
        $query->whereIn('category_id', $subCategoryIds);
    }

    // 💰 Price Range Filter
    if ($request->filled('min_price')) {
        $query->where('price', '>=', $request->min_price);
    }
    if ($request->filled('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }

    // 🔤 Sort by Name
    if ($request->filled('sort_name')) {
        $query->orderBy('name', $request->sort_name === 'az' ? 'asc' : 'desc');
    }

    // 💸 Sort by Price
    if ($request->filled('sort_price')) {
        $query->orderBy('price', $request->sort_price === 'asc' ? 'asc' : 'desc');
    }

    // 🕒 Sort by Date
    if ($request->filled('sort_date')) {
        $query->orderBy('created_at', $request->sort_date === 'newest' ? 'desc' : 'asc');
    }

    // 🔹 Sort by Rating
    if ($request->filled('sort_rating')) {
        // Sort by average rating (join with reviews)
        $query->withAvg('reviews', 'rating') // adds reviews_avg_rating
            ->orderBy('reviews_avg_rating', $request->sort_rating === 'asc' ? 'asc' : 'desc');
    }

    // 🔹 Sort by Sold
    if ($request->filled('sort_sold')) {
        $query->orderBy('sold', $request->sort_sold === 'asc' ? 'asc' : 'desc');
    }

    // Default sort if no sort selected
    if (!$request->filled('sort_name') && !$request->filled('sort_price') && !$request->filled('sort_date')) {
        $query->orderBy('created_at', 'desc'); // newest by default
    }

    // Paginate and keep filters in query string
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

                // Status filter
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status); // 1 = Active, 0 = Inactive
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

        $product = Product::create([
            'name'           => $validated['name'],
            'description'    => $validated['description'] ?? null,
            'price'          => $validated['price'],
            'stock_quantity' => $validated['stock_quantity'],
            'restock_level'  => $validated['restock_level'] ?? null,
            'category_id'    => $validated['subcategory_id'],
            'status'         => $request->input('status') == '1', // ✅ fix
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

        $this->logAdminAction(
            'Created Product',
            'Product',
            $product->product_id,
            "Added new product: {$product->name}"
        );


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
            'status'         => $request->input('status') == '1', // ✅ fix
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

        $this->logAdminAction(
            'Updated Product',
            'Product',
            $product->product_id,
            "Updated product: {$product->name}"
        );

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
        $this->logAdminAction(
            'Deleted Product',
            'Product',
            $product->product_id,
            "Deleted product: {$product->name}"
        );
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

        $this->logAdminAction(
            ucfirst($request->type) . ' Stock',
            'Product',
            $product->product_id,
            ucfirst($request->type) . "ed {$request->quantity} units for {$product->name}"
        );

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


    // Protected helper to log admin actions
    protected function logAdminAction($action, $targetType = null, $targetId = null, $details = null)
    {
        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => $action,
            'target_type' => $targetType,
            'target_id' => $targetId,
            'details' => $details,
            'ip_address' => request()->ip(),
        ]);
    }


}
