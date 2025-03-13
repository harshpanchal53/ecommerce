<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    public function index() {
        return view('products.index', ['products' => Product::all()]);
    }



public function create()
{
    $categories = Category::all();
    return view('products.create', compact('categories'));
}

public function shop()
{
    $products = Product::all();
    return view('shop', compact('products'));
}


public function store(StoreProductRequest $request)
{
    $validatedData = $request->validated();

    if ($request->hasFile('image')) {
        $extension = $request->file('image')->getClientOriginalExtension();
        $uniqueName = Str::random(10) . '_' . time() . '.' . $extension;
        $imagePath = $request->file('image')->storeAs('products', $uniqueName, 'public');
        $validatedData['image'] = 'storage/' . $imagePath; // Store correct path
    }
    Product::create($validatedData);

    return redirect()->route('products.index')->with('success', 'Product added successfully!');
}
public function edit(Product $product)
{
    $categories = Category::all();
    return view('products.edit', compact('product', 'categories'));
}

public function update(Request $request, Product $product)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'description' => 'nullable|string',
        'stock' => 'required|integer',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    if ($request->hasFile('image')) {
        // Store new image
        $extension = $request->file('image')->getClientOriginalExtension();
        $uniqueName = Str::random(10) . '_' . time() . '.' . $extension;
        $imagePath = $request->file('image')->storeAs('products', $uniqueName, 'public');
        $validatedData['image'] = 'storage/' . $imagePath;
    }

    $product->update($validatedData);

    return redirect()->route('products.index')->with('success', 'Product updated successfully.');
}
    public function destroy(Product $product) {
        $product->delete();
        return redirect()->route('products.index');
    }
}
