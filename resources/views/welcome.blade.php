<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magang Tonasa</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            dark: '#042940',      /* Navy Blue - Footer, Headings */
                            primary: '#005C53',   /* Deep Teal - Main Brand Color */
                            secondary: '#9FC131', /* Muted Lime - Hover states */
                            accent: '#DBF227',    /* Bright Neon - CTA, Highlights */
                            light: '#D6D58E',     /* Pale Yellow - Subtle Backgrounds */
                            bg: '#F8FAF9',        /* Very light tint for body bg */
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        .hero-bg {
            /* Menggunakan Gradient Overlay dari warna tema Anda */
            background: linear-gradient(to bottom right, rgba(4, 41, 64, 0.85), rgba(0, 92, 83, 0.75)), url('https://images.unsplash.com/photo-1581094794329-cd56b5095a8e?auto=format&fit=crop&w=1950&q=80');
            background-size: cover; background-position: center; background-attachment: fixed;
        }
        [x-cloak] { display: none !important; }
        
        @supports (-webkit-touch-callout: none) {
            .hero-bg { background-attachment: scroll; }
        }
    </style>
</head>
<body class="bg-brand-bg text-brand-dark font-sans antialiased" x-data="{ 
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
        <div class="absolute top-20 left-10 w-32 h-32 bg-brand-accent opacity-20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-40 h-40 bg-brand-secondary opacity-20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>

        <div class="relative z-10 text-center max-w-5xl mx-auto" data-aos="fade-up" data-aos-duration="800">
            
            

            <h1 class="text-4xl sm:text-5xl md:text-7xl font-extrabold mb-6 drop-shadow-2xl tracking-tight leading-tight text-white">
                 Magang <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-accent to-brand-secondary">Tonasa</span>
            </h1>
            
            <p class="text-base sm:text-lg md:text-xl mb-10 font-light text-gray-100 leading-relaxed max-w-2xl mx-auto px-2 opacity-90">
                Platform kolaborasi digital untuk mendokumentasikan kegiatan dan project peserta magang di PT Semen Tonasa.
            </p>

            @guest
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center w-full px-4">
                    <button @click="registerModal = true" 
                            class="w-full sm:w-auto bg-brand-accent hover:bg-brand-secondary text-brand-dark font-bold py-4 px-8 rounded-full 
                                   shadow-[0_0_20px_rgba(219,242,39,0.3)] transform transition-all duration-300 ease-out 
                                   hover:scale-105 active:scale-95">
                        Daftar Sekarang <i class="fas fa-arrow-right ml-2"></i>
                    </button>

                    <button @click="loginModal = true" 
                            class="w-full sm:w-auto bg-white/10 backdrop-blur-md border border-white/30 text-white font-semibold py-4 px-8 rounded-full 
                                   hover:bg-brand-dark/50 hover:border-brand-accent hover:text-brand-accent transition-all duration-300">
                        Masuk Akun
                    </button>
                </div>
            @else
                <div class="inline-block bg-brand-dark/40 backdrop-blur-md rounded-2xl px-8 py-4 border border-brand-accent/20 mb-8 shadow-lg">
                    <p class="text-base sm:text-lg text-white">
                        Selamat datang kembali, <span class="font-bold text-brand-accent">{{ Auth::user()->name }}</span>! 👋
                    </p>
                </div>
                
                <div class="animate-bounce mt-4">
                    <a href="#gallery" class="text-white/80 hover:text-brand-accent transition duration-300 flex flex-col items-center gap-2 group">
                        <span class="text-sm font-medium tracking-widest uppercase text-xs">Mulai Jelajahi</span>
                        <div class="p-2 rounded-full border border-white/20 group-hover:border-brand-accent transition">
                            <i class="fas fa-chevron-down text-lg"></i>
                        </div>
                    </a>
                </div>
            @endguest
        </div>
    </section>

    @include('components.gallery')
    @include('components.projects')
    @include('components.about')
    @include('components.footer')

    @include('components.modals-auth')
    @include('components.modals-content')

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        window.addEventListener('load', function() {
            AOS.init({ once: true, duration: 800, offset: 50 });
        });

        @if(session('success'))
            Swal.fire({ 
                icon: 'success', 
                title: 'Berhasil', 
                text: "{{ session('success') }}", 
                timer: 3000, 
                showConfirmButton: false, 
                background: '#fff',
                iconColor: '#005C53'
            });
        @endif
        @if(session('error'))
            Swal.fire({ icon: 'error', title: 'Gagal', text: "{{ session('error') }}" });
        @endif
    </script>
</body>
</html>