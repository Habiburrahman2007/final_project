<div class="flex w-full max-w-2xl bg-gray-800/50 backdrop-blur-md rounded-xl shadow-lg overflow-hidden my-5 mx-auto">
    <div class="w-full p-6">
        <div class="text-center mb-5">
            <img src="{{ asset('img/logo_fp-removebg-preview.png') }}" alt="Logo" class="mx-auto h-20 w-auto" />
            <h2 class="mt-3 text-2xl font-bold text-white">Silahkan daftarkan akun Anda</h2>
        </div>

        <form wire:submit.prevent="register" class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Kolom kiri -->
            <div class="space-y-5">
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-200">Email</label>
                    <input type="email" id="email" wire:model="email"
                        class="w-full p-2.5 rounded-lg bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required />
                    <small class="text-gray-400">Contoh: fulan@gmail.com</small>
                </div>

                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-200">Username</label>
                    <input type="text" id="name" wire:model="name"
                        class="w-full p-2.5 rounded-lg bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required />
                </div>

                <div>
                    <label for="profession" class="block mb-2 text-sm font-medium text-gray-200">Profesi</label>
                    <input type="text" id="profession" wire:model="profession"
                        class="w-full p-2.5 rounded-lg bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required />
                </div>
            </div>

            <!-- Kolom kanan -->
            <div class="space-y-5">
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-200">Kata sandi</label>
                    <div class="relative">
                        <input id="password" type="password" wire:model="password"
                            class="w-full p-2.5 pr-12 rounded-lg bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required />
                        <small class="text-gray-400">Kata sandi tidak boleh kurang dari 8 karakter</small>
                        <button type="button" id="togglePassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-300 bg-transparent">
                            <i class="fa-solid fa-eye mb-7" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-200">Konfirmasi kata
                        sandi</label>
                    <div class="relative">
                        <input id="confirm-password" type="password" wire:model="password_confirmation"
                            class="w-full p-2.5 pr-12 rounded-lg bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required />
                        <button type="button" id="toggleConfirmPassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-300 bg-transparent">
                            <i class="fa-solid fa-eye" id="eyeIconConfirm"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="sm:col-span-2 flex justify-center">
                <button type="submit" wire:click="register"
                    class="overflow-hidden w-32 h-10 bg-blue-700 text-white border-none rounded-md text-xl font-bold cursor-pointer relative flex justify-center items-center group"
                    wire:loading.attr="disabled">

                    {{-- Text normal --}}
                    <span class="relative z-10 transition-opacity duration-300 group-hover:opacity-0"
                        wire:loading.remove wire:target="register">
                        Daftar
                    </span>

                    {{-- Hover text --}}
                    <span class="absolute z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                        wire:loading.remove wire:target="register">
                        Tekan aku
                    </span>

                    {{-- SPINNER --}}
                    <span class="absolute z-10" wire:loading wire:target="register">
                        <i class="fa-solid fa-spinner fa-spin text-lg"></i>
                    </span>

                    {{-- Background animation --}}
                    <span
                        class="absolute w-36 h-32 -top-8 -left-2 bg-white rotate-12 transform scale-x-0 group-hover:scale-x-100 transition-transform group-hover:duration-500 duration-1000 origin-left z-0"></span>
                    <span
                        class="absolute w-36 h-32 -top-8 -left-2 bg-blue-400 rotate-12 transform scale-x-0 group-hover:scale-x-100 transition-transform group-hover:duration-700 duration-700 origin-left z-0"></span>
                    <span
                        class="absolute w-36 h-32 -top-8 -left-2 bg-blue-600 rotate-x-0 transform scale-x-0 group-hover:scale-x-100 transition-transform group-hover:duration-1000 duration-500 origin-left z-0"></span>
                </button>

            </div>
        </form>

        <div class="flex justify-center items-center mt-6 text-sm text-gray-400">
            <p class="text-center text-gray-400 text-sm">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:text-blue-500">Masuk
                    disini</a> dan silahkan hubungi <a href="https://wa.link/zjo1b2" target="blank"
                    class="text-blue-600 font-semibold hover:text-blue-500">admin</a> jika punya pertanyaan.
            </p>
        </div>
    </div> 
</div>
