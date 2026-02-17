<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Projek - Magang Tonasa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    @include('components.navbar')

    <section class="pt-32 pb-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto min-h-screen">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Showcase Projek</h1>
                <p class="text-gray-600 mt-1">Kumpulan karya aplikasi dan website peserta magang.</p>
            </div>
            
            <form action="{{ route('projects.index') }}" method="GET" class="w-full md:w-auto relative">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari projek..." 
                       class="w-full md:w-80 border border-gray-300 rounded-full py-2 pl-5 pr-12 focus:outline-none focus:ring-2 focus:ring-green-500 shadow-sm">
                <button type="submit" class="absolute right-3 top-2.5 text-gray-400 hover:text-green-600">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
            @forelse($projects as $proj)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 group flex flex-col h-full">
                    <div class="h-52 overflow-hidden relative bg-gray-100">
                        <img src="{{ asset($proj->thumbnail_path) }}" 
                             alt="{{ $proj->title }}"
                             class="w-full h-full object-cover transition duration-700 group-hover:scale-105"
                             onerror="this.src='https://via.placeholder.com/800x400?text=No+Thumb'">
                        
                        <a href="{{ $proj->project_url }}" target="_blank" class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition flex items-center justify-center opacity-0 group-hover:opacity-100">
                            <span class="bg-white text-gray-900 px-4 py-2 rounded-full font-bold text-sm shadow hover:bg-gray-100">
                                Kunjungi <i class="fas fa-external-link-alt ml-1"></i>
                            </span>
                        </a>
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-bold text-lg mb-2 text-gray-800 line-clamp-1">{{ $proj->title }}</h3>
                        <p class="text-gray-500 text-sm mb-4 line-clamp-3 flex-grow">{{ $proj->description }}</p>
                        <div class="mt-auto pt-4 border-t flex justify-between items-center">
                            <span class="text-xs text-green-600 font-bold">
                                <i class="fas fa-code mr-1"></i> {{ $proj->author_name }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 text-gray-500">
                    <i class="fas fa-laptop-code text-4xl mb-4 text-gray-300"></i>
                    <p>Tidak ada projek ditemukan.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $projects->links() }}
        </div>
        
        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-green-600 font-medium">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Beranda
            </a>
        </div>
    </section>

    @include('components.footer')
</body>
</html>