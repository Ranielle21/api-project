<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\File;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::get();
        return view('products.index', compact('product'));
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
            'title' =>'required|max:225|string',
            'price' =>'required|max:255|string',
            'image'=> 'nullable|mimes:png,jpg,jpeg,webp',
            'product_code' =>'required|max:255|string',
            'description' =>'required|max:255|string'
        ]);

        if($request->has('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();

            $filename = time().'.'.$extension;
            $path = 'uploads/product/';
            $file->move($path, $filename);

        }

        Product::create([
            'title' =>$request->title,
            'price' => $request->price,
            'image' =>$path.$filename,
            'product_code'=>$request->product_code,
            'description'=>$request->description,
        ]);

        return redirect()->route('admin/products')->with('success', 'Product added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' =>'required|max:225|string',
            'price' =>'required|max:255|string',
            'image'=> 'nullable|mimes:png,jpg,jpeg,webp',
            'product_code' =>'required|max:255|string',
            'description' =>'required|max:255|string'
        ]);

        $product = Product::findOrFail($id);
        if($request->has('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();

            $filename = time().'.'.$extension;
            $path = 'uploads/product/';
            $file->move($path, $filename);

            if(File::exists($product->image))
            {
                File::delete($product->image);
            }
        }

        $product->update([
            'title' =>$request->title,
            'price' => $request->price,
            'image' =>$path.$filename,
            'product_code'=>$request->product_code,
            'description'=>$request->description,
        ]);

        return redirect()->route('admin/products')->with('status', 'product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        if(File::exists($product->image))
        {
            File::delete($product->image);
        }
        $product->delete();

        return redirect()->route('admin/products')->with('success', 'product deleted successfully');
    }
}
