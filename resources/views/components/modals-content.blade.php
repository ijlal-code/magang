<div x-show="uploadDocModal" class="fixed inset-0 z-[60] flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-sm p-4 sm:p-6" x-cloak>
    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-lg relative max-h-[90vh] overflow-y-auto" @click.away="uploadDocModal = false">
        <button @click="uploadDocModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition"><i class="fas fa-times text-xl"></i></button>
        
        <h3 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">Upload Foto Dokumentasi</h3>
        
        <form action="{{ route('doc.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            @auth
                <div class="bg-blue-50 border border-blue-100 p-3 rounded-lg flex items-center text-sm text-blue-800">
                    <i class="fas fa-user-check mr-2 text-lg"></i>
                    <div>
                        <p>Mengupload sebagai: <span class="font-bold">{{ Auth::user()->name }}</span></p>
                        <p class="text-xs opacity-75">Status: {{ Auth::user()->role === 'admin' || Auth::user()->can_post_directly ? 'Langsung Terbit (Approved)' : 'Menunggu Persetujuan Admin' }}</p>
                    </div>
                </div>
            @else
                <div x-data="{ anon: false }" class="bg-gray-50 border border-gray-200 p-3 rounded-lg transition-all duration-300">
                    <div class="flex items-center mb-2">
                        <input type="checkbox" id="anonCheckDoc" name="is_anonymous" x-model="anon" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="anonCheckDoc" class="ml-2 text-sm font-medium text-gray-700 cursor-pointer select-none">
                            Posting sebagai Anonim (Tanpa Login)
                        </label>
                    </div>
                    
                    <div x-show="!anon" class="text-xs text-gray-500 mt-1 pl-6">
                        * Centang box di atas untuk menyembunyikan identitas Anda.
                    </div>

                    <div x-show="anon" x-transition class="mt-2 pl-6 text-sm text-green-600 font-semibold flex items-center">
                        <i class="fas fa-user-secret mr-2"></i> Nama Anda akan diset otomatis menjadi "Anonim".
                    </div>
                </div>
            @endauth

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Kegiatan</label>
                <input type="text" name="title" class="w-full border p-2 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto Dokumentasi</label>
                <input type="file" name="image" class="w-full text-sm border p-2 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" required accept="image/*">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full border p-2 rounded-lg focus:ring-blue-500 focus:border-blue-500" required></textarea>
            </div>
            
            <button class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition shadow-lg flex justify-center items-center">
                <i class="fas fa-paper-plane mr-2"></i> Kirim Upload
            </button>
        </form>
    </div>
</div>

<div x-show="uploadProjectModal" class="fixed inset-0 z-[60] flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-sm p-4 sm:p-6" x-cloak>
    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-lg relative max-h-[90vh] overflow-y-auto" @click.away="uploadProjectModal = false">
        <button @click="uploadProjectModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition"><i class="fas fa-times text-xl"></i></button>
        
        <h3 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">Upload Projek Web</h3>
        
        <form action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            @auth
                <div class="bg-green-50 border border-green-100 p-3 rounded-lg flex items-center text-sm text-green-800">
                    <i class="fas fa-laptop-code mr-2 text-lg"></i>
                    <div>
                        <p>Developer: <span class="font-bold">{{ Auth::user()->name }}</span></p>
                        <p class="text-xs opacity-75">Status: {{ Auth::user()->role === 'admin' || Auth::user()->can_post_directly ? 'Langsung Terbit' : 'Menunggu Approval' }}</p>
                    </div>
                </div>
            @else
                <div x-data="{ anon: false }" class="bg-gray-50 border border-gray-200 p-3 rounded-lg transition-all duration-300">
                    <div class="flex items-center mb-2">
                        <input type="checkbox" id="anonCheckProj" name="is_anonymous" x-model="anon" class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        <label for="anonCheckProj" class="ml-2 text-sm font-medium text-gray-700 cursor-pointer select-none">
                            Posting sebagai Anonim (Tanpa Login)
                        </label>
                    </div>
                    
                    <div x-show="!anon" class="text-xs text-gray-500 mt-1 pl-6">
                        * Centang box di atas untuk menyembunyikan identitas Anda.
                    </div>

                    <div x-show="anon" x-transition class="mt-2 pl-6 text-sm text-green-600 font-semibold flex items-center">
                        <i class="fas fa-user-secret mr-2"></i> Nama Pengembang akan diset otomatis menjadi "Anonim".
                    </div>
                </div>
            @endauth

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Aplikasi / Web</label>
                <input type="text" name="title" class="w-full border p-2 rounded-lg focus:ring-green-500 focus:border-green-500" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Link URL</label>
                <input type="url" name="project_url" placeholder="https://" class="w-full border p-2 rounded-lg focus:ring-green-500 focus:border-green-500" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Thumbnail Web</label>
                <input type="file" name="thumbnail" class="w-full text-sm border p-2 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer" required accept="image/*">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Fitur</label>
                <textarea name="description" rows="3" class="w-full border p-2 rounded-lg focus:ring-green-500 focus:border-green-500" required></textarea>
            </div>
            
            <button class="w-full bg-green-600 text-white py-3 rounded-lg font-bold hover:bg-green-700 transition shadow-lg flex justify-center items-center">
                <i class="fas fa-upload mr-2"></i> Kirim Projek
            </button>
        </form>
    </div>
