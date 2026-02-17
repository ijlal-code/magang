<section id="gallery" class="py-20 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-10">
            <h2 class="text-4xl font-bold text-gray-900" data-aos="fade-right">Galeri Kegiatan</h2>
            <button @click="uploadDocModal = true" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow-lg transition transform hover:-translate-y-1" data-aos="fade-left">
                <i class="fas fa-camera mr-2"></i> Upload Foto
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($docs as $doc)
            <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col hover:shadow-xl transition relative group" data-aos="fade-up">
                
                @if($doc->status == 'pending')
                    <div class="absolute top-2 right-2 bg-yellow-400 text-yellow-900 text-xs font-bold px-2 py-1 rounded z-10 shadow">PENDING</div>
                @endif

                <div class="h-48 overflow-hidden">
                    <img src="{{ asset($doc->image_path) }}" class="w-full h-full object-cover cursor-pointer transition duration-500 group-hover:scale-110" 
                        @click="selectedItem = {{ $doc }}; detailModal = true">
                </div>
                
                <div class="p-4 flex flex-col flex-grow">
                    <h3 class="font-bold text-lg mb-1">{{ $doc->title }}</h3>
                    <p class="text-xs text-blue-500 mb-2 font-semibold"><i class="fas fa-user-circle mr-1"></i> {{ $doc->author_name }}</p>
                    <p class="text-gray-600 text-sm line-clamp-2 mb-4">{{ \Illuminate\Support\Str::limit($doc->description, 80) }}</p>
                    
                    <div class="mt-auto pt-4 flex justify-between items-center border-t border-gray-100">
                        <button @click="selectedItem = {{ $doc }}; detailModal = true" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                            Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
                        </button>

                        <div class="flex space-x-2">
                            @if(Auth::check() && Auth::user()->role === 'admin' && $doc->status == 'pending')
                                <a href="{{ route('admin.approve', ['doc', $doc->id]) }}" class="text-xs bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600" title="Setujui">Approve</a>
                            @endif

                            @if(Auth::check() && (Auth::user()->role === 'admin' || Auth::id() == $doc->user_id))
                                <button @click="selectedItem = {{ $doc }}; editDocModal = true" class="text-gray-400 hover:text-blue-500 transition"><i class="fas fa-edit"></i></button>
                                <form action="{{ route('doc.delete', $doc->id) }}" method="POST" onsubmit="return confirm('Hapus dokumentasi ini?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="text-gray-400 hover:text-red-500 transition"><i class="fas fa-trash"></i></button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-10 text-gray-500">
                <i class="fas fa-images text-4xl mb-3 text-gray-300"></i>
                <p>Belum ada dokumentasi yang diupload.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>