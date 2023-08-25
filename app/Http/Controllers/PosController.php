<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\DB;

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
    
        // Calculate the total price
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
    
        // Process the checkout here (e.g., create an order and update inventory)
    
        // Start a database transaction to ensure data consistency
        DB::beginTransaction();
    
        try {
            // Create a new order record in the database
            $order = DB::table('orders')->insertGetId([
                'user_id' => auth()->user()->id, // Assuming you have user authentication and each order is associated with a user
                'total_price' => $totalPrice,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            // Store the order items in the 'order_items' table
            foreach ($cartItems as $item) {
                DB::table('order_items')->insert([
                    'order_id' => $order,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
    
            // Commit the transaction since everything succeeded
            DB::commit();
    
            // Clear the cart after successful checkout
            $request->session()->forget('cartItems');
    
            // Check if cash payment method was selected
            $cashRadioChecked = $request->input('payment_method') === 'cash';
    
            if ($cashRadioChecked) {
                $cashAmount = floatval($request->input('cash_amount'));
                $change = $cashAmount - $totalPrice;
                $successMessage = $change > 0
                    ? 'Checkout successful! Thank you for your purchase. Your change: ' . number_format($change, 2)
                    : 'Checkout successful! Thank you for your purchase.';
                return redirect()->route('pos')->with('success', $successMessage);
            } else {
                return redirect()->route('pos')->with('success', 'Checkout successful! Thank you for your purchase.');
            }
        } catch (Exception $e) {
            // If there is an error, rollback the transaction to maintain data consistency
            DB::rollback();
    
            // Log the specific exception
            Log::error($e->getMessage());
    
            // Handle the error or display a message to the user
            return redirect()->route('pos')->with('error', 'An error occurred during checkout. Please try again later.');
        }
    }
}
