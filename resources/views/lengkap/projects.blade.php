<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Projek - Magang Tonasa</title>
    
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
                <h1 class="text-3xl font-bold text-brand-dark">Showcase Projek</h1>
                <p class="text-gray-500 mt-1 font-medium">Kumpulan karya aplikasi dan website peserta magang.</p>
            </div>
            
            <form action="{{ route('projects.index') }}" method="GET" class="w-full md:w-auto relative">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari projek..." 
                       class="w-full md:w-80 border border-brand-light/50 rounded-full py-2.5 pl-5 pr-12 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent shadow-sm bg-white transition-all">
                <button type="submit" class="absolute right-4 top-3 text-gray-400 hover:text-brand-primary transition">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
            @forelse($projects as $proj)
                <div class="bg-white rounded-2xl shadow-sm border border-brand-light/30 overflow-hidden hover:shadow-xl hover:shadow-brand-primary/10 transition duration-300 group flex flex-col h-full transform hover:-translate-y-1">
                     
                    <div @click="selectedItem = { 
                            type: 'project', 
                            title: '{{ addslashes($proj->title) }}', 
                            desc: '{{ addslashes(preg_replace('/\s+/', ' ', $proj->description)) }}', 
                            img: '{{ asset($proj->thumbnail_path) }}', 
                            author: '{{ addslashes($proj->author_name) }}', 
                            date: '{{ $proj->created_at->diffForHumans() }}',
                            project_url: '{{ $proj->project_url }}'
                         }; detailModal = true" 
                         class="h-52 overflow-hidden relative bg-brand-light/20 cursor-pointer">
                         
                        <img src="{{ asset($proj->thumbnail_path) }}" 
                             alt="{{ $proj->title }}"
                             class="w-full h-full object-cover transition duration-700 group-hover:scale-110"
                             onerror="this.src='https://via.placeholder.com/800x400?text=No+Thumb'">
                        
                        <div class="absolute inset-0 bg-brand-dark/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center backdrop-blur-sm">
                            <span class="text-brand-dark bg-white/90 px-5 py-2 rounded-full text-xs font-bold shadow-lg flex items-center gap-2">
                                <i class="fas fa-expand"></i> Preview Detail
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="font-bold text-xl mb-2 text-brand-dark line-clamp-1 group-hover:text-brand-primary transition">{{ $proj->title }}</h3>
                        
                        <div class="flex items-center text-xs text-gray-500 mb-4 font-medium">
                            <i class="fas fa-code mr-1.5 text-brand-primary text-sm"></i> 
                            <span class="truncate max-w-[150px]">{{ $proj->author_name }}</span>
                            <span class="mx-2 text-gray-300">•</span>
                            <span>{{ $proj->created_at->diffForHumans() }}</span>
                        </div>

                        <p class="text-gray-500 text-sm mb-5 line-clamp-3 leading-relaxed flex-grow">{{ $proj->description }}</p>
                        
                        <div class="mt-auto pt-4 border-t border-brand-light/30 flex gap-3">
                            <button @click="selectedItem = { 
                                    type: 'project', 
                                    title: '{{ addslashes($proj->title) }}', 
                                    desc: '{{ addslashes(preg_replace('/\s+/', ' ', $proj->description)) }}', 
                                    img: '{{ asset($proj->thumbnail_path) }}', 
                                    author: '{{ addslashes($proj->author_name) }}', 
                                    date: '{{ $proj->created_at->diffForHumans() }}',
                                    project_url: '{{ $proj->project_url }}'
                                 }; detailModal = true" 
                                 class="flex-1 bg-brand-light/20 text-brand-dark hover:bg-brand-primary hover:text-white py-2.5 rounded-xl text-xs font-bold transition-colors flex items-center justify-center gap-2">
                                <i class="fas fa-info-circle"></i> Detail Info
                            </button>
                            
                            <a href="{{ $proj->project_url }}" target="_blank" class="flex-1 bg-brand-primary hover:bg-brand-dark text-white py-2.5 rounded-xl text-xs font-bold transition-colors flex items-center justify-center gap-2 shadow-lg shadow-brand-primary/20">
                                <i class="fas fa-external-link-alt"></i> Kunjungi Web
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 bg-white rounded-2xl border border-brand-light/30 border-dashed">
                    <div class="bg-brand-light/20 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 text-brand-primary">
                        <i class="fas fa-laptop-code text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-brand-dark mb-1">Tidak ada projek ditemukan</h3>
                    <p class="text-gray-500">Coba gunakan kata kunci pencarian yang lain.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8 flex justify-center">
            <div class="*:text-brand-primary">
                {{ $projects->links() }}
            </div>
        </div>
        
    </section>

    @include('components.footer')
    
    @include('components.modals-auth')
    @include('components.modals-content')
</body>
</html>