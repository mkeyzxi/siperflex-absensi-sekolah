<div class="min-h-screen flex bg-neutral-surface md:bg-neutral-bg">
    <!-- Kolom Kiri: Branding / Logo (Tersembunyi di mobile, muncul di iPad/Desktop) -->
    <div
        class="hidden md:flex md:w-1/2 lg:w-3/5 bg-gradient-to-br from-primary-50 via-white to-primary-100 flex-col justify-center items-center p-12 relative overflow-hidden">
        <!-- Desain tipis tipis (Subtle decorative shapes) -->
        <div
            class="absolute top-0 left-0 w-72 h-72 bg-primary-200 rounded-full mix-blend-multiply filter blur-3xl opacity-40 transform -translate-x-1/2 -translate-y-1/2">
        </div>
        <div
            class="absolute bottom-0 right-0 w-96 h-96 bg-info-200 rounded-full mix-blend-multiply filter blur-3xl opacity-40 transform translate-x-1/3 translate-y-1/3">
        </div>
        <div
            class="absolute top-1/2 right-1/4 w-64 h-64 bg-success-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 transform -translate-y-1/2">
        </div>

        <div class="relative z-10 text-center max-w-lg">
            <img src="{{ asset('logo-login.png') }}" alt="Logo SIPERFLEX"
                class="mx-auto w-full max-w-[280px] lg:max-w-[360px] h-auto drop-shadow-xl mb-10 transition-transform duration-500 hover:scale-105">
            <h2 class="text-3xl lg:text-4xl font-bold text-primary-900 mb-4 tracking-tight">Selamat Datang di SIPERFLEX
            </h2>
            <p class="text-primary-700 text-lg leading-relaxed">Platform presensi sekolah modern dengan pendekatan
                reflektif. Wujudkan presensi akurat dan refleksi bermakna untuk ekosistem pendidikan yang lebih baik.
            </p>
        </div>
    </div>

    <!-- Kolom Kanan: Form Login -->
    <div
        class="w-full md:w-1/2 lg:w-2/5 flex items-center justify-center p-6 sm:p-12 bg-white md:shadow-[-20px_0_40px_-15px_rgba(0,0,0,0.05)] z-10 relative">
        <div class="w-full max-w-md space-y-8">
            <div class="text-center md:text-left mb-8 md:mb-10">
                <!-- Logo hanya muncul di mobile -->
                <img src="{{ asset('logo-login.webp') }}" alt="Logo SIPERFLEX"
                    class="md:hidden mx-auto w-[200px] h-auto mb-8">

                <h1 class="text-3xl md:text-4xl font-extrabold text-neutral-900 mb-3 tracking-tight">Masuk</h1>
                <p class="text-neutral-500 text-sm md:text-base">Silakan masuk menggunakan kredensial Anda untuk
                    melanjutkan ke dasbor.</p>
            </div>

            <form wire:submit="login" class="space-y-6">
                <div>
                    <label for="identifier" class="block text-sm font-semibold text-neutral-700 mb-2">
                        Email / NIS / NIP
                    </label>
                    <input wire:model="identifier" id="identifier" type="text"
                        class="w-full rounded-xl border border-neutral-300 px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors shadow-sm bg-neutral-50 focus:bg-white"
                        placeholder="Masukkan identitas Anda" required>
                    @error('identifier')
                        <p class="text-danger-500 text-sm mt-2 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-neutral-700 mb-2">
                        Kata Sandi
                    </label>
                    <input wire:model="password" id="password" type="password"
                        class="w-full rounded-xl border border-neutral-300 px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors shadow-sm bg-neutral-50 focus:bg-white"
                        placeholder="••••••••" required>
                    @error('password')
                        <p class="text-danger-500 text-sm mt-2 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3.5 px-4 rounded-xl shadow-md hover:shadow-lg hover:shadow-primary-500/30 transition-all duration-200 transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
                    Masuk ke Sistem
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L6.414 9H17a1 1 0 110 2H6.414l4.293 4.293a1 1 0 01-1.414 1.414l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 0z"
                            clip-rule="evenodd" transform="rotate(180 10 10)" />
                    </svg>
                </button>
            </form>

            <div
                class="mt-12 pt-6 border-t border-neutral-100 text-center md:text-left flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-neutral-400">
                <p>
                    &copy; {{ date('Y') }} SIPERFLEX.
                </p>
                <p>
                    Presensi Akurat, Refleksi Bermakna
                </p>
            </div>
        </div>
    </div>
</div>
