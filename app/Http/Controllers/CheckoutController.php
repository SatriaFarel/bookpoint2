<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{

    /* ===== HALAMAN CHECKOUT ===== */

    public function index()
    {
        $cart = session()->get('cart', []);

        if (!$cart) {
            return redirect('/customer/cart');
        }

        $groups = [];

        foreach ($cart as $item) {

            $product = Product::with('seller')->find($item['id']);

            if (!$product) continue;

            $sellerId = $product->seller_id;

            $groups[$sellerId]['seller'] = $product->seller;

            $groups[$sellerId]['items'][] = [
                'product' => $product,
                'qty' => $item['qty']
            ];
        }

        return view('customer.checkout', [
            'groups' => $groups
        ]);
    }


    /* ===== BUAT ORDER ===== */

    public function store(Request $request)
    {
        
        $createdOrders = [];

        foreach ($request->seller_id as $sellerId) {

            $total = 0;

            foreach ($request->items[$sellerId] as $item) {
                $total += $item['quantity'] * $item['price'];
            
            }

            $orderCode = 'ORD-' . strtoupper(Str::random(6));

            $order = Order::create([
                'order_code' => $orderCode,
                'customer_id' => Auth::id(),
                'seller_id' => $sellerId,
                'total_price' => $total,
                'status' => 'pending'
            ]);

            foreach ($request->items[$sellerId] as $item) {

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            }

            $createdOrders[] = $orderCode;
        }

        session()->forget('cart');

        return redirect('/customer/transactions')
            ->with('success', 'Pesanan dibuat. Kode pesanan: ' . implode(', ', $createdOrders));
    }

}