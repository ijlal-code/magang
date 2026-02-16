<div x-show="uploadDocModal" class="fixed inset-0 z-[60] flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-sm" x-cloak>
    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-lg relative" @click.away="uploadDocModal = false">
        <button @click="uploadDocModal = false" class="absolute top-4 right-4"><i class="fas fa-times"></i></button>
        <h3 class="text-xl font-bold mb-4">Upload Foto Dokumentasi</h3>
        <form action="{{ route('doc.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="text" name="title" placeholder="Judul Kegiatan" class="w-full border p-2 rounded" required>
            <input type="file" name="image" class="w-full text-sm border p-2 rounded" required>
            <textarea name="description" placeholder="Deskripsi..." class="w-full border p-2 rounded" required></textarea>
            <button class="w-full bg-blue-600 text-white py-2 rounded">Upload</button>
        </form>
    </div>
</div>

<div x-show="editDocModal" class="fixed inset-0 z-[60] flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-sm" x-cloak>
    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-lg relative" @click.away="editDocModal = false">
        <button @click="editDocModal = false" class="absolute top-4 right-4"><i class="fas fa-times"></i></button>
        <h3 class="text-xl font-bold mb-4">Edit Dokumentasi</h3>
        <form :action="'/doc/update/' + selectedItem.id" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')
            <input type="text" name="title" x-model="selectedItem.title" class="w-full border p-2 rounded">
            <div class="text-xs text-gray-500">Upload gambar baru jika ingin mengganti</div>
            <input type="file" name="image" class="w-full text-sm border p-2 rounded">
            <textarea name="description" x-model="selectedItem.description" class="w-full border p-2 rounded" rows="4"></textarea>
            <button class="w-full bg-yellow-500 text-white py-2 rounded">Update Perubahan</button>
        </form>
    </div>
</div>

<div x-show="uploadProjectModal" class="fixed inset-0 z-[60] flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-sm" x-cloak>
    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-lg relative" @click.away="uploadProjectModal = false">
        <button @click="uploadProjectModal = false" class="absolute top-4 right-4"><i class="fas fa-times"></i></button>
        <h3 class="text-xl font-bold mb-4">Upload Projek Baru</h3>
        <form action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="text" name="title" placeholder="Nama Projek" class="w-full border p-2 rounded" required>
            <input type="url" name="project_url" placeholder="Link URL" class="w-full border p-2 rounded" required>
            <input type="file" name="thumbnail" class="w-full text-sm border p-2 rounded" required>
            <textarea name="description" placeholder="Deskripsi..." class="w-full border p-2 rounded" required></textarea>
            <button class="w-full bg-green-600 text-white py-2 rounded">Upload</button>
        </form>
    </div>
</div>

<div x-show="editProjectModal" class="fixed inset-0 z-[60] flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-sm" x-cloak>
    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-lg relative" @click.away="editProjectModal = false">
        <button @click="editProjectModal = false" class="absolute top-4 right-4"><i class="fas fa-times"></i></button>
        <h3 class="text-xl font-bold mb-4">Edit Projek</h3>
        <form :action="'/project/update/' + selectedItem.id" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')
            <input type="text" name="title" x-model="selectedItem.title" class="w-full border p-2 rounded">
            <input type="url" name="project_url" x-model="selectedItem.project_url" class="w-full border p-2 rounded">
            <div class="text-xs text-gray-500">Upload thumb baru jika ingin mengganti</div>
            <input type="file" name="thumbnail" class="w-full text-sm border p-2 rounded">
            <textarea name="description" x-model="selectedItem.description" class="w-full border p-2 rounded" rows="4"></textarea>
            <button class="w-full bg-yellow-500 text-white py-2 rounded">Update Perubahan</button>
        </form>
    </div>
</div>

<div x-show="detailModal" class="fixed inset-0 z-[70] flex items-center justify-center bg-black bg-opacity-90 backdrop-blur-sm" x-cloak>
    <div class="bg-white rounded-lg max-w-3xl w-full p-6 relative overflow-y-auto max-h-[90vh]" @click.away="detailModal = false">
        <button @click="detailModal = false" class="absolute top-4 right-4 text-red-500 text-2xl"><i class="fas fa-times"></i></button>
        <img :src="'{{ asset('') }}' + selectedItem.image_path" class="w-full h-80 object-cover rounded-lg mb-4 bg-gray-200">
        <h3 x-text="selectedItem.title" class="text-2xl font-bold mb-2"></h3>
        <p x-text="'Oleh: ' + selectedItem.author_name" class="text-gray-500 text-sm mb-4"></p>
        <p x-text="selectedItem.description" class="text-gray-700 leading-relaxed"></p>
    </div>
</div>