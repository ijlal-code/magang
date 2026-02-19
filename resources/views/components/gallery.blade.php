<section id="gallery" class="py-16 bg-brand-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
            <div class="w-full md:w-auto text-center md:text-left">
                <h2 class="text-3xl md:text-4xl font-bold text-brand-dark" data-aos="fade-right">Galeri Dokumentasi</h2>
                <p class="mt-2 text-gray-600 text-sm md:text-base" data-aos="fade-right" data-aos-delay="100">
                    Momen kegiatan dan keseruan magang kami.
                </p>
            </div>
            
            <button @click="uploadDocModal = true" class="w-full md:w-auto bg-brand-primary hover:bg-brand-dark text-white px-6 py-3 rounded-full shadow-lg shadow-brand-primary/30 transition transform hover:-translate-y-1 flex items-center justify-center gap-2 font-bold text-sm">
                <i class="fas fa-camera"></i> <span>Upload Foto</span>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @forelse($docs as $doc)
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl hover:shadow-brand-primary/10 transition-all duration-300 overflow-hidden group border border-brand-light/30 flex flex-col h-full transform hover:-translate-y-1" data-aos="fade-up">
                
                <div class="h-56 overflow-hidden relative bg-brand-light/20 cursor-pointer" @click="selectedItem = {{ $doc }}; detailModal = true">
                    @if($doc->status == 'pending')
                        <div class="absolute top-3 right-3 bg-brand-secondary text-brand-dark text-[10px] font-extrabold px-3 py-1 rounded-md shadow-md z-10 tracking-widest uppercase">
                            PENDING
                        </div>
                    @endif

                    <img src="{{ asset($doc->image_path) }}" 
                         alt="{{ $doc->title }}"
                         loading="lazy"
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                         onerror="this.src='https://via.placeholder.com/800x600?text=Image+Error'">
                    
                    <div class="absolute inset-0 bg-brand-dark/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center backdrop-blur-sm">
                        <span class="text-brand-dark bg-white/90 px-5 py-2 rounded-full text-xs font-bold shadow-lg flex items-center gap-2">
                            <i class="fas fa-expand"></i> Lihat Detail
                        </span>
                    </div>
                </div>
                
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="font-bold text-lg text-brand-dark line-clamp-1 mb-1 hover:text-brand-primary cursor-pointer transition" @click="selectedItem = {{ $doc }}; detailModal = true">
                        {{ $doc->title }}
                    </h3>
                    
                    <div class="flex items-center text-xs text-gray-500 mb-3 font-medium">
                        <i class="fas fa-user-circle mr-1.5 text-brand-primary text-sm"></i> 
                        <span class="truncate max-w-[150px]">{{ $doc->author_name }}</span>
                        <span class="mx-2 text-gray-300">•</span>
                        <span>{{ $doc->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <p class="text-gray-600 text-sm line-clamp-2 mb-4 flex-grow leading-relaxed">{{ $doc->description }}</p>
                    
                    <div class="pt-4 border-t border-brand-light/30 flex justify-between items-center mt-auto">
                        <button @click="selectedItem = {{ $doc }}; detailModal = true" class="text-brand-primary font-bold text-xs hover:text-brand-dark transition-colors">
                            Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                        </button>

                        @if(Auth::check() && (Auth::user()->role === 'admin' || Auth::id() == $doc->user_id))
                        <div class="flex gap-2">
                            @if(Auth::user()->role === 'admin' && $doc->status == 'pending')
                                <a href="{{ route('admin.approve', ['doc', $doc->id]) }}" class="text-brand-primary bg-brand-primary/10 hover:bg-brand-primary hover:text-white rounded-md p-1.5 transition" title="Approve">
                                    <i class="fas fa-check w-4 h-4 flex items-center justify-center"></i>
                                </a>
                            @endif
                            
                            <button @click="selectedItem = {{ $doc }}; editDocModal = true" class="text-gray-400 bg-gray-50 hover:bg-brand-secondary hover:text-brand-dark rounded-md p-1.5 transition">
                                <i class="fas fa-edit w-4 h-4 flex items-center justify-center"></i>
                            </button>
                            <form action="{{ route('doc.delete', $doc->id) }}" method="POST" onsubmit="return confirm('Hapus dokumentasi ini?')" class="inline">
                                @csrf @method('DELETE')
                                <button class="text-gray-400 bg-gray-50 hover:bg-red-500 hover:text-white rounded-md p-1.5 transition">
                                    <i class="fas fa-trash w-4 h-4 flex items-center justify-center"></i>
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-16 bg-white rounded-2xl border border-dashed border-brand-light/50">
                <div class="text-brand-primary mb-3 bg-brand-primary/10 w-16 h-16 rounded-full flex items-center justify-center mx-auto"><i class="fas fa-images text-2xl"></i></div>
                <h3 class="text-lg font-bold text-brand-dark">Belum ada dokumentasi</h3>
                <p class="text-gray-500 text-sm mt-1">Jadilah yang pertama membagikan momen magangmu!</p>
            </div>
            @endforelse
        </div>

        <div class="mt-12 text-center" data-aos="fade-up">
            <a href="{{ route('docs.index') }}" target="_blank" class="inline-flex items-center justify-center px-8 py-3 border-2 border-brand-primary text-sm font-bold rounded-full text-brand-primary bg-transparent hover:bg-brand-primary hover:text-white transition-all duration-300 shadow-sm hover:shadow-lg hover:shadow-brand-primary/20">
                Lihat Semua Dokumentasi <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>