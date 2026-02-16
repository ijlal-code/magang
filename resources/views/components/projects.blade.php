<section id="projects" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-4xl font-bold text-gray-900 mb-10" data-aos="fade-right">Showcase Projek</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($projects as $proj)
            <div class="bg-white border rounded-xl shadow-sm hover:shadow-lg transition overflow-hidden relative" data-aos="flip-up">
                
                @if($proj->status == 'pending')
                    <div class="absolute top-2 right-2 bg-yellow-400 text-yellow-900 text-xs font-bold px-2 py-1 rounded z-10">PENDING</div>
                @endif

                <img src="{{ asset($proj->thumbnail_path) }}" class="w-full h-40 object-cover">
                <div class="p-5">
                    <h3 class="font-bold text-xl mb-1">{{ $proj->title }}</h3>
                    <p class="text-xs text-green-600 mb-3">Dev: {{ $proj->author_name }}</p>
                    <p class="text-gray-600 text-sm mb-4">{{ $proj->description }}</p>
                    
                    <div class="flex justify-between items-center">
                        <a href="{{ $proj->project_url }}" target="_blank" class="bg-green-600 text-white text-xs px-3 py-1.5 rounded hover:bg-green-700">Visit Web</a>
                        
                        <div class="flex items-center space-x-2">
                             @if($isAdmin && $proj->status == 'pending')
                                <a href="{{ route('admin.approve', ['project', $proj->id]) }}" class="text-xs bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">Approve</a>
                            @endif

                            @if($isAdmin || (Auth::check() && Auth::id() == $proj->user_id))
                                <button @click="selectedItem = {{ $proj }}; editProjectModal = true" class="text-gray-500 hover:text-blue-600"><i class="fas fa-edit"></i></button>
                                <form action="{{ route('project.delete', $proj->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                    @csrf @method('DELETE')
                                    <button class="text-gray-500 hover:text-red-600"><i class="fas fa-trash"></i></button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>