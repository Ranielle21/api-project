<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function shop()
    {
        $products = Product::all();
        return view('products', compact('products'));
    }

    public function bookCart()
    {
        return view('cart');
    }

    public function addProductsToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart' ,[]);
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "title"=>$product->title,
                "quantity"=> 1,
                "price" => $product->price,
                "image"=>$product->image
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product has been added to cart');
    }

    public function deleteProduct(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product has been deleted');
        }
    }

}