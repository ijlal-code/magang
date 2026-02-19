<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Dokumentasi - Magang Tonasa</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            dark: '#042940',
                            primary: '#005C53',
                            secondary: '#9FC131',
                            accent: '#DBF227',
                            light: '#D6D58E',
                            bg: '#F8FAF9',
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style> body { font-family: 'Inter', sans-serif; } [x-cloak] { display: none !important; } </style>
</head>

<body class="bg-brand-bg text-gray-800 font-sans antialiased" x-data="{ 
    loginModal: false, 
    registerModal: false, 
    detailModal: false,
    selectedItem: {} 
}">

    @include('components.navbar')

    <section class="pt-32 pb-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto min-h-screen">
        
        <div class="mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-semibold text-brand-primary hover:text-brand-dark transition-colors duration-300">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Beranda
            </a>
        </div>
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-brand-dark">Galeri Dokumentasi</h1>
                <p class="text-gray-500 mt-1 font-medium">Menampilkan semua momen kegiatan magang.</p>
            </div>
            
            <form action="{{ route('docs.index') }}" method="GET" class="w-full md:w-auto relative">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari dokumentasi..." 
                       class="w-full md:w-80 border border-brand-light/50 rounded-full py-2.5 pl-5 pr-12 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent shadow-sm bg-white transition-all">
                <button type="submit" class="absolute right-4 top-3 text-gray-400 hover:text-brand-primary transition">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
            @forelse($docs as $doc)
                <div @click="selectedItem = { 
                        type: 'doc', 
                        title: '{{ addslashes($doc->title) }}', 
                        desc: '{{ addslashes(preg_replace('/\s+/', ' ', $doc->description)) }}', 
                        img: '{{ asset($doc->image_path) }}', 
                        author: '{{ addslashes($doc->author_name) }}', 
                        date: '{{ $doc->created_at->diffForHumans() }}' 
                     }; detailModal = true" 
                     class="bg-white rounded-2xl shadow-sm border border-brand-light/30 overflow-hidden hover:shadow-xl hover:shadow-brand-primary/10 transition duration-300 group cursor-pointer transform hover:-translate-y-1">
                     
                    <div class="h-64 overflow-hidden relative bg-brand-light/20">
                        <img src="{{ asset($doc->image_path) }}" 
                             alt="{{ $doc->title }}"
                             class="w-full h-full object-cover transition duration-700 group-hover:scale-110"
                             onerror="this.src='https://via.placeholder.com/800x600?text=Error'">
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <div class="absolute bottom-4 right-4 translate-y-8 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-300 text-white font-medium text-sm flex items-center bg-brand-primary/90 px-3 py-1.5 rounded-full backdrop-blur-sm">
                            Lihat Detail <i class="fas fa-expand ml-2 text-xs"></i>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <h3 class="font-bold text-xl mb-2 text-brand-dark line-clamp-1 group-hover:text-brand-primary transition">{{ $doc->title }}</h3>
                        <p class="text-gray-500 text-sm mb-5 line-clamp-2 leading-relaxed">{{ $doc->description }}</p>
                        
                        <div class="flex items-center text-xs font-semibold text-brand-primary">
                            <i class="fas fa-user-circle mr-1.5 text-sm"></i> {{ $doc->author_name }}
                            <span class="mx-2 text-gray-300">|</span>
                            <span class="text-gray-500"><i class="far fa-clock mr-1"></i> {{ $doc->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 bg-white rounded-2xl border border-brand-light/30 border-dashed">
                    <div class="bg-brand-light/20 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 text-brand-primary">
                        <i class="fas fa-search text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-brand-dark mb-1">Tidak ada dokumentasi ditemukan</h3>
                    <p class="text-gray-500">Coba gunakan kata kunci pencarian yang lain.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8 flex justify-center">
            <div class="*:text-brand-primary">
                {{ $docs->links() }} 
            </div>
        </div>

    </section>

    @include('components.footer')
    
    @include('components.modals-auth')
    @include('components.modals-content')
</body>
</html>