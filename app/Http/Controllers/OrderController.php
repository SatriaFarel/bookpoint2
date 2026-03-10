<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    /* ================= HISTORY CUSTOMER ================= */

    public function buyerHistory()
    {
        $orders = Order::with('items.product')
            ->where('customer_id', Auth::id())
            ->latest()
            ->get();

        return view('customer.transaction', [
            'orders' => $orders
        ]);
    }


    /* ================= INVOICE ================= */

    public function invoice($id)
    {
        $order = Order::with([
            'items.product',
            'customer',
            'seller'
        ])->findOrFail($id);

        return view('customer.invoice', compact('order'));
    }

}