</div>

<div x-show="detailModal" class="fixed inset-0 z-[70] flex items-center justify-center bg-black bg-opacity-90 backdrop-blur-sm p-4" x-cloak>
    <div class="bg-white rounded-lg max-w-4xl w-full relative overflow-hidden flex flex-col max-h-[90vh]" @click.away="detailModal = false">
        
        <div class="p-4 border-b flex justify-between items-center bg-gray-50">
            <h3 class="font-bold text-lg text-gray-700">Detail Dokumentasi / Projek</h3>
            <button @click="detailModal = false" class="text-gray-400 hover:text-red-600 transition text-2xl"><i class="fas fa-times"></i></button>
        </div>

        <div class="overflow-y-auto p-6">
            <div class="w-full bg-gray-100 rounded-lg overflow-hidden mb-6 flex justify-center items-center shadow-inner min-h-[200px]">
                
                {{-- PERBAIKAN DISINI: Gunakan template x-if --}}
                {{-- Gambar hanya akan dirender jika selectedItem memiliki data path --}}
                <template x-if="selectedItem.image_path || selectedItem.thumbnail_path">
                    <img :src="'{{ asset('') }}' + (selectedItem.image_path ? selectedItem.image_path : selectedItem.thumbnail_path)" 
                         class="max-w-full max-h-[60vh] object-contain" 
                         alt="Detail Image"
                         onerror="this.onerror=null; this.src='https://via.placeholder.com/800x400?text=Gambar+Tidak+Ditemukan'">
                </template>

                {{-- Tampilkan loading/placeholder jika data belum siap --}}
                <template x-if="!selectedItem.image_path && !selectedItem.thumbnail_path">
                    <div class="text-gray-400 text-sm flex flex-col items-center">
                        <i class="fas fa-image text-3xl mb-2 opacity-50"></i>
                        <span>Menunggu gambar...</span>
                    </div>
                </template>

            </div>
            
            <h3 x-text="selectedItem.title" class="text-3xl font-bold mb-2 text-gray-900"></h3>
            
            <div class="flex items-center mb-6 text-gray-500 text-sm border-b pb-4">
                <i class="fas fa-user-circle mr-2 text-blue-500"></i> <span x-text="'Diunggah oleh: ' + selectedItem.author_name"></span>
                <span class="mx-2">•</span>
                {{-- Tambahkan pengecekan if untuk tanggal agar tidak error saat kosong --}}
                <span x-text="selectedItem.created_at ? new Date(selectedItem.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : '-'"></span>
            </div>
            
            <div class="prose max-w-none text-gray-700 leading-relaxed text-lg mb-4">
                <p x-text="selectedItem.description" class="whitespace-pre-line"></p>
            </div>

            <div x-show="selectedItem.project_url" class="mt-6 pt-4 border-t">
                <a :href="selectedItem.project_url" target="_blank" class="inline-flex items-center justify-center w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg transition shadow-lg">
                    Kunjungi Website <i class="fas fa-external-link-alt ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div x-show="editDocModal" class="fixed inset-0 z-[60] flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-sm p-4 sm:p-6" x-cloak>
    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-lg relative max-h-[90vh] overflow-y-auto" @click.away="editDocModal = false">
        <button @click="editDocModal = false" class="absolute top-4 right-4 text-gray-400"><i class="fas fa-times"></i></button>
        <h3 class="text-xl font-bold mb-4">Edit Dokumentasi</h3>
        <form :action="'/doc/update/' + selectedItem.id" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')
            <input type="text" name="title" x-model="selectedItem.title" class="w-full border p-2 rounded-lg">
            <div>
                <p class="text-xs text-gray-500 mb-1">Ganti gambar (opsional):</p>
                <input type="file" name="image" class="w-full text-sm border p-2 rounded-lg">
            </div>
            <textarea name="description" x-model="selectedItem.description" class="w-full border p-2 rounded-lg" rows="4"></textarea>
            <button class="w-full bg-yellow-500 text-white py-2 rounded-lg font-bold hover:bg-yellow-600">Simpan Perubahan</button>
        </form>
    </div>
</div>

<div x-show="editProjectModal" class="fixed inset-0 z-[60] flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-sm p-4 sm:p-6" x-cloak>
    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-lg relative max-h-[90vh] overflow-y-auto" @click.away="editProjectModal = false">
        <button @click="editProjectModal = false" class="absolute top-4 right-4 text-gray-400"><i class="fas fa-times"></i></button>
        <h3 class="text-xl font-bold mb-4">Edit Projek</h3>
        <form :action="'/project/update/' + selectedItem.id" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')
            <input type="text" name="title" x-model="selectedItem.title" class="w-full border p-2 rounded-lg">
            <input type="url" name="project_url" x-model="selectedItem.project_url" class="w-full border p-2 rounded-lg">
            <div>
                <p class="text-xs text-gray-500 mb-1">Ganti thumbnail (opsional):</p>
                <input type="file" name="thumbnail" class="w-full text-sm border p-2 rounded-lg">
            </div>
            <textarea name="description" x-model="selectedItem.description" class="w-full border p-2 rounded-lg" rows="4"></textarea>
            <button class="w-full bg-yellow-500 text-white py-2 rounded-lg font-bold hover:bg-yellow-600">Simpan Perubahan</button>
        </form>
    </div>
</div>