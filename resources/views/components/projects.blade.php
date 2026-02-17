<section id="projects" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-4xl font-bold text-gray-900" data-aos="fade-right">Showcase Projek</h2>
                <p class="mt-2 text-gray-600" data-aos="fade-right" data-aos-delay="100">Karya digital inovatif hasil peserta magang.</p>
            </div>

            <button @click="uploadProjectModal = true" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg shadow-lg transition transform hover:-translate-y-1 flex items-center gap-2" data-aos="fade-left">
                <i class="fas fa-laptop-code"></i> <span>Upload Projek</span>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($projects as $proj)
            <div class="bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-xl transition duration-300 flex flex-col overflow-hidden group relative" data-aos="flip-up">
                
                @if($proj->status == 'pending')
                    <div class="absolute top-3 right-3 bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-full shadow-md z-10 border border-yellow-500 animate-pulse">
                        <i class="fas fa-clock mr-1"></i> PENDING
                    </div>
                @endif

                <div class="h-48 overflow-hidden relative bg-gray-100">
                    <img src="{{ asset($proj->thumbnail_path) }}" 
                         alt="{{ $proj->title }}"
                         class="w-full h-full object-cover transition duration-700 group-hover:scale-105"
                         @click="selectedItem = {{ $proj }}; detailModal = true"
                         onerror="this.src='https://via.placeholder.com/800x400?text=No+Thumbnail'">
                    
                    <a href="{{ $proj->project_url }}" target="_blank" class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition flex items-center justify-center opacity-0 group-hover:opacity-100">
                        <div class="transform translate-y-4 group-hover:translate-y-0 transition duration-300">
                            <span class="bg-white text-gray-900 px-5 py-2 rounded-full font-bold text-sm shadow-lg hover:bg-gray-100 flex items-center gap-2">
                                Kunjungi Web <i class="fas fa-external-link-alt"></i>
                            </span>
                        </div>
                    </a>
                </div>

                <div class="p-5 flex flex-col flex-grow">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-bold text-xl text-gray-800 line-clamp-1 hover:text-green-600 transition cursor-pointer" @click="selectedItem = {{ $proj }}; detailModal = true">
                            {{ $proj->title }}
                        </h3>
                    </div>

                    <div class="flex items-center text-xs text-green-600 mb-3 font-semibold">
                        <i class="fas fa-code mr-1.5 text-lg"></i> {{ $proj->author_name }}
                    </div>
                    
                    <p class="text-gray-600 text-sm line-clamp-3 mb-4 flex-grow">{{ $proj->description }}</p>
                    
                    <div class="mt-auto pt-4 flex justify-between items-center border-t border-gray-100">
                        
                        <button @click="selectedItem = {{ $proj }}; detailModal = true" class="text-gray-500 hover:text-green-600 text-sm font-semibold flex items-center gap-1 transition">
                            <i class="far fa-eye"></i> Detail Info
                        </button>
                        
                        <div class="flex items-center gap-2">
                            @if(Auth::check() && Auth::user()->role === 'admin' && $proj->status == 'pending')
                                <a href="{{ route('admin.approve', ['project', $proj->id]) }}" class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition shadow-sm" title="Approve Project">
                                    <i class="fas fa-check"></i>
                                </a>
                            @endif

                            @if(Auth::check() && (Auth::user()->role === 'admin' || Auth::id() == $proj->user_id))
                                <button @click="selectedItem = {{ $proj }}; editProjectModal = true" class="text-gray-400 hover:text-blue-600 p-1 transition" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                
                                <form action="{{ route('project.delete', $proj->id) }}" method="POST" onsubmit="return confirm('Hapus projek ini secara permanen?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="text-gray-400 hover:text-red-600 p-1 transition" title="Hapus">
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
                <div class="bg-green-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-code-branch text-4xl text-green-400"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-700">Belum ada projek</h3>
                <p class="text-gray-500 text-sm mt-1">Pamerkan karya web atau aplikasimu di sini!</p>
                <button @click="uploadProjectModal = true" class="mt-4 text-green-600 hover:underline font-semibold">Upload Projek</button>
            </div>
            @endforelse
        </div>
    </div>
</section>