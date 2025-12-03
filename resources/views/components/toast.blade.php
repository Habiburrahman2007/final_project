@if (session()->has('success') ||
        session()->has('error') ||
        session()->has('article_created') ||
        session()->has('article_updated') ||
        session()->has('profile_updated') ||
        session()->has('category_created'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
        x-transition:enter="transform ease-out duration-300 transition"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed top-4 right-4 z-50 max-w-sm w-full" role="alert"
        aria-live="assertive" aria-atomic="true">
        <div
            class="flex items-center p-4 rounded-lg shadow-lg {{ session('error') ? 'bg-red-600' : 'bg-green-600' }} text-white">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg">
                @if (session('error'))
                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                @else
                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                @endif
            </div>
            <div class="ml-3 text-sm font-medium">
                @if (session('error'))
                    {{ session('error') }}
                @elseif(session('success'))
                    {{ session('success') }}
                @elseif(session('article_created'))
                    ✅ Artikel berhasil dibuat!
                @elseif(session('article_updated'))
                    ✅ Artikel berhasil diperbarui!
                @elseif(session('profile_updated'))
                    ✅ Profil berhasil diperbarui!
                @elseif(session('category_created'))
                    ✅ Kategori berhasil dibuat!
                @endif
            </div>
            <button @click="show = false" type="button"
                class="ml-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 hover:bg-white/20 inline-flex h-8 w-8 focus:outline-none focus:ring-2 focus:ring-white"
                aria-label="Tutup notifikasi">
                <span class="sr-only">Tutup</span>
                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
@endif
