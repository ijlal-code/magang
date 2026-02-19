<div x-show="uploadDocModal" class="fixed inset-0 z-[60] flex items-center justify-center bg-brand-dark/80 backdrop-blur-sm p-4 sm:p-6" x-transition x-cloak>
    <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-lg relative max-h-[90vh] overflow-y-auto" @click.away="uploadDocModal = false">
        <button @click="uploadDocModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition"><i class="fas fa-times text-xl"></i></button>
        
        <h3 class="text-xl font-bold mb-4 text-brand-dark border-b border-brand-light/30 pb-2">Upload Foto Dokumentasi</h3>
        
        <form action="{{ route('doc.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4" 
            x-data="{ errorMsg: '', anon: false, isGuest: {{ Auth::check() ? 'false' : 'true' }} }" 
            @submit="
                if (isGuest && !anon) {
                    $event.preventDefault();
                    errorMsg = 'Peringatan: Anda belum login! Silakan login atau centang \'Posting sebagai Anonim\' untuk melanjutkan.';
                    return;
                }
                let file = $refs.fileInput.files[0];
                if(file && file.size > 5242880) {
                    $event.preventDefault();
                    errorMsg = 'Peringatan: Ukuran foto melebihi batas 5MB!';
                    return;
                }
            ">
            @csrf
            
            <div class="space-y-3">
                @auth
                    <div x-show="!anon" x-transition class="bg-brand-primary/10 border border-brand-primary/20 p-3 rounded-xl flex items-center text-sm text-brand-dark">
                        <i class="fas fa-user-check mr-3 text-brand-primary text-lg"></i>
                        <div>
                            <p>Mengupload sebagai: <span class="font-bold text-brand-primary">{{ Auth::user()->name }}</span></p>
                            <p class="text-xs opacity-75">Status: {{ Auth::user()->role === 'admin' || Auth::user()->can_post_directly ? 'Langsung Terbit (Approved)' : 'Menunggu Persetujuan Admin' }}</p>
                        </div>
                    </div>
                @endauth

                <div class="bg-gray-50 border border-gray-200 p-3 rounded-xl transition-all duration-300">
                    <div class="flex items-center mb-2">
                        <input type="checkbox" id="anonCheckDoc" name="is_anonymous" x-model="anon" @change="errorMsg = ''" class="w-4 h-4 text-brand-primary border-gray-300 rounded focus:ring-brand-primary">
                        <label for="anonCheckDoc" class="ml-2 text-sm font-medium text-gray-700 cursor-pointer select-none">
                            Posting sebagai Anonim {{ !Auth::check() ? '(Wajib jika belum Login)' : '' }}
                        </label>
                    </div>
                    
                    <div x-show="!anon && !isGuest" class="text-xs text-gray-500 mt-1 pl-6">
                        * Centang box di atas untuk menyembunyikan identitas Anda.
                    </div>

                    <div x-show="anon || isGuest" x-transition class="mt-2 pl-6">
                        <p x-show="anon" class="text-sm text-brand-primary font-bold flex items-center mb-1.5">
                            <i class="fas fa-user-secret mr-2"></i> Nama akan diset otomatis menjadi "Anonim".
                        </p>
                        <p class="text-xs text-red-500 bg-red-50 border border-red-100 p-2 rounded-lg font-semibold flex items-start leading-tight">
                            <i class="fas fa-exclamation-triangle mr-2 mt-0.5"></i>
                            Peringatan: Karena diunggah tanpa identitas akun, Anda TIDAK AKAN BISA mengedit atau menghapus foto ini di kemudian hari. Hubungi admin jika ingin menghapus atau edit
                        </p>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Judul Kegiatan</label>
                <input type="text" name="title" class="w-full border border-gray-300 p-2.5 rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-brand-primary outline-none transition" required>
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">
                    Foto Dokumentasi <span class="text-gray-400 text-xs font-normal ml-1">(Maksimal: 5MB)</span>
                </label>
                <input type="file" name="image" x-ref="fileInput" @change="errorMsg = ''" class="w-full text-sm border border-gray-300 p-2 rounded-xl file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-brand-primary/10 file:text-brand-primary hover:file:bg-brand-primary hover:file:text-white cursor-pointer transition-all" required accept="image/*">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full border border-gray-300 p-2.5 rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-brand-primary outline-none transition" required></textarea>
            </div>
            
            <p x-show="errorMsg" x-transition class="text-red-600 text-sm mt-2 font-bold flex items-center bg-red-50 border border-red-200 p-3 rounded-lg" style="display: none;">
                <i class="fas fa-exclamation-circle mr-2 text-lg"></i> <span x-text="errorMsg"></span>
            </p>

            <button class="w-full bg-brand-primary text-white py-3 rounded-xl font-bold hover:bg-brand-dark transition-all duration-300 shadow-lg shadow-brand-primary/30 flex justify-center items-center transform hover:-translate-y-0.5">
                <i class="fas fa-paper-plane mr-2"></i> Kirim Upload
            </button>
        </form>
    </div>
