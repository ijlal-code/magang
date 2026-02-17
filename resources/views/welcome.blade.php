<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magang Tonasa</title>
    
   <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        .hero-bg {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1581094794329-cd56b5095a8e?auto=format&fit=crop&w=1950&q=80');
            background-size: cover; background-position: center; background-attachment: fixed;
        }
        [x-cloak] { display: none !important; }
        
        /* Fix untuk Background attachment di iPhone */
        @supports (-webkit-touch-callout: none) {
            .hero-bg { background-attachment: scroll; }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased" x-data="{ 
    loginModal: false, 
    registerModal: false, 
    uploadDocModal: false, 
    uploadProjectModal: false,
    editDocModal: false,
    editProjectModal: false,
    detailModal: false,
    selectedItem: {} 
}">

    @include('components.navbar')

    <section id="home" class="min-h-screen hero-bg flex items-center justify-center text-white relative px-4 pt-20">
        <div class="relative z-10 text-center max-w-4xl mx-auto" data-aos="fade-up" data-aos-duration="800">
            
            <h1 class="text-4xl sm:text-5xl md:text-7xl font-extrabold mb-6 drop-shadow-xl tracking-tight leading-tight">
                Inovasi Magang <span class="text-blue-400">Tonasa</span>
            </h1>
            
            <p class="text-base sm:text-lg md:text-2xl mb-8 font-light text-gray-200 leading-relaxed max-w-2xl mx-auto px-2">
                Wadah kolaborasi digital untuk mendokumentasikan kegiatan dan memamerkan karya inovatif peserta magang.
            </p>

            @guest
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center w-full px-4">
                    <button @click="registerModal = true" 
                            class="w-full sm:w-auto bg-blue-600 hover:bg-blue-500 text-white font-bold py-3.5 px-8 rounded-full 
                                   shadow-lg transform transition-all duration-200 ease-out 
                                   hover:scale-105 active:scale-95 hover:shadow-blue-500/50">
                        Daftar Sekarang
                    </button>

                    <button @click="loginModal = true" 
                            class="w-full sm:w-auto bg-transparent border-2 border-white text-white font-bold py-3.5 px-8 rounded-full 
                                   shadow-lg transform transition-all duration-200 ease-out 
                                   hover:bg-white hover:text-blue-900 hover:scale-105 active:scale-95">
                        Masuk Akun
                    </button>
                </div>
            @else
                <div class="inline-block bg-white/10 backdrop-blur-md rounded-full px-6 py-2 border border-white/20 mb-8">
                    <p class="text-base sm:text-lg text-white">
                        Hai, <span class="font-bold text-yellow-300">{{ Auth::user()->name }}</span>! 👋
                    </p>
                </div>
                
                <div class="animate-bounce">
                    <a href="#gallery" class="text-white hover:text-blue-400 transition duration-200 flex flex-col items-center gap-2">
                        <span class="text-sm font-medium">Mulai Jelajahi</span>
                        <i class="fas fa-chevron-down text-xl"></i>
                    </a>
                </div>
            @endguest
        </div>
    </section>

    @include('components.about')
    @include('components.gallery')
    @include('components.projects')
    @include('components.footer')

    @include('components.modals-auth')
    @include('components.modals-content')

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        window.addEventListener('load', function() {
            AOS.init({
                once: true, 
                duration: 800,
                offset: 50,
            });
        });

        // SweetAlert Feedback
        @if(session('success'))
            Swal.fire({ 
                icon: 'success', 
                title: 'Berhasil', 
                text: "{{ session('success') }}", 
                timer: 3000, 
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        @endif
        @if(session('error'))
            Swal.fire({ icon: 'error', title: 'Gagal', text: "{{ session('error') }}" });
        @endif
    </script>
</body>
</html>