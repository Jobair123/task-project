<?php

namespace App\Http\Controllers;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = Product::query(); 
        if (!empty($search)) {
            $products->where('name', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->orWhere('category', 'LIKE', "%{$search}%");
        }
    
        $products = $products->get();
        return view('products.index', compact('products', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'is_available' => 'boolean',
            'category' =>'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2000',
        ]);

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('uploads', 'public');
    } else {
        $imagePath = null;
    }

     $product = Product::create([
        'name' => $request->name,
        'description' => $request->description,
        'is_available' => $request->is_available,
        'category' => $request->category,
        'image' => $imagePath,

     ]);
 
     return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'is_available' => 'boolean',
            'category' =>'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2000',
        ]);

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('uploads', 'public');
    } else {
        $imagePath = null;
    }
    $product->update([
        'name' => $request->name,
        'description' => $request->description,
        'is_available' => $request->is_available,
        'category' => $request->category,
        'image' => $imagePath,

    ]);
    return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        
    if ($product->image && \Storage::disk('public')->exists($product->image)) {
        \Storage::disk('public')->delete($product->image);
    }

    $product->delete();

    return redirect()->route('products.index');
    }
}