</div>

<div x-show="uploadProjectModal" class="fixed inset-0 z-[60] flex items-center justify-center bg-brand-dark/80 backdrop-blur-sm p-4 sm:p-6" x-transition x-cloak>
    <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-lg relative max-h-[90vh] overflow-y-auto" @click.away="uploadProjectModal = false">
        <button @click="uploadProjectModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition"><i class="fas fa-times text-xl"></i></button>
        
        <h3 class="text-xl font-bold mb-4 text-brand-dark border-b border-brand-light/30 pb-2">Upload Projek Web</h3>
        
        <form action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4" 
            x-data="{ errorMsg: '', anon: false, isGuest: {{ Auth::check() ? 'false' : 'true' }} }" 
            @submit="
                if (isGuest && !anon) {
                    $event.preventDefault();
                    errorMsg = 'Peringatan: Anda belum login! Silakan login atau centang \'Posting sebagai Anonim\' untuk melanjutkan.';
                    return;
                }
                let file = $refs.fileInput.files[0];
                if(file && file.size > 5242880) {
                    $event.preventDefault();
                    errorMsg = 'Peringatan: Ukuran thumbnail melebihi batas 5MB!';
                    return;
                }
            ">
            @csrf
            
            <div class="space-y-3">
                @auth
                    <div x-show="!anon" x-transition class="bg-brand-secondary/20 border border-brand-secondary/50 p-3 rounded-xl flex items-center text-sm text-brand-dark">
                        <i class="fas fa-laptop-code mr-3 text-brand-primary text-lg"></i>
                        <div>
                            <p>Developer: <span class="font-bold text-brand-primary">{{ Auth::user()->name }}</span></p>
                            <p class="text-xs opacity-75">Status: {{ Auth::user()->role === 'admin' || Auth::user()->can_post_directly ? 'Langsung Terbit' : 'Menunggu Approval' }}</p>
                        </div>
                    </div>
                @endauth

                <div class="bg-gray-50 border border-gray-200 p-3 rounded-xl transition-all duration-300">
                    <div class="flex items-center mb-2">
                        <input type="checkbox" id="anonCheckProj" name="is_anonymous" x-model="anon" @change="errorMsg = ''" class="w-4 h-4 text-brand-primary border-gray-300 rounded focus:ring-brand-primary">
                        <label for="anonCheckProj" class="ml-2 text-sm font-medium text-gray-700 cursor-pointer select-none">
                            Posting sebagai Anonim {{ !Auth::check() ? '(Wajib jika belum Login)' : '' }}
                        </label>
                    </div>
                    
                    <div x-show="!anon && !isGuest" class="text-xs text-gray-500 mt-1 pl-6">
                        * Centang box di atas untuk menyembunyikan identitas Anda.
                    </div>

                    <div x-show="anon || isGuest" x-transition class="mt-2 pl-6">
                        <p x-show="anon" class="text-sm text-brand-primary font-bold flex items-center mb-1.5">
                            <i class="fas fa-user-secret mr-2"></i> Nama akan diset otomatis menjadi "Anonim".
                        </p>
                        <p class="text-xs text-red-500 bg-red-50 border border-red-100 p-2 rounded-lg font-semibold flex items-start leading-tight">
                            <i class="fas fa-exclamation-triangle mr-2 mt-0.5"></i>
                            Peringatan: Karena diunggah tanpa identitas akun, Anda TIDAK AKAN BISA mengedit atau menghapus projek ini di kemudian hari.
                        </p>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Nama Aplikasi / Web</label>
                <input type="text" name="title" class="w-full border border-gray-300 p-2.5 rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-brand-primary outline-none transition" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Link URL</label>
                <input type="url" name="project_url" placeholder="https://" class="w-full border border-gray-300 p-2.5 rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-brand-primary outline-none transition" required>
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">
                    Thumbnail Web <span class="text-gray-400 text-xs font-normal ml-1">(Maksimal: 5MB)</span>
                </label>
                <input type="file" name="thumbnail" x-ref="fileInput" @change="errorMsg = ''" class="w-full text-sm border border-gray-300 p-2 rounded-xl file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-brand-secondary/30 file:text-brand-dark hover:file:bg-brand-secondary cursor-pointer transition-all" required accept="image/*">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Deskripsi Fitur</label>
                <textarea name="description" rows="3" class="w-full border border-gray-300 p-2.5 rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-brand-primary outline-none transition" required></textarea>
            </div>
            
            <p x-show="errorMsg" x-transition class="text-red-600 text-sm mt-2 font-bold flex items-center bg-red-50 border border-red-200 p-3 rounded-lg" style="display: none;">
                <i class="fas fa-exclamation-circle mr-2 text-lg"></i> <span x-text="errorMsg"></span>
            </p>

            <button class="w-full bg-brand-primary text-white py-3 rounded-xl font-bold hover:bg-brand-dark transition-all duration-300 shadow-lg shadow-brand-primary/30 flex justify-center items-center transform hover:-translate-y-0.5">
                <i class="fas fa-upload mr-2"></i> Kirim Projek
            </button>
        </form>
    </div>
