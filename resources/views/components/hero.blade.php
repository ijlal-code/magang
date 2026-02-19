<section id="home" class="h-screen hero-bg flex items-center justify-center text-white relative">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>

    {{-- PERBAIKAN 1: Durasi AOS dikurangi dari 1000 ke 800 agar munculnya lebih sigap --}}
    <div class="relative z-10 text-center px-4 max-w-4xl mx-auto" data-aos="fade-up" data-aos-duration="800">
        <h1 class="text-5xl md:text-7xl font-extrabold mb-6 drop-shadow-lg tracking-tight">
            Magang <span class="text-green-400">Tonasa</span>
        </h1>
        
        <p class="text-xl md:text-2xl mb-8 font-light text-gray-200 leading-relaxed">
            Wadah kolaborasi digital untuk mendokumentasikan kegiatan dan project peserta magang.
        </p>

        @guest
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                
                {{-- TOMBOL DAFTAR --}}
                {{-- Ubah transition menjadi: transition-all duration-200 ease-out --}}
                {{-- Tambah active:scale-95 untuk efek klik --}}
                <button @click="registerModal = true" 
                        class="bg-green-600 hover:bg-green-500 text-white font-bold py-3 px-8 rounded-full 
                               shadow-lg transform transition-all duration-200 ease-out 
                               hover:scale-105 active:scale-95 hover:shadow-green-500/50">
                    Daftar Sekarang
                </button>

                {{-- TOMBOL MASUK --}}
                <button @click="loginModal = true" 
                        class="bg-transparent border-2 border-white text-white font-bold py-3 px-8 rounded-full 
                               shadow-lg transform transition-all duration-200 ease-out 
                               hover:bg-white hover:text-blue-900 hover:scale-105 active:scale-95">
                    Masuk Akun
                </button>

            </div>
        @else
            <div class="inline-block bg-white bg-opacity-20 backdrop-blur-md rounded-full px-6 py-2 border border-white/30">
                <p class="text-lg text-white">
                    Selamat datang, <span class="font-bold text-yellow-300">{{ Auth::user()->name }}</span>! 👋
                </p>
            </div>
            
            <div class="mt-8 animate-bounce">
                <a href="#gallery" class="text-white hover:text-green-400 transition duration-200 ease-out flex flex-col items-center">
                    <span class="text-sm mb-2">Mulai Jelajahi</span>
                    <i class="fas fa-chevron-down text-2xl"></i>
                </a>
            </div>
        @endguest
    </div>
</section>