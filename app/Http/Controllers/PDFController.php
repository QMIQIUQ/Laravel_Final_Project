<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\Order; // Make sure to import the Order model

class PDFController extends Controller
{
    public function generatePDF($order_id)
    {
        // Retrieve the order object using the provided ID
        $order = Order::find($order_id);

        if (!$order) {
            return abort(404); // Handle the case when the order is not found
        }

        $pdf = PDF::loadView('pdf.receipt', compact('order'));
        return $pdf->download('order_receipt.pdf');
    }
}
