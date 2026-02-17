<section id="projects" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-10">
            <h2 class="text-4xl font-bold text-gray-900" data-aos="fade-right">Showcase Projek</h2>
            <button @click="uploadProjectModal = true" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow-lg transition transform hover:-translate-y-1" data-aos="fade-left">
                <i class="fas fa-code mr-2"></i> Upload Projek
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($projects as $proj)
            <div class="bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-lg transition overflow-hidden relative group" data-aos="flip-up">
                
                @if($proj->status == 'pending')
                    <div class="absolute top-2 right-2 bg-yellow-400 text-yellow-900 text-xs font-bold px-2 py-1 rounded z-10 shadow">PENDING</div>
                @endif

                <div class="h-40 overflow-hidden relative">
                    <img src="{{ asset($proj->thumbnail_path) }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                    <a href="{{ $proj->project_url }}" target="_blank" class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition flex items-center justify-center opacity-0 group-hover:opacity-100">
                        <span class="bg-white text-gray-900 px-4 py-2 rounded-full font-bold text-sm shadow">Kunjungi Website <i class="fas fa-external-link-alt ml-1"></i></span>
                    </a>
                </div>

                <div class="p-5">
                    <h3 class="font-bold text-xl mb-1 text-gray-800">{{ $proj->title }}</h3>
                    <p class="text-xs text-green-600 mb-3 font-semibold"><i class="fas fa-laptop-code mr-1"></i> {{ $proj->author_name }}</p>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $proj->description }}</p>
                    
                    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                         <a href="{{ $proj->project_url }}" target="_blank" class="text-green-600 hover:text-green-800 text-sm font-bold">
                            Visit Link <i class="fas fa-chevron-right ml-1"></i>
                        </a>
                        
                        <div class="flex items-center space-x-2">
                             @if(Auth::check() && Auth::user()->role === 'admin' && $proj->status == 'pending')
                                <a href="{{ route('admin.approve', ['project', $proj->id]) }}" class="text-xs bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600" title="Setujui">Approve</a>
                            @endif

                            @if(Auth::check() && (Auth::user()->role === 'admin' || Auth::id() == $proj->user_id))
                                <button @click="selectedItem = {{ $proj }}; editProjectModal = true" class="text-gray-400 hover:text-blue-600 transition"><i class="fas fa-edit"></i></button>
                                <form action="{{ route('project.delete', $proj->id) }}" method="POST" onsubmit="return confirm('Hapus projek ini?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="text-gray-400 hover:text-red-600 transition"><i class="fas fa-trash"></i></button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-10 text-gray-500">
                <i class="fas fa-code-branch text-4xl mb-3 text-gray-300"></i>
                <p>Belum ada projek yang dipamerkan.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>