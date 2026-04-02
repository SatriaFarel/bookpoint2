@extends('layouts.app1')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-950 py-8 px-4">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm p-6">
            <div class="flex items-center justify-between gap-3 mb-4">
                <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100">Scan Order Code</h1>
                <a href="/admin/orders" class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition text-sm">
                    Kembali ke Orders
                </a>
            </div>

            <p class="text-slate-600 dark:text-slate-300 text-sm mb-4">
                Arahkan kamera ke QR order customer. Setelah terbaca, kamu akan otomatis diarahkan ke halaman Orders dengan hasil pencarian order code.
            </p>

            <div id="reader" class="w-full max-w-md mx-auto border border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden"></div>

            <div id="scan-status" class="mt-4 text-center text-sm text-slate-500 dark:text-slate-400">
                Menunggu izin kamera...
            </div>

            <div class="mt-5 border-t border-slate-200 dark:border-slate-700 pt-4">
                <label for="manualCode" class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-2">Atau input kode manual</label>
                <div class="flex gap-2">
                    <input id="manualCode" type="text" placeholder="Contoh: ORD-ABC123"
                           class="flex-1 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-500">
                    <button id="manualBtn" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition text-sm">
                        Cari
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    const statusEl = document.getElementById('scan-status');
    const manualCodeEl = document.getElementById('manualCode');
    const manualBtnEl = document.getElementById('manualBtn');

    const goToOrders = (code) => {
        const cleaned = (code || '').trim();

        if (!cleaned) {
            statusEl.textContent = 'Kode order kosong.';
            statusEl.className = 'mt-4 text-center text-sm text-red-600 dark:text-red-400';
            return;
        }

        window.location.href = '/admin/orders?tableSearch=' + encodeURIComponent(cleaned);
    };

    manualBtnEl.addEventListener('click', () => {
        goToOrders(manualCodeEl.value);
    });

    manualCodeEl.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            event.preventDefault();
            goToOrders(manualCodeEl.value);
        }
    });

    const qrReader = new Html5Qrcode('reader');

    Html5Qrcode.getCameras()
        .then((devices) => {
            if (!devices || devices.length === 0) {
                throw new Error('Kamera tidak ditemukan.');
            }

            const backCam = devices.find((d) => /back|rear|environment/i.test(d.label)) || devices[0];
            statusEl.textContent = 'Kamera aktif. Silakan scan QR order.';

            qrReader.start(
                backCam.id,
                { fps: 10, qrbox: { width: 220, height: 220 } },
                (decodedText) => {
                    statusEl.textContent = 'QR terdeteksi: ' + decodedText;
                    qrReader.stop().finally(() => goToOrders(decodedText));
                },
                () => {}
            ).catch((err) => {
                statusEl.textContent = 'Gagal mulai kamera: ' + err;
                statusEl.className = 'mt-4 text-center text-sm text-red-600 dark:text-red-400';
            });
        })
        .catch((err) => {
            statusEl.textContent = 'Tidak bisa mengakses kamera: ' + err;
            statusEl.className = 'mt-4 text-center text-sm text-red-600 dark:text-red-400';
        });
</script>
@endsection
