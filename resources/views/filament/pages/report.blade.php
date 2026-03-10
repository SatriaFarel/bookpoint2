<x-filament-panels::page>

    @php
        $chartData = $this->getChartData();
        $reports = $this->getPrintReports();
    @endphp

    <style>
        /* ================= PRINT STYLE ================= */

        @media print {

            /* sembunyikan semua elemen */
            body * {
                visibility: hidden;
            }

            /* tampilkan hanya laporan */
            #printArea,
            #printArea * {
                visibility: visible;
            }

            /* posisi laporan */
            #printArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                background: white;
                color: black;
            }

            /* sembunyikan tombol */
            .no-print {
                display: none !important;
            }

            /* matikan dark mode */
            .dark * {
                background: white !important;
                color: black !important;
            }

            /* table style */
            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #ccc;
                padding: 8px;
            }

            thead {
                background: #f3f4f6 !important;
            }

        }

        /* header print default hidden */
        .print-header {
            display: none;
        }

        @media print {
            .print-header {
                display: block;
                text-align: center;
                margin-bottom: 20px;
            }
        }
    </style>


    <div class="space-y-8">


        {{-- FILTER + PRINT --}}
        <div class="flex justify-between no-print">

            <button onclick="window.print()" class="px-4 py-2 bg-green-600 text-white rounded">

                Print Laporan

            </button>

        </div>


        {{-- CHART --}}
        <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border no-print">

            <h3 class="font-bold mb-4">
                Keuntungan Bulanan
            </h3>

            <canvas id="chart"></canvas>

        </div>




        <div class="flex gap-3 mb-4">

            <select wire:model.live="filterMonth" class="border rounded px-3 py-2">
                <option value="">Semua Bulan</option>
                <option value="1">Jan</option>
                <option value="2">Feb</option>
                <option value="3">Mar</option>
                <option value="4">Apr</option>
                <option value="5">Mei</option>
                <option value="6">Jun</option>
                <option value="7">Jul</option>
                <option value="8">Agu</option>
                <option value="9">Sep</option>
                <option value="10">Okt</option>
                <option value="11">Nov</option>
                <option value="12">Des</option>
            </select>

            <select wire:model.live="filterYear" class="border rounded px-3 py-2">
                <option value="">Semua Tahun</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
            </select>

        </div>

        {{-- PRINT AREA --}}
        <div id="printArea">


            {{-- HEADER PRINT --}}
            <div class="print-header">

                <h2 class="text-xl font-bold">
                    Laporan Penjualan
                </h2>

                <p class="text-sm">
                    {{ now()->format('d M Y') }}
                </p>

            </div>

            {{-- TABLE --}}
            <div class="bg-white rounded-xl border overflow-hidden">

                <table class="w-full text-left text-sm" border="1" cellpadding="0" cellspacing="0">

                    <thead class="bg-gray-50 dark:bg-gray-800 uppercase text-xs">

                        <tr>
                            <th class="px-6 py-3">No</th>
                            <th class="px-6 py-3">Order Code</th>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3 text-right">Total</th>
                            <th class="px-6 py-3 text-center">Status</th>
                        </tr>

                    </thead>

                    <tbody>

                        @php
                            $total = 0;
                        @endphp

                        @foreach($reports as $i => $row)

                            @php
                                $total += $row->total_price;
                            @endphp

                            <tr class="dark:bg-gray-800">

                                <td class="px-6 py-3">
                                    {{ $i + 1 }}
                                </td>

                                <td class="px-6 py-3 font-mono">
                                    {{ $row->order_code }}
                                </td>

                                <td class="px-6 py-3">
                                    {{ $row->date }}
                                </td>

                                <td class="px-6 py-3 text-right font-bold">
                                    Rp {{ number_format($row->total_price) }}
                                </td>

                                <td class="px-6 py-3 text-center">
                                    {{ strtoupper($row->status) }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>


                    <tfoot class="bg-gray-100 dark:bg-gray-800 font-bold">

                        <tr>

                            <td colspan="3" class="px-6 py-3 text-right">
                                Total Penjualan
                            </td>

                            <td class="px-6 py-3 text-right text-green-600">
                                Rp {{ number_format($total) }}
                            </td>

                            <td></td>

                        </tr>

                    </tfoot>

                </table>

            </div>

        </div>


    </div>


    {{-- CHART SCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

        document.addEventListener("livewire:navigated", loadChart);

        function loadChart() {

            const rawData = @json($chartData);

            const labels = rawData.map(item => item.month);
            const profits = rawData.map(item => item.profit);

            const ctx = document.getElementById('chart');

            if (!ctx) return;

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Profit',
                        data: profits,
                        backgroundColor: '#10b981'
                    }]
                },
                options: {
                    responsive: true
                }
            });

        }

    </script>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</x-filament-panels::page>