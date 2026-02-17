<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Dokumentasi - Magang Tonasa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    @include('components.navbar')

    <section class="pt-32 pb-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto min-h-screen">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Galeri Dokumentasi</h1>
                <p class="text-gray-600 mt-1">Menampilkan semua momen kegiatan magang.</p>
            </div>
            
            <form action="{{ route('docs.index') }}" method="GET" class="w-full md:w-auto relative">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari foto..." 
                       class="w-full md:w-80 border border-gray-300 rounded-full py-2 pl-5 pr-12 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm">
                <button type="submit" class="absolute right-3 top-2.5 text-gray-400 hover:text-blue-600">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
            @forelse($docs as $doc)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 group">
                    <div class="h-64 overflow-hidden relative bg-gray-200">
                        <img src="{{ asset($doc->image_path) }}" 
                             alt="{{ $doc->title }}"
                             class="w-full h-full object-cover transition duration-700 group-hover:scale-110"
                             onerror="this.src='https://via.placeholder.com/800x600?text=Error'">
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-lg mb-2 line-clamp-1">{{ $doc->title }}</h3>
                        <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ $doc->description }}</p>
                        <div class="flex items-center text-xs text-blue-600 font-semibold">
                            <i class="fas fa-user-circle mr-1"></i> {{ $doc->author_name }}
                            <span class="mx-2 text-gray-300">|</span>
                            <span>{{ $doc->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 text-gray-500">
                    <i class="fas fa-search text-4xl mb-4 text-gray-300"></i>
                    <p>Tidak ada dokumentasi ditemukan.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $docs->links() }} 
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-blue-600 font-medium">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Beranda
            </a>
        </div>
    </section>

    @include('components.footer')
</body>
</html>