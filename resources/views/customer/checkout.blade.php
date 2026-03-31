@extends('layouts.app1')

@section('content')

    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">

        <div class="max-w-4xl mx-auto p-6 space-y-6">

            <h1 class="text-2xl font-bold text-slate-800">
                Checkout
            </h1>

            @if ($errors->has('checkout'))
                <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                    {{ $errors->first('checkout') }}
                </div>
            @endif


            <form method="POST" action="/customer/checkout">
                @csrf


                {{-- INFO BOX --}}
                <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-xl text-sm text-yellow-800 shadow-sm">

                    <p class="font-semibold mb-1">
                        Informasi Pembayaran
                    </p>

                    <p>
                        Kode Pesanan akan dibuat setelah klik <b>Buat Pesanan</b>.
                        <br>
                        Berikan kode tersebut ke admin untuk melakukan pembayaran.
                    </p>

                </div>


                @foreach($groups as $sellerId => $data)

                    @php $total = 0; @endphp

                    <div
                        class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition space-y-4">

                        <h2 class="font-semibold text-slate-800 text-lg">
                            Seller #{{ $sellerId }}
                        </h2>


                        @foreach($data['items'] as $index => $item)

                            @php
                                $product = $item['product'];
                                $qty = $item['qty'];
                                $subtotal = $product->price * $qty;
                                $total += $subtotal;
                            @endphp


                            <div class="flex justify-between items-center text-sm py-1">

                                <div class="text-slate-700">
                                    {{ $product->name }}
                                    <span class="text-slate-400">x{{ $qty }}</span>
                                </div>

                                <div class="font-medium text-slate-800">
                                    Rp {{ number_format($subtotal) }}
                                </div>

                            </div>


                            <input type="hidden" name="items[{{ $sellerId }}][{{ $index }}][product_id]" value="{{ $product->id }}">
                            <input type="hidden" name="items[{{ $sellerId }}][{{ $index }}][quantity]" value="{{ $qty }}">
                            <input type="hidden" name="items[{{ $sellerId }}][{{ $index }}][price]" value="{{ $product->price }}">

                        @endforeach


                        <div class="border-t pt-3 font-bold flex justify-between text-lg">

                            <span>Total</span>

                            <span class="text-blue-600">
                                Rp {{ number_format($total) }}
                            </span>

                        </div>


                        <input type="hidden" name="seller_id[]" value="{{ $sellerId }}">

                    </div>

                @endforeach


                {{-- BUTTON --}}
                <button class="w-full bg-slate-900 hover:bg-blue-600 transition
    text-white py-3 rounded-xl text-lg font-semibold shadow hover:shadow-lg">

                    Buat Pesanan

                </button>

            </form>

        </div>

    </div>

@endsection
