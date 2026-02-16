<section id="gallery" class="py-20 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-end mb-10">
            <h2 class="text-4xl font-bold text-gray-900" data-aos="fade-right">Galeri Kegiatan</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($docs as $doc)
            <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col hover:shadow-xl transition relative" data-aos="fade-up">
                
                @if($doc->status == 'pending')
                    <div class="absolute top-2 right-2 bg-yellow-400 text-yellow-900 text-xs font-bold px-2 py-1 rounded z-10">PENDING</div>
                @endif

                <img src="{{ asset($doc->image_path) }}" class="w-full h-48 object-cover cursor-pointer" 
                     @click="selectedItem = {{ $doc }}; detailModal = true">
                
                <div class="p-4 flex flex-col flex-grow">
                    <h3 class="font-bold text-lg">{{ $doc->title }}</h3>
                    <p class="text-xs text-gray-500 mb-2">Oleh: {{ $doc->author_name }}</p>
                    <p class="text-gray-600 text-sm line-clamp-2">{{ \Illuminate\Support\Str::limit($doc->description, 80) }}</p>
                    
                    <div class="mt-auto pt-4 flex justify-between items-center border-t mt-4">
                        @if($isAdmin && $doc->status == 'pending')
                            <a href="{{ route('admin.approve', ['doc', $doc->id]) }}" class="text-xs bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">Approve</a>
                        @endif

                        @if($isAdmin || (Auth::check() && Auth::id() == $doc->user_id))
                            <div class="flex space-x-2">
                                <button @click="selectedItem = {{ $doc }}; editDocModal = true" class="text-blue-500 hover:text-blue-700 text-sm"><i class="fas fa-edit"></i></button>
                                <form action="{{ route('doc.delete', $doc->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:text-red-700 text-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>