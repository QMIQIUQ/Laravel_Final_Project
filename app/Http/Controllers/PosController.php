<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class PosController extends Controller
{
    public function index()
    {
        $cartItems = session('cartItems', []); // Default to an empty array if the session variable is not set

        return view('pos', compact('cartItems'));
    }

    public function search(Request $request)
    {
        $barcode = $request->input('barcode');
        $item = Product::where('item_code', $barcode)->first();

        if ($item) {

            // Check if the item is already in the cart
            $cartItems = $request->session()->get('cartItems', []);
            $existingItemIndex = $this->findItemInCart($cartItems, $item->id);

            if ($existingItemIndex !== -1) {
                // If the item is already in the cart, update the quantity
                $cartItems[$existingItemIndex]['quantity'] += 1;
            } else {
                // If the item is not in the cart, add it
                $cartItems[] = [
                    'id' => $item->id,
                    'type' => $item->item_type,
                    'name' => $item->item_name,
                    'price' => $item->item_price,
                    'quantity' => 1
                    
                ];
            }

            $request->session()->put('cartItems', $cartItems);
            return redirect()->route('pos');
        } else {
            return redirect()->route('pos')->with('error', 'Item not found.');
        }
    }

    // Helper function to find an item in the cart by its ID
    private function findItemInCart($cartItems, $itemId)
    {
        foreach ($cartItems as $index => $item) {
            if ($item['id'] == $itemId) {
                return $index;
            }
        }
        return -1;
    }



    public function removeFromCart(Request $request, $itemId)
    {
        $cartItems = $request->session()->get('cartItems', []);
        $existingItemIndex = $this->findItemInCart($cartItems, $itemId);
        // dd($cartItems, $itemId, $existingItemIndex);
        if ($existingItemIndex !== -1) {
            // If the item is found in the cart, decrease its quantity
            $cartItems[$existingItemIndex]['quantity']--;

            // If the quantity becomes zero or less, remove the item from the cart
            if ($cartItems[$existingItemIndex]['quantity'] <= 0) {
                array_splice($cartItems, $existingItemIndex, 1);
            }

            $request->session()->put('cartItems', $cartItems);
        }

        return redirect()->route('pos');
    }

    public function clearCart(Request $request)
    {
        $request->session()->forget('cartItems');
        return redirect()->route('pos');
    }


    public function checkout(Request $request)
{
    $cartItems = $request->session()->get('cartItems', []);

    // If the cart is empty, return with an error message
    if (empty($cartItems)) {
        return redirect()->route('pos')->with('error', 'Your cart is empty. Please add items before checking out.');
    }

    // Process the checkout here (e.g., create an order and update inventory)
    // For this demonstration, let's just assume the checkout is successful.

    // Clear the cart after successful checkout
    $request->session()->forget('cartItems');

    // You can redirect to a "Thank You" page or other relevant pages after successful checkout
    return redirect()->route('pos')->with('success', 'Checkout successful! Thank you for your purchase.');
}

}
