<div class="min-h-screen flex items-center justify-center bg-neutral-bg px-4">
    <div class="max-w-md w-full bg-neutral-surface rounded-xl shadow-md p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-primary-600 mb-2">SIPERFLEX</h1>
            <p class="text-neutral-500">Presensi Akurat, Refleksi Bermakna</p>
        </div>

        <form wire:submit="login" class="space-y-6">
            <div>
                <label for="identifier" class="block text-sm font-medium text-neutral-700 mb-1">
                    Email / NIS / NIP / Username
                </label>
                <input 
                    wire:model="identifier" 
                    id="identifier" 
                    type="text" 
                    class="w-full rounded-md border border-neutral-border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500"
                    placeholder="Masukkan identitas Anda"
                    required
                >
                @error('identifier')
                    <p class="text-danger-500 text-sm mt-1">⚠ {{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-neutral-700 mb-1">
                    Kata Sandi
                </label>
                <input 
                    wire:model="password" 
                    id="password" 
                    type="password" 
                    class="w-full rounded-md border border-neutral-border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500"
                    placeholder="••••••••"
                    required
                >
                @error('password')
                    <p class="text-danger-500 text-sm mt-1">⚠ {{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-neutral-surface font-semibold py-2 px-4 rounded-md transition duration-150 ease-in-out">
                Masuk
            </button>
        </form>
    </div>
</div>
