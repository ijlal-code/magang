<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Publikasi & Pin - Admin Portal Magang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Kelola Semua Publikasi</h1>
                    <p class="text-gray-600 mt-2">Cari karya user & anonim, dan Sematkan (Pin) ke halaman utama.</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-semibold transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <form method="GET" action="{{ route('admin.manage.items') }}" class="mb-10 bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex gap-4">
                <div class="flex-grow">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul proyek atau nama pembuat..." class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-bold transition shadow-md">
                    <i class="fas fa-search mr-2"></i> Cari Karya
                </button>
                @if($search)
                    <a href="{{ route('admin.manage.items') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-bold transition">Reset</a>
                @endif
            </form>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden">
                    <div class="bg-blue-50 border-b border-blue-100 px-6 py-4">
                        <h2 class="text-xl font-bold text-blue-800"><i class="fas fa-camera mr-2"></i> Foto Dokumentasi</h2>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        @forelse($docs as $doc)
                            <div class="p-6 flex gap-4 items-center hover:bg-gray-50 transition">
                                <img src="{{ asset($doc->image_path) }}" class="w-20 h-20 object-cover rounded-lg border" onerror="this.src='https://via.placeholder.com/150'">
                                <div class="flex-grow">
                                    <h3 class="font-bold text-gray-900">{{ $doc->title }}</h3>
                                    <p class="text-sm text-gray-500 mt-1"><i class="fas fa-user-circle mr-1"></i> {{ $doc->author_name }}</p>
                                    <p class="text-xs mt-1">Status: 
                                        <span class="{{ $doc->status == 'approved' ? 'text-green-600' : 'text-yellow-600' }} font-semibold">{{ strtoupper($doc->status) }}</span>
                                    </p>
                                </div>
                                <div>
                                    <form action="{{ route('admin.toggle.pin', ['type' => 'doc', 'id' => $doc->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" title="{{ $doc->is_pinned ? 'Lepas Pin' : 'Sematkan ke Atas' }}" 
                                            class="w-10 h-10 rounded-full flex items-center justify-center transition shadow-sm {{ $doc->is_pinned ? 'bg-yellow-400 hover:bg-yellow-500 text-white' : 'bg-gray-100 hover:bg-gray-200 text-gray-500' }}">
                                            <i class="fas fa-thumbtack {{ $doc->is_pinned ? 'transform -rotate-45' : '' }}"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-gray-500">Belum ada data dokumentasi.</div>
                        @endforelse
                    </div>
                    <div class="p-4 border-t border-gray-100 bg-gray-50">
                        {{ $docs->appends(['proj_page' => $projects->currentPage(), 'search' => $search])->links() }}
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden">
                    <div class="bg-green-50 border-b border-green-100 px-6 py-4">
                        <h2 class="text-xl font-bold text-green-800"><i class="fas fa-laptop-code mr-2"></i> Projek Website</h2>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        @forelse($projects as $proj)
                            <div class="p-6 flex gap-4 items-center hover:bg-gray-50 transition">
                                <img src="{{ asset($proj->thumbnail_path) }}" class="w-20 h-20 object-cover rounded-lg border" onerror="this.src='https://via.placeholder.com/150'">
                                <div class="flex-grow">
                                    <h3 class="font-bold text-gray-900">{{ $proj->title }}</h3>
                                    <p class="text-sm text-gray-500 mt-1"><i class="fas fa-user-circle mr-1"></i> {{ $proj->author_name }}</p>
                                    <p class="text-xs mt-1">Status: 
                                        <span class="{{ $proj->status == 'approved' ? 'text-green-600' : 'text-yellow-600' }} font-semibold">{{ strtoupper($proj->status) }}</span>
                                    </p>
                                </div>
                                <div>
                                    <form action="{{ route('admin.toggle.pin', ['type' => 'project', 'id' => $proj->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" title="{{ $proj->is_pinned ? 'Lepas Pin' : 'Sematkan ke Atas' }}" 
                                            class="w-10 h-10 rounded-full flex items-center justify-center transition shadow-sm {{ $proj->is_pinned ? 'bg-yellow-400 hover:bg-yellow-500 text-white' : 'bg-gray-100 hover:bg-gray-200 text-gray-500' }}">
                                            <i class="fas fa-thumbtack {{ $proj->is_pinned ? 'transform -rotate-45' : '' }}"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-gray-500">Belum ada data projek.</div>
                        @endforelse
                    </div>
                    <div class="p-4 border-t border-gray-100 bg-gray-50">
                        {{ $projects->appends(['doc_page' => $docs->currentPage(), 'search' => $search])->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>