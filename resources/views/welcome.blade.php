<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magang Tonasa - Portal Kreatif</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        .hero-bg {
            background-image: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1581094794329-cd56b5095a8e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
        }

        /* --- CUSTOM CARD CSS DARI USER --- */
        .card {
            max-width: 100%; /* Disesuaikan agar responsif di grid */
            border-radius: 0.5rem;
            background-color: #fff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid #e5e7eb;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .card a.link-wrapper {
            text-decoration: none;
            color: inherit;
        }
        .content {
            padding: 1.1rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .image {
            object-fit: cover;
            width: 100%;
            height: 200px; /* Sedikit diperbesar */
            background-color: rgb(239, 205, 255);
        }
        .title {
            color: #111827;
            font-size: 1.125rem;
            line-height: 1.75rem;
            font-weight: 600;
        }
        .desc {
            margin-top: 0.5rem;
            color: #6B7280;
            font-size: 0.875rem;
            line-height: 1.25rem;
            flex-grow: 1;
        }
        .action {
            display: inline-flex;
            margin-top: 1rem;
            color: #ffffff;
            font-size: 0.875rem;
            line-height: 1.25rem;
            font-weight: 500;
            align-items: center;
            gap: 0.25rem;
            background-color: #2563EB;
            padding: 6px 12px;
            border-radius: 4px;
            width: fit-content;
            cursor: pointer;
        }
        .action span {
            transition: .3s ease;
        }
        .action:hover span {
            transform: translateX(4px);
        }
        .delete-btn {
            background-color: #EF4444; /* Merah */
            margin-left: auto;
        }
        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
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
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#home" class="hover:text-blue-600 transition">Beranda</a>
                    <a href="#about" class="hover:text-blue-600 transition">Tentang</a>
                    <a href="#gallery" class="hover:text-blue-600 transition">Galeri</a>
                    <a href="#projects" class="hover:text-blue-600 transition">Projek</a>
                    
                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center text-blue-700 font-semibold focus:outline-none">
                                <i class="fas fa-user-circle text-xl mr-2"></i> {{ Auth::user()->name }}
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50" x-cloak>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition shadow">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <section id="home" class="h-screen hero-bg flex items-center justify-center text-white relative">
        <div class="text-center px-4" data-aos="fade-up">
            <h1 class="text-5xl md:text-7xl font-bold mb-4 drop-shadow-lg">Inovasi Magang Tonasa</h1>
            <p class="text-xl md:text-2xl mb-8 font-light tracking-wide">Tunjukkan Karyamu, Bangun Masa Depan.</p>
            @auth
                <a href="#gallery" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-full transition shadow-lg">Lihat Karya</a>
            @else
                <a href="{{ route('register') }}" class="bg-white text-blue-800 font-bold py-3 px-8 rounded-full hover:bg-gray-100 transition shadow-lg">Gabung Sekarang</a>
            @endauth
        </div>
    </section>

    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center gap-12">
                <div class="md:w-1/2" data-aos="fade-right">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" class="rounded-2xl shadow-2xl">
                </div>
                <div class="md:w-1/2" data-aos="fade-left">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4 border-l-4 border-blue-600 pl-4">Tentang Platform Ini</h2>
                    <p class="text-lg text-gray-600 leading-relaxed mb-6">
                        Platform ini didedikasikan untuk para peserta magang di PT Semen Tonasa. Disini Anda dapat berbagi dokumentasi kegiatan sehari-hari dan memamerkan hasil projek web atau aplikasi yang telah Anda bangun.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-gray-700"><i class="fas fa-check-circle text-green-500 mr-2"></i> Upload Dokumentasi Kegiatan</li>
                        <li class="flex items-center text-gray-700"><i class="fas fa-check-circle text-green-500 mr-2"></i> Showcase Project Web</li>
                        <li class="flex items-center text-gray-700"><i class="fas fa-check-circle text-green-500 mr-2"></i> Terhubung dengan Mentor</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="gallery" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
                <div data-aos="fade-right">
                    <h2 class="text-4xl font-bold text-gray-900">Galeri Dokumentasi</h2>
                    <p class="text-gray-500 mt-2">Momen seru selama kegiatan magang.</p>
                </div>
                <button onclick="openModal('modalDoc')" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition shadow-lg transform hover:-translate-y-1" data-aos="fade-left">
                    <i class="fas fa-camera mr-2"></i> Tambah Foto
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($docs as $doc)
                <div class="card" data-aos="fade-up">
                    <img src="{{ asset($doc->image_path) }}" class="image" alt="{{ $doc->title }}">
                    <div class="content">
                        <span class="title">{{ $doc->title }}</span>
                        <p class="text-xs text-blue-500 mb-2">Oleh: {{ $doc->author_name }}</p>
                        <p class="desc line-clamp-3">{{ \Illuminate\Support\Str::limit($doc->description, 100) }}</p>
                        
                        <div class="card-footer">
                            <button onclick='showDetail(@json($doc))' class="action">
                                Read More
                                <span aria-hidden="true">→</span>
                            </button>

                            @if(Auth::id() == $doc->user_id)
                            <form action="{{ route('delete.doc', $doc->id) }}" method="POST" onsubmit="return confirm('Hapus dokumentasi ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 ml-2" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="projects" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
                <div data-aos="fade-right">
                    <h2 class="text-4xl font-bold text-gray-900">Showcase Projek</h2>
                    <p class="text-gray-500 mt-2">Hasil karya digital inovatif.</p>
                </div>
                <button onclick="openModal('modalProject')" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition shadow-lg transform hover:-translate-y-1" data-aos="fade-left">
                    <i class="fas fa-code mr-2"></i> Tambah Projek
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($projects as $proj)
                <div class="card" data-aos="fade-up">
                    <img src="{{ asset($proj->thumbnail_path) }}" class="image" alt="{{ $proj->title }}">
                    <div class="content">
                        <span class="title">{{ $proj->title }}</span>
                        <p class="text-xs text-green-600 mb-2">Dev: {{ $proj->author_name }}</p>
                        <p class="desc line-clamp-3">{{ $proj->description }}</p>

                        <div class="card-footer">
                            <a href="{{ $proj->project_url }}" target="_blank" class="action bg-green-600 hover:bg-green-700">
                                Kunjungi Web
                                <span aria-hidden="true">→</span>
                            </a>

                            @if(Auth::id() == $proj->user_id)
                            <form action="{{ route('delete.project', $proj->id) }}" method="POST" onsubmit="return confirm('Hapus projek ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 ml-2">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-white py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; 2024 Magang Tonasa. All Rights Reserved.</p>
        </div>
    </footer>

    <div id="modalDoc" class="fixed inset-0 z-[60] hidden bg-black bg-opacity-70 backdrop-blur-sm overflow-y-auto h-full w-full flex items-center justify-center transition-opacity">
        <div class="relative bg-white rounded-xl shadow-2xl max-w-lg w-full m-4 transform transition-all scale-100">
            <div class="flex justify-between items-center p-6 border-b">
                <h3 class="text-xl font-bold text-gray-800">Upload Dokumentasi</h3>
                <button onclick="closeModal('modalDoc')" class="text-gray-400 hover:text-red-500 transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-6">
                @auth
                <form action="{{ route('submit.doc') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Kegiatan</label>
                        <input type="text" name="title" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border p-2" placeholder="Contoh: Kunjungan Pabrik" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Dokumentasi</label>
                        <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required accept="image/*">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Detail</label>
                        <textarea name="description" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border p-2" placeholder="Ceritakan detail kegiatannya..." required></textarea>
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition shadow-lg">
                            <i class="fas fa-paper-plane mr-2"></i> Kirim untuk Approval
                        </button>
                    </div>
                </form>
                @else
                <div class="text-center py-8">
                    <i class="fas fa-lock text-4xl text-gray-400 mb-4"></i>
                    <p class="text-gray-600 mb-4">Anda harus login terlebih dahulu untuk menambahkan dokumentasi.</p>
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Login Sekarang</a>
                </div>
                @endauth
            </div>
        </div>
    </div>

    <div id="modalProject" class="fixed inset-0 z-[60] hidden bg-black bg-opacity-70 backdrop-blur-sm overflow-y-auto h-full w-full flex items-center justify-center transition-opacity">
        <div class="relative bg-white rounded-xl shadow-2xl max-w-lg w-full m-4">
            <div class="flex justify-between items-center p-6 border-b">
                <h3 class="text-xl font-bold text-gray-800">Upload Projek Web</h3>
                <button onclick="closeModal('modalProject')" class="text-gray-400 hover:text-red-500 transition"><i class="fas fa-times text-xl"></i></button>
            </div>
            <div class="p-6">
                @auth
                <form action="{{ route('submit.project') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Aplikasi/Web</label>
                        <input type="text" name="title" class="w-full border p-2 rounded-lg focus:ring-green-500 focus:border-green-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Link URL</label>
                        <input type="url" name="project_url" class="w-full border p-2 rounded-lg focus:ring-green-500 focus:border-green-500" placeholder="https://..." required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Thumbnail Website</label>
                        <input type="file" name="thumbnail" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100" required accept="image/*">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Fitur</label>
                        <textarea name="description" rows="4" class="w-full border p-2 rounded-lg focus:ring-green-500 focus:border-green-500" required></textarea>
                    </div>
                    <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 rounded-lg hover:bg-green-700 transition shadow-lg">
                        <i class="fas fa-upload mr-2"></i> Kirim Projek
                    </button>
                </form>
                @else
                <div class="text-center py-8">
                    <p class="text-gray-600 mb-4">Silahkan login untuk upload projek.</p>
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg">Login</a>
                </div>
                @endauth
            </div>
        </div>
    </div>

    <div id="modalDetail" class="fixed inset-0 z-[70] hidden bg-black bg-opacity-80 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg max-w-2xl w-full p-6 relative overflow-y-auto max-h-[90vh]">
            <button onclick="document.getElementById('modalDetail').classList.add('hidden')" class="absolute top-4 right-4 text-gray-600 hover:text-red-500"><i class="fas fa-times fa-lg"></i></button>
            <img id="detailImage" src="" class="w-full h-80 object-cover rounded-lg mb-4">
            <h3 id="detailTitle" class="text-2xl font-bold mb-2"></h3>
            <p id="detailAuthor" class="text-gray-500 text-sm mb-4"></p>
            <p id="detailDesc" class="text-gray-700 leading-relaxed"></p>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();

        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        function showDetail(data) {
            document.getElementById('detailImage').src = "{{ asset('') }}" + data.image_path;
            document.getElementById('detailTitle').innerText = data.title;
            document.getElementById('detailAuthor').innerText = "Oleh: " + data.author_name;
            document.getElementById('detailDesc').innerText = data.description;
            document.getElementById('modalDetail').classList.remove('hidden');
        }

        // SweetAlert Popups
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#3085d6',
            });
        @endif

        @if(session('success_popup'))
            Swal.fire({
                title: 'Berhasil Terkirim!',
                text: "{{ session('success_popup') }}",
                icon: 'success',
                confirmButtonText: 'Oke, Mengerti',
                backdrop: `rgba(0,0,123,0.4)`
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
            });
        @endif
    </script>
</body>
</html>