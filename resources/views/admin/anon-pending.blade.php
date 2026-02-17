<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval Anonim - Admin</title>
   <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-gray-100 font-sans text-gray-800">

    @include('components.navbar')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 mt-20">
        
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-blue-600 mr-2"><i class="fas fa-arrow-left"></i></a>
                Approval Postingan Anonim
            </h1>
            <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-bold border border-orange-200">
                Pending: {{ $pendingDocs->count() + $pendingProjs->count() }}
            </span>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">{{ session('success') }}</div>
        @endif

        <h2 class="text-lg font-bold mb-4 text-blue-700 border-b pb-2">Dokumentasi Pending</h2>
        @if($pendingDocs->isEmpty())
            <p class="text-gray-500 italic mb-8">Tidak ada dokumentasi anonim yang menunggu persetujuan.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                @foreach($pendingDocs as $doc)
                <div class="bg-white rounded-lg shadow p-4 flex flex-col">
                    <img src="{{ asset($doc->image_path) }}" class="h-32 w-full object-cover rounded mb-3 bg-gray-200">
                    <h3 class="font-bold text-sm mb-1">{{ $doc->title }}</h3>
                    <p class="text-xs text-gray-500 mb-2">Oleh: {{ $doc->author_name }}</p>
                    <p class="text-sm text-gray-600 line-clamp-2 mb-4 flex-grow">{{ $doc->description }}</p>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.approve', ['doc', $doc->id]) }}" class="flex-1 bg-green-500 hover:bg-green-600 text-white py-2 rounded text-center text-sm font-bold">
                            <i class="fas fa-check"></i> Terima
                        </a>
                        <form action="{{ route('doc.delete', $doc->id) }}" method="POST" onsubmit="return confirm('Hapus permanen?')" class="flex-1">
                            @csrf @method('DELETE')
                            <button class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded text-sm font-bold">
                                <i class="fas fa-trash"></i> Tolak
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @endif

        <h2 class="text-lg font-bold mb-4 text-green-700 border-b pb-2">Projek Web Pending</h2>
        @if($pendingProjs->isEmpty())
            <p class="text-gray-500 italic">Tidak ada projek anonim yang menunggu persetujuan.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($pendingProjs as $proj)
                <div class="bg-white rounded-lg shadow p-4 flex flex-col">
                    <img src="{{ asset($proj->thumbnail_path) }}" class="h-32 w-full object-cover rounded mb-3 bg-gray-200">
                    <h3 class="font-bold text-sm mb-1">{{ $proj->title }}</h3>
                    <p class="text-xs text-gray-500 mb-2">Oleh: {{ $proj->author_name }}</p>
                    <a href="{{ $proj->project_url }}" target="_blank" class="text-xs text-blue-500 hover:underline mb-2 truncate block">{{ $proj->project_url }}</a>
                    <div class="flex gap-2 mt-auto pt-4">
                        <a href="{{ route('admin.approve', ['project', $proj->id]) }}" class="flex-1 bg-green-500 hover:bg-green-600 text-white py-2 rounded text-center text-sm font-bold">
                            <i class="fas fa-check"></i> Terima
                        </a>
                        <form action="{{ route('project.delete', $proj->id) }}" method="POST" onsubmit="return confirm('Hapus permanen?')" class="flex-1">
                            @csrf @method('DELETE')
                            <button class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded text-sm font-bold">
                                <i class="fas fa-trash"></i> Tolak
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @endif

    </div>
</body>
</html>