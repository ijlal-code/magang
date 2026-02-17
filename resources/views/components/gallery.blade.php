<section id="gallery" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
            <div class="w-full md:w-auto text-center md:text-left">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900" data-aos="fade-right">Galeri Dokumentasi</h2>
                <p class="mt-2 text-gray-600 text-sm md:text-base" data-aos="fade-right" data-aos-delay="100">
                    Momen kegiatan dan keseruan magang kami.
                </p>
            </div>
            
            <button @click="uploadDocModal = true" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full shadow-lg transition transform hover:-translate-y-1 flex items-center justify-center gap-2 font-semibold text-sm">
                <i class="fas fa-camera"></i> <span>Upload Foto</span>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @forelse($docs as $doc)
            <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition-shadow duration-300 overflow-hidden group border border-gray-100 flex flex-col h-full" data-aos="fade-up">
                
                <div class="h-56 overflow-hidden relative bg-gray-200 cursor-pointer" @click="selectedItem = {{ $doc }}; detailModal = true">
                    @if($doc->status == 'pending')
                        <div class="absolute top-3 right-3 bg-yellow-400 text-white text-[10px] font-bold px-2 py-1 rounded shadow z-10">
                            PENDING
                        </div>
                    @endif

                    <img src="{{ asset($doc->image_path) }}" 
                         alt="{{ $doc->title }}"
                         loading="lazy"
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                         onerror="this.src='https://via.placeholder.com/800x600?text=Image+Error'">
                    
                    <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <span class="text-white border border-white/60 bg-white/10 backdrop-blur px-4 py-1.5 rounded-full text-xs font-medium">
                            Lihat Detail
                        </span>
                    </div>
                </div>
                
                <div class="p-5 flex flex-col flex-grow">
                    <h3 class="font-bold text-lg text-gray-800 line-clamp-1 mb-1 hover:text-blue-600 cursor-pointer transition" @click="selectedItem = {{ $doc }}; detailModal = true">
                        {{ $doc->title }}
                    </h3>
                    
                    <div class="flex items-center text-xs text-gray-500 mb-3">
                        <i class="fas fa-user-circle mr-1 text-blue-500"></i> 
                        <span class="truncate max-w-[150px]">{{ $doc->author_name }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ $doc->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <p class="text-gray-600 text-sm line-clamp-2 mb-4 flex-grow">{{ $doc->description }}</p>
                    
                    <div class="pt-3 border-t border-gray-100 flex justify-between items-center mt-auto">
                        <button @click="selectedItem = {{ $doc }}; detailModal = true" class="text-blue-600 font-semibold text-xs hover:underline">
                            Selengkapnya
                        </button>

                        @if(Auth::check() && (Auth::user()->role === 'admin' || Auth::id() == $doc->user_id))
                        <div class="flex gap-2">
                            @if(Auth::user()->role === 'admin' && $doc->status == 'pending')
                                <a href="{{ route('admin.approve', ['doc', $doc->id]) }}" class="text-green-500 hover:text-green-700 p-1" title="Approve">
                                    <i class="fas fa-check"></i>
                                </a>
                            @endif
                            
                            <button @click="selectedItem = {{ $doc }}; editDocModal = true" class="text-gray-400 hover:text-blue-500 p-1 transition">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('doc.delete', $doc->id) }}" method="POST" onsubmit="return confirm('Hapus dokumentasi ini?')" class="inline">
                                @csrf @method('DELETE')
                                <button class="text-gray-400 hover:text-red-500 p-1 transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12 bg-white rounded-xl border border-dashed border-gray-300">
                <div class="text-gray-300 mb-2"><i class="fas fa-images text-4xl"></i></div>
                <p class="text-gray-500 text-sm">Belum ada dokumentasi yang diupload.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-12 text-center" data-aos="fade-up">
            <a href="{{ route('docs.index') }}" target="_blank" class="inline-flex items-center justify-center px-8 py-3 border border-blue-600 text-sm font-bold rounded-full text-blue-600 bg-white hover:bg-blue-50 transition duration-300 shadow-sm hover:shadow-md">
                Lihat Semua Dokumentasi <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>