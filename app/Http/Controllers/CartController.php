<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{

    /* ===== HALAMAN CART ===== */

    public function index()
    {
        $cart = session()->get('cart', []);
        $isCartChanged = false;

        $total = 0;

        foreach ($cart as $id => &$item) {
            $product = Product::find($item['id']);

            if (!$product) {
                unset($cart[$id]);
                $isCartChanged = true;
                continue;
            }

            $item['stock'] = (int) $product->stock;

            if ($item['stock'] > 0 && $item['qty'] > $item['stock']) {
                $item['qty'] = $item['stock'];
                $isCartChanged = true;
            }

            $total += $item['price'] * $item['qty'];
        }
        unset($item);

        if ($isCartChanged) {
            session()->put('cart', $cart);
        }

        return view('customer.cart', [
            'cartItems' => $cart,
            'total' => $total
        ]);
    }


    /* ===== ADD CART ===== */

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $product = Product::findOrFail($request->product_id);

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            if ($cart[$product->id]['qty'] + 1 > (int) $product->stock) {
                return back()->withErrors([
                    'cart' => 'Stok untuk "' . $product->name . '" tidak mencukupi.',
                ]);
            }

            $cart[$product->id]['qty']++;
        } else {
            if ((int) $product->stock < 1) {
                return back()->withErrors([
                    'cart' => 'Produk "' . $product->name . '" sedang habis.',
                ]);
            }

            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'stock' => (int) $product->stock,
                'qty' => 1,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Produk ditambahkan');
    }

    /* ===== UPDATE QTY ===== */

    public function update(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return back()->withErrors([
                'cart' => 'Produk tidak ditemukan di keranjang.',
            ]);
        }

        $qty = (int) $request->qty;
        $stock = (int) $product->stock;

        if ($qty > $stock) {
            return back()->withErrors([
                'cart' => 'Qty untuk "' . $product->name . '" melebihi stok tersedia (' . $stock . ').',
            ]);
        }

        $cart[$id]['qty'] = $qty;
        $cart[$id]['stock'] = $stock;
        session()->put('cart', $cart);

        return back()->with('success', 'Qty keranjang diperbarui.');
    }


    /* ===== REMOVE ITEM ===== */

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        return back();
    }
}
