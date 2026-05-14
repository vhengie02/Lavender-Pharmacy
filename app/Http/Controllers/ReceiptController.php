<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceiptController extends Controller
{
    /**
     * Show receipt
     */
    public function show(Receipt $receipt)
    {
        $receipt->load('order.items');
        $this->authorize('view', $receipt->order);
        return view('customer.receipt', ['receipt' => $receipt]);
    }

    /**
     * Download receipt as PDF
     */
    public function download(Receipt $receipt)
    {
        $this->authorize('view', $receipt->order);
        return response()->download(storage_path("app/receipts/{$receipt->invoice_number}.pdf"));
    }
}
