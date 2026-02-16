<section id="home" class="h-screen hero-bg flex items-center justify-center text-white relative">
    <div class="text-center px-4" data-aos="fade-up">
        <h1 class="text-5xl md:text-7xl font-bold mb-4 drop-shadow-lg">Inovasi Magang Tonasa</h1>
        <p class="text-xl md:text-2xl mb-8 font-light">Membangun Masa Depan, Menciptakan Karya.</p>
        
        @auth
            <div class="flex gap-4 justify-center">
                <button @click="uploadDocModal = true" class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg shadow-lg">
                    <i class="fas fa-camera mr-2"></i> Upload Foto
                </button>
                <button @click="uploadProjectModal = true" class="bg-green-600 hover:bg-green-700 text-white py-3 px-6 rounded-lg shadow-lg">
                    <i class="fas fa-code mr-2"></i> Upload Projek
                </button>
            </div>
        @else
            <button @click="registerModal = true" class="bg-white text-blue-800 font-bold py-3 px-8 rounded-full hover:bg-gray-100 transition shadow-lg">Gabung Sekarang</button>
        @endauth
    </div>
</section>