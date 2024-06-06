<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class APIProductController extends Controller
{

    public function get()
    {
        $items=Product::all();

        return response()->json($items);
    }

    public function add(Request $request)
    {
        $items = new Product();
        $items->title = $request->title;
        $items->price = $request->price;
        $items->image = $request->image;
        $items->product_code = $request->product_code;
        $items->description = $request->description;

        $items->save();

        return response()->json('Your Product is added Succesfully');
    }

    public function edit(Request $request)
    {
        $items = Product::findOrFail($request->id);

        $items->title = $request->title;
        $items->price = $request->price;
        $items->image = $request->image;
        $items->product_code = $request->product_code;
        $items->description = $request->description;

        $items->update();

        return response()->json('Your Product is updated Succesfully');
    }

    public function delete(Request $request)
    {
        $items = Product::findOrFail($request->id)->delete();

        return response()->json('Your Product is deleted Succesfully');
    }
}