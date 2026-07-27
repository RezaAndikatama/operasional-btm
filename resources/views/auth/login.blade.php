<x-guest-layout>

    <div class="mb-10">
        <h2 class="text-3xl font-bold text-slate-900 mb-2 tracking-tight">Selamat Datang!</h2>
        <p class="text-slate-500">Silakan login untuk masuk kehalaman Dashboard.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6" autocomplete="off">
        @csrf

        <div>
            <label for="email" class="block text-sm font-semibold text-slate-900 mb-2">Email</label>
            <input id="email" type="email" name="email"
                class="w-full px-4 py-3.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-slate-900 focus:border-slate-900 transition-colors placeholder:text-slate-400"
                placeholder="Masukkan email anda" required autofocus autocomplete="new-email">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs font-medium" />
        </div>

        <div x-data="{ show: false }">
            <label for="password" class="block text-sm font-semibold text-slate-900 mb-2">Password</label>
            <div class="relative">
                <input id="password" :type="show ? 'text' : 'password'" name="password"
                    class="w-full px-4 py-3.5 pr-12 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-slate-900 focus:border-slate-900 transition-colors placeholder:text-slate-400"
                    placeholder="Masukkan password anda" required autocomplete="new-password">

                <button type="button" @click="show = !show" class="absolute top-1/2 right-2 -translate-y-1/2 p-2 flex items-center justify-center text-slate-400 hover:text-slate-900 focus:outline-none transition-colors rounded-lg">
                    {{-- Ikon Mata Terbuka --}}
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    {{-- Ikon Mata Tertutup --}}
                    <svg x-show="show" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.29 3.29m0 0a10.05 10.05 0 015.188-1.583c4.477 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs font-medium" />
        </div>

        <div class="flex items-center justify-between pt-2">
            <label for="remember_me" class="flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-slate-900 shadow-sm focus:ring-slate-900" name="remember">
                <span class="ml-2 text-sm text-slate-600 group-hover:text-slate-900 transition-colors">Remember Me</span>
            </label>

            @if (Route::has('password.request'))
            <a class="text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors" href="{{ route('password.request') }}">
                Forgot Password?
            </a>
            @endif
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full py-4 px-4 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl shadow-lg shadow-slate-900/20 transition-all transform active:scale-[0.98]">
                Login
            </button>
        </div>
    </form>
</x-guest-layout>