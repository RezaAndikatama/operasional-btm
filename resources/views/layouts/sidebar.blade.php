<aside class="w-64 bg-white border-r border-slate-100 flex flex-col h-screen flex-shrink-0 z-20">

    <header class="h-20 flex items-center px-6 border-b border-slate-50">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 w-full group">
            <img src="{{ asset('images/logo-btm.png') }}"
                alt="Logo PT Briliant Teknik Mandiri"
                class="h-10 w-auto object-contain group-hover:scale-105 transition-transform duration-300">
            <span class="font-bold text-slate-800 text-sm tracking-wide leading-tight">
                Briliant Teknik <br> Mandiri
            </span>
        </a>
    </header>

    <nav class="flex-1 px-4 py-6 space-y-8 overflow-y-auto scrollbar-hide">

        <div>
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 mb-2 rounded-xl text-sm font-medium transition-all duration-200    {{ request()->routeIs('dashboard') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="w-5 h-5 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="font-semibold text-sm">Dashboard</span>
            </a>
        </div>

        @hasanyrole('admin|Admin|manajer|Manajer|teknisi|Teknisi|karyawan|Karyawan')
        <div>
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 px-4">Operasional</p>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('work_orders.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all group {{ request()->routeIs('work_orders.*') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">

                        <svg class="w-5 h-5 transition-colors {{ request()->routeIs('work_orders.*') ? 'text-white' : 'group-hover:text-slate-900' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>

                        <span class="font-medium text-sm">Transaksi</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('spareparts.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all group {{ request()->routeIs('spareparts.index') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">

                        <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ request()->routeIs('spareparts.index') ? 'text-white' : 'group-hover:text-slate-900' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                        </svg>

                        <span class="font-medium text-sm">Inventory</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('spareparts.history') }}"
                        class="{{ request()->routeIs('spareparts.history', 'spareparts.create', 'spareparts.edit') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all group">

                        <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ request()->routeIs('spareparts.history') ? 'text-white' : 'group-hover:text-slate-900' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>

                        <span class="font-medium text-sm">Riwayat</span>
                    </a>
                </li>
            </ul>
        </div>
        @endhasanyrole

        @hasanyrole('admin|Admin|manajer|Manajer')
        <div>
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 px-4">Master Data</p>
            <ul class="space-y-1">

                {{-- PEMBATASAN AKSES: Kelola User & Data Karyawan HANYA bisa diakses oleh Manajer --}}
                @hasanyrole('manajer|Manajer')
                <li>
                    <a href="{{ route('users.index') }}"
                        class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('users.*') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span class="font-medium text-sm">Kelola User</span>
                    </a>
                </li>
                @endhasanyrole

                <li>
                    <a href="{{ route('technicians.index') }}"
                        class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('technicians.*') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.014a4.514 4.514 0 00-1.423-5.666 4.5 4.5 0 00-5.666-1.423 4.514 4.514 0 00.014 1.743m-2.122 5.093l-1.028-1.028M15.12 10.12l-1.028-1.028M10.875 14.25l1.03-1.03M12.75 12l1.03-1.03M14.625 9.75l1.03-1.03M16.5 7.5l1.03-1.03"></path>
                        </svg>
                        <span class="font-medium text-sm">Data Karyawan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('customers.index')}}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all group {{ request()->routeIs('customers.*') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">

                        <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ request()->routeIs('customers.*') ? 'text-white' : 'group-hover:text-slate-900' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"></path>
                        </svg>

                        <span class="font-medium text-sm">Data Pelanggan</span>
                    </a>
                </li>
            </ul>
        </div>
        @endhasanyrole
    </nav>

    <div class="p-4 border-t border-slate-50 bg-slate-50/50">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-2.5 text-red-500 bg-red-50 rounded-xl hover:bg-red-100 hover:text-red-600 transition-colors font-semibold text-sm">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Log Out
            </button>
        </form>
    </div>
</aside>