</div>

<div x-show="detailModal" class="fixed inset-0 z-[70] flex items-center justify-center bg-brand-dark/90 backdrop-blur-sm p-4" x-transition x-cloak>
    <div class="bg-white rounded-2xl w-full md:w-fit md:min-w-[500px] max-w-5xl relative overflow-hidden flex flex-col max-h-[90vh] shadow-2xl" @click.away="detailModal = false">
        
        <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-brand-bg">
            <h3 class="font-bold text-xl text-brand-dark">Preview Detail</h3>
            <button @click="detailModal = false" class="text-gray-400 hover:text-red-500 hover:bg-red-50 w-8 h-8 rounded-full flex items-center justify-center transition-colors text-2xl"><i class="fas fa-times"></i></button>
        </div>

        <div class="overflow-y-auto p-6">
            <div class="w-fit mx-auto bg-brand-light/20 rounded-xl overflow-hidden mb-8 flex justify-center items-center border border-brand-light/50">
                
                <template x-if="selectedItem.image_path || selectedItem.thumbnail_path || selectedItem.img">
                    <img :src="selectedItem.img ? selectedItem.img : ('{{ asset('') }}' + (selectedItem.image_path ? selectedItem.image_path : selectedItem.thumbnail_path))" 
                         class="max-w-full max-h-[60vh] object-contain" 
                         alt="Detail Image"
                         onerror="this.onerror=null; this.src='https://via.placeholder.com/800x400?text=Gambar+Tidak+Ditemukan'">
                </template>

                <template x-if="!selectedItem.image_path && !selectedItem.thumbnail_path && !selectedItem.img">
                    <div class="text-gray-400 text-sm flex flex-col items-center p-10">
                        <i class="fas fa-image text-4xl mb-3 opacity-50"></i>
                        <span>Memuat gambar...</span>
                    </div>
                </template>

            </div>
            
            <div class="w-full">
                <h3 x-text="selectedItem.title" class="text-3xl font-extrabold mb-3 text-brand-dark"></h3>
                
                <div class="flex flex-wrap items-center gap-y-2 mb-6 text-gray-500 text-sm border-b border-gray-100 pb-5">
                    <div class="flex items-center mr-4">
                        <i class="fas fa-user-circle mr-2 text-brand-primary text-lg"></i> 
                        <span x-text="'Diunggah oleh: ' + (selectedItem.author_name || selectedItem.author)"></span>
                    </div>
                    <div class="flex items-center">
                        <i class="far fa-calendar-alt mr-2 text-brand-primary"></i>
                        <span x-text="selectedItem.date ? selectedItem.date : (selectedItem.created_at ? new Date(selectedItem.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : '-')"></span>
                    </div>
                </div>
                
                <div class="prose max-w-none text-gray-700 leading-relaxed text-lg mb-4">
                    <p x-text="selectedItem.desc || selectedItem.description" class="whitespace-pre-line"></p>
                </div>

                <div x-show="selectedItem.project_url" class="mt-8 pt-6 border-t border-gray-100">
                    <a :href="selectedItem.project_url" target="_blank" class="inline-flex items-center justify-center w-full sm:w-auto bg-brand-primary hover:bg-brand-dark text-white font-bold py-3.5 px-8 rounded-full transition-all shadow-lg shadow-brand-primary/30 transform hover:-translate-y-1">
                        Kunjungi Website <i class="fas fa-external-link-alt ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div x-show="editDocModal" class="fixed inset-0 z-[60] flex items-center justify-center bg-brand-dark/80 backdrop-blur-sm p-4 sm:p-6" x-transition x-cloak>
    <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-lg relative max-h-[90vh] overflow-y-auto" @click.away="editDocModal = false">
        <button @click="editDocModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-red-500"><i class="fas fa-times text-xl"></i></button>
        <h3 class="text-xl font-bold mb-4 text-brand-dark">Edit Dokumentasi</h3>
        <form :action="'/doc/update/' + selectedItem.id" method="POST" enctype="multipart/form-data" class="space-y-4" x-data="{ errorMsg: '' }" @submit="
            let file = $refs.editFileInput.files[0];
            if(file && file.size > 5242880) {
                $event.preventDefault();
                errorMsg = 'Peringatan: Ukuran foto baru melebihi batas 5MB!';
            }
        ">
            @csrf @method('PUT')
            <input type="text" name="title" x-model="selectedItem.title" class="w-full border border-gray-300 p-2.5 rounded-xl focus:ring-brand-primary focus:border-brand-primary">
            <div>
                <p class="text-sm text-gray-700 mb-1 font-bold">Ganti gambar (opsional): <span class="text-gray-400 text-xs font-normal ml-1">(Maksimal: 5MB)</span></p>
                <input type="file" name="image" x-ref="editFileInput" @change="errorMsg = ''" class="w-full text-sm border border-gray-300 p-2 rounded-xl">
                <p x-show="errorMsg" x-transition class="text-red-500 text-sm mt-2 font-bold flex items-center bg-red-50 p-2 rounded-lg" style="display: none;">
                    <i class="fas fa-exclamation-circle mr-2"></i> <span x-text="errorMsg"></span>
                </p>
            </div>
            <textarea name="description" x-model="selectedItem.description" class="w-full border border-gray-300 p-2.5 rounded-xl focus:ring-brand-primary focus:border-brand-primary" rows="4"></textarea>
            <button class="w-full bg-brand-secondary text-brand-dark py-3 rounded-xl font-bold hover:bg-brand-accent transition shadow-md">Simpan Perubahan</button>
        </form>
    </div>
