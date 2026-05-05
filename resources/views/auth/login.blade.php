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

        <div>
            <label for="password" class="block text-sm font-semibold text-slate-900 mb-2">Password</label>
            <input id="password" type="password" name="password"
                class="w-full px-4 py-3.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-slate-900 focus:border-slate-900 transition-colors placeholder:text-slate-400"
                placeholder="Masukkan password anda" required autocomplete="new-password">
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