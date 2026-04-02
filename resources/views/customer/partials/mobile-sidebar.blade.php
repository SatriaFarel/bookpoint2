@php
    $active = $active ?? '';
    $menuId = 'customer-mobile-menu';
    $panelId = $menuId . '-panel';
    $overlayId = $menuId . '-overlay';
    $openBtnId = $menuId . '-open';
    $closeBtnId = $menuId . '-close';

    $linkClass = static function (string $key) use ($active): string {
        $isActive = $active === $key;

        if ($isActive) {
            return 'flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100';
        }

        return 'flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100 transition';
    };
@endphp

<div class="md:hidden">
    <button id="{{ $openBtnId }}"
           type="button"
           class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 transition cursor-pointer"
           aria-label="Buka menu navigasi">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7h16M4 12h16M4 17h16" />
        </svg>
    </button>

    <div id="{{ $overlayId }}" class="fixed inset-0 z-40 hidden">
        <button type="button" class="absolute inset-0 bg-slate-900/50 cursor-pointer" aria-label="Tutup menu"></button>

        <aside id="{{ $panelId }}" class="absolute right-0 top-0 h-full w-72 bg-white shadow-2xl border-l border-slate-200 p-5 flex flex-col">
            <div class="flex items-center justify-between mb-6">
                <p class="text-base font-bold text-slate-800">Navigasi</p>

                <button id="{{ $closeBtnId }}"
                       type="button"
                       class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-100 transition cursor-pointer"
                       aria-label="Tutup menu navigasi">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="space-y-2">
                <a href="/customer/dashboard" class="{{ $linkClass('store') }}">
                    <span>Store</span>
                </a>

                <a href="/customer/transactions" class="{{ $linkClass('history') }}">
                    <span>History</span>
                </a>

                <a href="/customer/cart" class="{{ $linkClass('cart') }}">
                    <span>Keranjang</span>
                </a>

                <a href="/customer/about" class="{{ $linkClass('about') }}">
                    <span>About Us</span>
                </a>

                <a href="{{ route('customer.profile.edit') }}" class="{{ $linkClass('profile') }}">
                    <span>Profil</span>
                </a>
            </nav>

            <div class="mt-auto pt-5 border-t border-slate-200">
                <form method="POST" action="/auth/logout">
                    @csrf
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-rose-50 text-rose-600 border border-rose-100 font-semibold hover:bg-rose-100 transition">
                        Logout
                    </button>
                </form>
            </div>
        </aside>
    </div>
</div>

<script>
    (() => {
        const openBtn = document.getElementById(@js($openBtnId));
        const closeBtn = document.getElementById(@js($closeBtnId));
        const overlay = document.getElementById(@js($overlayId));
        const panel = document.getElementById(@js($panelId));

        if (!openBtn || !closeBtn || !overlay || !panel) {
            return;
        }

        const closeMenu = () => {
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        };

        const openMenu = () => {
            overlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        };

        openBtn.addEventListener('click', openMenu);
        closeBtn.addEventListener('click', closeMenu);
        overlay.addEventListener('click', (event) => {
            if (!panel.contains(event.target)) {
                closeMenu();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeMenu();
            }
        });
    })();
</script>
