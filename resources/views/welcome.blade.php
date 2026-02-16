<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magang Tonasa - Portal Kreatif</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
        .hero-bg {
            background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1581094794329-cd56b5095a8e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <nav class="fixed w-full z-50 transition-all duration-300 glass-effect shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <span class="font-bold text-2xl text-blue-800 tracking-wider">MAGANG<span class="text-green-600">TONASA</span></span>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#home" class="text-gray-700 hover:text-blue-600 font-medium transition">Beranda</a>
                    <a href="#about" class="text-gray-700 hover:text-blue-600 font-medium transition">Tentang</a>
                    <a href="#gallery" class="text-gray-700 hover:text-blue-600 font-medium transition">Galeri</a>
                    <a href="#projects" class="text-gray-700 hover:text-blue-600 font-medium transition">Projek</a>
                    <a href="#contact" class="text-gray-700 hover:text-blue-600 font-medium transition">Kontak</a>
                </div>
            </div>
        </div>
    </nav>

    <section id="home" class="h-screen hero-bg flex items-center justify-center text-white relative">
        <div class="text-center px-4" data-aos="fade-up" data-aos-duration="1000">
            <h1 class="text-5xl md:text-7xl font-bold mb-4 drop-shadow-lg">Inovasi Magang Tonasa</h1>
            <p class="text-xl md:text-2xl mb-8 font-light tracking-wide">Membangun Masa Depan, Menciptakan Karya Nyata.</p>
            <a href="#about" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-full transition transform hover:scale-105 shadow-lg">Jelajahi Kami</a>
        </div>
        <div class="absolute bottom-10 w-full text-center animate-bounce">
            <a href="#about" class="text-white"><i class="fas fa-chevron-down text-3xl"></i></a>
        </div>
    </section>

    @if(session('success'))
    <div class="fixed top-20 right-5 z-50 bg-green-500 text-white px-6 py-4 rounded-lg shadow-xl" x-data="{show: true}" x-show="show">
        <div class="flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button @click="show = false" class="ml-4"><i class="fas fa-times"></i></button>
        </div>
    </div>
    @endif

    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center gap-12">
                <div class="md:w-1/2" data-aos="fade-right">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Tim Magang" class="rounded-lg shadow-2xl hover:grayscale transition duration-500">
                </div>
                <div class="md:w-1/2" data-aos="fade-left">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 border-l-4 border-blue-600 pl-4">Tentang Magang di Tonasa</h2>
                    <p class="text-lg text-gray-600 leading-relaxed mb-6">
                        Program magang di PT Semen Tonasa bukan hanya sekadar bekerja, tetapi sebuah perjalanan untuk mengembangkan potensi diri. Kami berkolaborasi, belajar teknologi industri terkini, dan menciptakan solusi digital yang bermanfaat.
                    </p>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Di sini, setiap ide dihargai dan setiap karya diapresiasi. Platform ini adalah bukti nyata dedikasi para pemagang.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="gallery" class="py-20 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div data-aos="fade-right">
                    <h2 class="text-4xl font-bold text-gray-900">Dokumentasi Kegiatan</h2>
                    <p class="text-gray-500 mt-2">Momen-momen berharga selama magang.</p>
                </div>
                <button onclick="document.getElementById('modalDoc').classList.remove('hidden')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow-md" data-aos="fade-left">
                    <i class="fas fa-plus mr-2"></i> Tambah Foto
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($docs as $doc)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 transform hover:-translate-y-2" data-aos="fade-up">
                    <div class="h-64 overflow-hidden relative group">
                        <img src="{{ asset($doc->image_path) }}" alt="{{ $doc->title }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <span class="text-white font-bold text-lg">Oleh: {{ $doc->author_name }}</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">{{ $doc->title }}</h3>
                        <p class="text-gray-600 mb-4 line-clamp-3">{{ \Illuminate\Support\Str::limit($doc->description, 100) }}</p>
                        <div x-data="{ open: false }">
                            <button @click="open = true" class="text-blue-600 font-semibold hover:underline">Read More &rarr;</button>
                            
                            <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75 p-4" x-cloak>
                                <div @click.away="open = false" class="bg-white rounded-lg max-w-2xl w-full p-6 relative overflow-y-auto max-h-[90vh]">
                                    <button @click="open = false" class="absolute top-4 right-4 text-gray-600 hover:text-red-500"><i class="fas fa-times fa-lg"></i></button>
                                    <img src="{{ asset($doc->image_path) }}" class="w-full h-80 object-cover rounded-lg mb-4">
                                    <h3 class="text-2xl font-bold mb-2">{{ $doc->title }}</h3>
                                    <p class="text-gray-500 text-sm mb-4">Diupload oleh: {{ $doc->author_name }}</p>
                                    <p class="text-gray-700 leading-relaxed">{{ $doc->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="projects" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div data-aos="fade-right">
                    <h2 class="text-4xl font-bold text-gray-900">Hasil Karya Web</h2>
                    <p class="text-gray-500 mt-2">Inovasi digital yang telah dibuat oleh para pemagang.</p>
                </div>
                <button onclick="document.getElementById('modalProject').classList.remove('hidden')" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition shadow-md" data-aos="fade-left">
                    <i class="fas fa-laptop-code mr-2"></i> Tambah Projek
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                @foreach($projects as $project)
                <div class="flex flex-col md:flex-row bg-gray-50 rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition" data-aos="flip-up">
                    <div class="md:w-2/5 h-64 md:h-auto overflow-hidden">
                         <img src="{{ asset($project->thumbnail_path) }}" class="w-full h-full object-cover">
                    </div>
                    <div class="md:w-3/5 p-8 flex flex-col justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $project->title }}</h3>
                            <p class="text-sm text-gray-500 mb-4">Dev: {{ $project->author_name }}</p>
                            <p class="text-gray-600 mb-6">{{ $project->description }}</p>
                        </div>
                        <a href="{{ $project->project_url }}" target="_blank" class="inline-block bg-gray-900 text-white text-center py-2 rounded-lg hover:bg-gray-700 transition">
                            Kunjungi Website <i class="fas fa-external-link-alt ml-2"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="contact" class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-8">Informasi Pembuat</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="p-4" data-aos="zoom-in" data-aos-delay="100">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold">Creator</h3>
                    <p class="text-gray-400 mt-2">Nama Kamu Disini</p>
                </div>
                <div class="p-4" data-aos="zoom-in" data-aos-delay="200">
                    <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold">Email</h3>
                    <p class="text-gray-400 mt-2">emailmu@example.com</p>
                </div>
                <div class="p-4" data-aos="zoom-in" data-aos-delay="300">
                    <div class="w-16 h-16 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-phone text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold">WhatsApp/Telp</h3>
                    <p class="text-gray-400 mt-2">0812-XXXX-XXXX</p>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-800 pt-8 text-gray-500 text-sm">
                &copy; 2024 Magang Tonasa. All Rights Reserved.
            </div>
        </div>
    </section>

    <div id="modalDoc" class="fixed inset-0 z-[60] hidden bg-black bg-opacity-80 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold">Tambah Foto Dokumentasi</h3>
                <button onclick="document.getElementById('modalDoc').classList.add('hidden')" class="text-gray-600"><i class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('submit.doc') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" name="author_name" placeholder="Nama Kamu" class="w-full border p-2 mb-3 rounded" required>
                <input type="text" name="title" placeholder="Judul Foto" class="w-full border p-2 mb-3 rounded" required>
                <textarea name="description" placeholder="Deskripsi Detail..." class="w-full border p-2 mb-3 rounded" rows="3" required></textarea>
                <input type="file" name="image" class="w-full mb-3" required accept="image/*">
                <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">Kirim untuk Review</button>
            </form>
        </div>
    </div>

    <div id="modalProject" class="fixed inset-0 z-[60] hidden bg-black bg-opacity-80 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold">Tambah Projek Web</h3>
                <button onclick="document.getElementById('modalProject').classList.add('hidden')" class="text-gray-600"><i class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('submit.project') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" name="author_name" placeholder="Nama Developer" class="w-full border p-2 mb-3 rounded" required>
                <input type="text" name="title" placeholder="Nama Aplikasi/Web" class="w-full border p-2 mb-3 rounded" required>
                <input type="url" name="project_url" placeholder="Link Website (http://...)" class="w-full border p-2 mb-3 rounded" required>
                <textarea name="description" placeholder="Deskripsi Fitur..." class="w-full border p-2 mb-3 rounded" rows="3" required></textarea>
                <label class="block text-sm text-gray-600 mb-1">Thumbnail Web:</label>
                <input type="file" name="thumbnail" class="w-full mb-3" required accept="image/*">
                <button type="submit" class="w-full bg-green-600 text-white p-2 rounded hover:bg-green-700">Kirim untuk Review</button>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>