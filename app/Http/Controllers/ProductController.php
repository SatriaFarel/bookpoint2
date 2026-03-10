<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /* ================= STORE PAGE ================= */

    public function index(Request $request)
    {
        $query = Product::query();

        // SEARCH
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $books = $query->latest()->get();

        // cart count (session)
        $cart = session()->get('cart', []);
        $cartCount = count($cart);

        return view('customer.dashboard', [
            'books' => $books,
            'cartCount' => $cartCount
        ]);
    }


    /* ================= ADD TO CART ================= */

    public function addToCart(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id'
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->book_id])) {

            $cart[$request->book_id]['qty']++;

        } else {

            $book = Product::findOrFail($request->book_id);

            $cart[$request->book_id] = [
                'name' => $book->name,
                'price' => $book->price,
                'image' => $book->image,
                'qty' => 1
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success','Berhasil ditambahkan ke keranjang');
    }
}