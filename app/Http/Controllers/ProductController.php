<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session; // Import the Session class
use Illuminate\Http\Request;
use App\Models\Product; // Import the Product model

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('show-items', compact('products'));
    }

    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'item_code' => 'required|string|unique:products',
            'item_name' => 'required|string|unique:products',
            'item_price' => 'required|numeric|between:0.01,999999.99',
            'item_type' => 'required|string',
        ]);

        // Create a new product instance with the validated data
        $product = new Product([
            'item_code' => $validatedData['item_code'],
            'item_name' => $validatedData['item_name'],
            'item_price' => $validatedData['item_price'],
            'item_type' => $validatedData['item_type'],
        ]);

        // Save the product to the database
        $product->save();

        // Set the success message in the session
        Session::flash('success', 'Product added successfully.');

        // Redirect back to the form page with the success message
        return redirect()->back();
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('show-items', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'item_code' => 'required|string',
            'item_name' => 'required|string',
            'item_price' => 'required|numeric',
            'item_type' => 'required|string',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'item_code' => $request->item_code,
            'item_name' => $request->item_name,
            'item_price' => $request->item_price,
            'item_type' => $request->item_type,
        ]);

        return redirect()->route('showitems')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('showitems')->with('success', 'Product deleted successfully!');
    }
}
