<section id="gallery" class="py-20 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-4xl font-bold text-gray-900" data-aos="fade-right">Galeri Dokumentasi</h2>
                <p class="mt-2 text-gray-600" data-aos="fade-right" data-aos-delay="100">Momen-momen seru kegiatan magang kami.</p>
            </div>
            
            <button @click="uploadDocModal = true" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg shadow-lg transition transform hover:-translate-y-1 flex items-center gap-2" data-aos="fade-left">
                <i class="fas fa-camera"></i> <span>Upload Foto</span>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($docs as $doc)
            <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col hover:shadow-2xl transition duration-300 transform hover:-translate-y-1 group relative" data-aos="fade-up">
                
                @if($doc->status == 'pending')
                    <div class="absolute top-3 right-3 bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-full shadow-md z-10 border border-yellow-500 animate-pulse">
                        <i class="fas fa-clock mr-1"></i> MENUNGGU APPROVAL
                    </div>
                @endif

                <div class="h-56 overflow-hidden relative bg-gray-200">
                    <img src="{{ asset($doc->image_path) }}" 
                         alt="{{ $doc->title }}"
                         class="w-full h-full object-cover cursor-pointer transition duration-700 group-hover:scale-110" 
                         @click="selectedItem = {{ $doc }}; detailModal = true"
                         onerror="this.src='https://via.placeholder.com/800x600?text=Gambar+Rusak'">
                    
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition flex items-center justify-center opacity-0 group-hover:opacity-100 pointer-events-none">
                        <span class="text-white font-bold border-2 border-white px-4 py-1 rounded-full text-sm">Lihat Detail</span>
                    </div>
                </div>
                
                <div class="p-5 flex flex-col flex-grow">
                    <h3 class="font-bold text-xl mb-1 text-gray-800 line-clamp-1" title="{{ $doc->title }}">{{ $doc->title }}</h3>
                    
                    <div class="flex items-center text-xs text-blue-600 mb-3 font-semibold">
                        <i class="fas fa-user-circle mr-1.5 text-lg"></i> {{ $doc->author_name }}
                    </div>
                    
                    <p class="text-gray-600 text-sm line-clamp-2 mb-4 flex-grow">{{ $doc->description }}</p>
                    
                    <div class="mt-auto pt-4 flex justify-between items-center border-t border-gray-100">
                        <button @click="selectedItem = {{ $doc }}; detailModal = true" class="text-blue-600 hover:text-blue-800 text-sm font-bold flex items-center gap-1 transition">
                            Selengkapnya <i class="fas fa-arrow-right"></i>
                        </button>

                        <div class="flex items-center gap-2">
                            @if(Auth::check() && Auth::user()->role === 'admin' && $doc->status == 'pending')
                                <a href="{{ route('admin.approve', ['doc', $doc->id]) }}" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition shadow-sm" title="Setujui Postingan">
                                    <i class="fas fa-check"></i>
                                </a>
                            @endif

                            @if(Auth::check() && (Auth::user()->role === 'admin' || Auth::id() == $doc->user_id))
                                <button @click="selectedItem = {{ $doc }}; editDocModal = true" class="text-gray-400 hover:text-blue-500 p-1 transition" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                
                                <form action="{{ route('doc.delete', $doc->id) }}" method="POST" onsubmit="return confirm('Hapus dokumentasi ini secara permanen?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="text-gray-400 hover:text-red-500 p-1 transition" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-16 bg-white rounded-xl shadow-sm border border-dashed border-gray-300">
                <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-images text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-700">Belum ada dokumentasi</h3>
                <p class="text-gray-500 text-sm mt-1">Jadilah yang pertama mengupload foto kegiatan!</p>
                <button @click="uploadDocModal = true" class="mt-4 text-blue-600 hover:underline font-semibold">Upload Sekarang</button>
            </div>
            @endforelse
        </div>
    </div>
</section>