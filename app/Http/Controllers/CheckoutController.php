<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
        $request->validate([
            'seller_id' => 'required|array|min:1',
            'seller_id.*' => 'required|integer',
            'items' => 'required|array',
        ]);

        $createdOrders = [];
        $customerId = Auth::guard('customer')->id();

        DB::transaction(function () use ($request, &$createdOrders, $customerId) {
            foreach ($request->seller_id as $sellerId) {
                if (!isset($request->items[$sellerId]) || !is_array($request->items[$sellerId])) {
                    throw ValidationException::withMessages([
                        'checkout' => 'Data item checkout tidak valid.',
                    ]);
                }

                $total = 0;
                $validatedItems = [];

                foreach ($request->items[$sellerId] as $item) {
                    $product = Product::find($item['product_id']);

                    if (!$product) {
                        throw ValidationException::withMessages([
                            'checkout' => 'Produk tidak ditemukan.',
                        ]);
                    }

                    $qty = (int) $item['quantity'];
                    if ($qty < 1) {
                        throw ValidationException::withMessages([
                            'checkout' => 'Qty produk tidak valid.',
                        ]);
                    }

                    if ($qty > (int) $product->stock) {
                        throw ValidationException::withMessages([
                            'checkout' => 'Qty untuk "' . $product->name . '" melebihi stok tersedia (' . $product->stock . ').',
                        ]);
                    }

                    $linePrice = (int) $product->price;
                    $subtotal = $qty * $linePrice;

                    $validatedItems[] = [
                        'product' => $product,
                        'quantity' => $qty,
                        'price' => $linePrice,
                    ];

                    $total += $subtotal;
                }

                $order = Order::create([
                    'customer_id' => $customerId,
                    'seller_id' => $sellerId,
                    'total_price' => $total,
                    'status' => 'pending',
                ]);

                foreach ($validatedItems as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product']->id,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);

                    $item['product']->decrement('stock', $item['quantity']);
                }

                $createdOrders[] = $order->order_code;
            }
        });

        session()->forget('cart');

        return redirect('/customer/checkout/result')
            ->with('checkout_success', true)
            ->with('created_order_codes', $createdOrders);
    }

    public function result()
    {
        if (!session('checkout_success')) {
            return redirect('/customer/dashboard');
        }

        return view('customer.checkout-result', [
            'orderCodes' => session('created_order_codes', []),
        ]);
    }
}
