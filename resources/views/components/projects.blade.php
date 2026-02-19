<section id="projects" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
            <div class="w-full md:w-auto text-center md:text-left">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900" data-aos="fade-right">Showcase Projek</h2>
                <p class="mt-2 text-gray-600 text-sm md:text-base" data-aos="fade-right" data-aos-delay="100">
                    Karya inovatif aplikasi & website peserta magang.
                </p>
            </div>

            <button @click="uploadProjectModal = true" class="w-full md:w-auto bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-full shadow-lg transition transform hover:-translate-y-1 flex items-center justify-center gap-2 font-semibold text-sm">
                <i class="fas fa-laptop-code"></i> <span>Upload Projek</span>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @forelse($projects as $proj)
            <div class="bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-xl transition-shadow duration-300 flex flex-col overflow-hidden group h-full" data-aos="fade-up">
                
                <div class="h-48 overflow-hidden relative bg-gray-100">
                    @if($proj->status == 'pending')
                        <div class="absolute top-3 right-3 bg-yellow-400 text-white text-[10px] font-bold px-2 py-1 rounded shadow z-10">
                            PENDING
                        </div>
                    @endif

                    <img src="{{ asset($proj->thumbnail_path) }}" 
                         alt="{{ $proj->title }}"
                         loading="lazy"
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 cursor-pointer"
                         @click="selectedItem = {{ $proj }}; detailModal = true"
                         onerror="this.src='https://via.placeholder.com/800x400?text=Project+Thumbnail'">
                    
                    <a href="{{ $proj->project_url }}" target="_blank" class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <span class="bg-white text-gray-900 px-4 py-2 rounded-full font-bold text-xs shadow-lg hover:bg-gray-100 flex items-center gap-2 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                            Kunjungi Web <i class="fas fa-external-link-alt"></i>
                        </span>
                    </a>
                </div>

                <div class="p-5 flex flex-col flex-grow">
                    <h3 class="font-bold text-lg text-gray-800 line-clamp-1 mb-2 hover:text-green-600 cursor-pointer transition" @click="selectedItem = {{ $proj }}; detailModal = true">
                        {{ $proj->title }}
                    </h3>

                    <div class="flex items-center text-xs text-green-700 mb-3 bg-green-50 w-fit px-2 py-1 rounded">
                        <i class="fas fa-code mr-2"></i> 
                        <span class="font-semibold">{{ $proj->author_name }}</span>
                    </div>
                    
                    <p class="text-gray-600 text-sm line-clamp-3 mb-4 flex-grow">{{ $proj->description }}</p>
                    
                    <div class="mt-auto pt-3 flex justify-between items-center border-t border-gray-100">
                        <button @click="selectedItem = {{ $proj }}; detailModal = true" class="text-gray-500 hover:text-green-600 text-xs font-semibold flex items-center gap-1 transition">
                            <i class="far fa-eye"></i> Detail Info
                        </button>
                        
                        @if(Auth::check() && (Auth::user()->role === 'admin' || Auth::id() == $proj->user_id))
                        <div class="flex items-center gap-2">
                            @if(Auth::user()->role === 'admin' && $proj->status == 'pending')
                                <a href="{{ route('admin.approve', ['project', $proj->id]) }}" class="text-blue-500 hover:text-blue-700 p-1">
                                    <i class="fas fa-check-circle"></i>
                                </a>
                            @endif

                            <button @click="selectedItem = {{ $proj }}; editProjectModal = true" class="text-gray-400 hover:text-blue-600 p-1 transition">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('project.delete', $proj->id) }}" method="POST" onsubmit="event.preventDefault(); confirmDelete(this, 'Hapus karya ini secara permanen?');" class="inline">
                                @csrf @method('DELETE')
                                <button class="text-gray-400 hover:text-red-600 p-1 transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <div class="inline-block p-3 bg-green-50 rounded-full mb-3 text-green-400">
                    <i class="fas fa-laptop-code text-2xl"></i>
                </div>
                <p class="text-gray-500 text-sm font-medium">Belum ada projek yang dipamerkan.</p>
            </div>
            @endforelse
        </div>
        
        <div class="mt-12 text-center" data-aos="fade-up">
            <a href="{{ route('projects.index') }}" target="_blank" class="inline-flex items-center justify-center px-8 py-3 border border-green-600 text-sm font-bold rounded-full text-green-600 bg-white hover:bg-green-50 transition duration-300 shadow-sm hover:shadow-md">
                Eksplorasi Semua Projek <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>

    </div>
</section>