</div>

<div x-show="editProjectModal" class="fixed inset-0 z-[60] flex items-center justify-center bg-brand-dark/80 backdrop-blur-sm p-4 sm:p-6" x-transition x-cloak>
    <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-lg relative max-h-[90vh] overflow-y-auto" @click.away="editProjectModal = false">
        <button @click="editProjectModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-red-500"><i class="fas fa-times text-xl"></i></button>
        <h3 class="text-xl font-bold mb-4 text-brand-dark">Edit Projek</h3>
        <form :action="'/project/update/' + selectedItem.id" method="POST" enctype="multipart/form-data" class="space-y-4" x-data="{ errorMsg: '' }" @submit="
            let file = $refs.editFileInput.files[0];
            if(file && file.size > 5242880) {
                $event.preventDefault();
                errorMsg = 'Peringatan: Ukuran thumbnail baru melebihi batas 5MB!';
            }
        ">
            @csrf @method('PUT')
            <input type="text" name="title" x-model="selectedItem.title" class="w-full border border-gray-300 p-2.5 rounded-xl focus:ring-brand-primary focus:border-brand-primary">
            <input type="url" name="project_url" x-model="selectedItem.project_url" class="w-full border border-gray-300 p-2.5 rounded-xl focus:ring-brand-primary focus:border-brand-primary">
            <div>
                <p class="text-sm text-gray-700 mb-1 font-bold">Ganti thumbnail (opsional): <span class="text-gray-400 text-xs font-normal ml-1">(Maksimal: 5MB)</span></p>
                <input type="file" name="thumbnail" x-ref="editFileInput" @change="errorMsg = ''" class="w-full text-sm border border-gray-300 p-2 rounded-xl">
                <p x-show="errorMsg" x-transition class="text-red-500 text-sm mt-2 font-bold flex items-center bg-red-50 p-2 rounded-lg" style="display: none;">
                    <i class="fas fa-exclamation-circle mr-2"></i> <span x-text="errorMsg"></span>
                </p>
            </div>
            <textarea name="description" x-model="selectedItem.description" class="w-full border border-gray-300 p-2.5 rounded-xl focus:ring-brand-primary focus:border-brand-primary" rows="4"></textarea>
            <button class="w-full bg-brand-secondary text-brand-dark py-3 rounded-xl font-bold hover:bg-brand-accent transition shadow-md">Simpan Perubahan</button>
        </form>
    </div>
</div>