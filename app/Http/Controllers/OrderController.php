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
            ->where('customer_id', Auth::guard('customer')->id())
            ->latest()
            ->get();

        return view('customer.transaction', [
            'orders' => $orders
        ]);
    }


    /* ================= INVOICE ================= */

    public function invoice(Request $request, $id)
    {
        $order = Order::with([
            'items.product',
            'customer',
            'seller'
        ])->findOrFail($id);

        $isCustomerInvoice = $request->routeIs('customer.invoice');

        if ($isCustomerInvoice && $order->customer_id !== Auth::guard('customer')->id()) {
            abort(403);
        }

        return view('customer.invoice', [
            'order' => $order,
            'backUrl' => $isCustomerInvoice ? '/customer/transactions' : '/admin/orders',
            'backLabel' => $isCustomerInvoice ? 'Kembali ke Transaksi' : 'Kembali ke Order',
            'invoiceTitle' => $isCustomerInvoice ? 'Invoice Transaksi' : 'Invoice Order Admin',
        ]);
    }

}
