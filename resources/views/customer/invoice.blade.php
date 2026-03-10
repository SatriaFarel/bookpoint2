<!DOCTYPE html>
<html>

<head>

    <title>Struk</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: monospace;
        }

        @media print {

            button {
                display: none;
            }

            body {
                background: white;
            }

        }
    </style>

</head>

<body class="bg-gray-100 flex justify-center p-6">

    <div class="bg-white w-[320px] p-6 border">


        {{-- HEADER --}}
        <div class="text-center">

            <h2 class="font-bold text-lg">
                BOOKSTORE
            </h2>

            <p class="text-xs">
                {{ $order->order_code }}
            </p>

            <p class="text-xs">
                {{ $order->created_at->format('d M Y H:i') }}
            </p>

        </div>


        <hr class="my-3">


        {{-- CUSTOMER --}}
        <div class="text-xs space-y-1">

            <p>
                Seller : {{ $order->seller->name }}
            </p>

            <p>
                Customer : {{ $order->customer->name }}
            </p>

        </div>


        <hr class="my-3">


        {{-- ITEMS --}}
        <div class="space-y-2 text-sm">

            @foreach($order->items as $item)

                <div>

                    <div class="flex justify-between">

                        <span>
                            {{ $item->product->name }}
                        </span>

                        <span>
                            Rp {{ number_format($item->price) }}
                        </span>

                    </div>

                    <div class="flex justify-between text-xs text-gray-500">

                        <span>
                            x{{ $item->quantity }}
                        </span>

                        <span>
                            Rp {{ number_format($item->price * $item->quantity) }}
                        </span>

                    </div>

                </div>

            @endforeach

        </div>


        <hr class="my-3">


        {{-- TOTAL --}}
        <div class="text-sm space-y-1">

            <div class="flex justify-between">

                <span>Total</span>

                <span class="font-bold">
                    Rp {{ number_format($order->total_price) }}
                </span>

            </div>

            @if($order->payment_method)

                <div class="flex justify-between text-xs">

                    <span>Payment</span>

                    <span>
                        {{ strtoupper($order->payment_method) }}
                    </span>

                </div>

            @endif

        </div>


        <hr class="my-3">


        {{-- FOOTER --}}
        <div class="text-center text-xs">

            <p>
                Terima kasih
            </p>

            <p>
                BookStore
            </p>

        </div>


        {{-- PRINT BUTTON --}}
        <div class="text-center mt-4">

            <button onclick="window.print()" class="px-4 py-2 border rounded">

                Print

            </button>

        </div>


    </div>

</body>

</html>