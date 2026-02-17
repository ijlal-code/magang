<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magang Tonasa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .glass-effect { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
        .hero-bg {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1581094794329-cd56b5095a8e?auto=format&fit=crop&w=1950&q=80');
            background-size: cover; background-attachment: fixed; background-position: center;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased" x-data="{ 
    loginModal: false, 
    registerModal: false, 
    uploadDocModal: false, 
    uploadProjectModal: false,
    editDocModal: false,
    editProjectModal: false,
    detailModal: false,
    // Data holders for Edit/Detail
    selectedItem: {} 
}">

    @include('components.navbar')

    @include('components.hero')

   

    @include('components.about')
    @include('components.gallery')
    @include('components.projects')
    @include('components.footer')

    @include('components.modals-auth')
    @include('components.modals-content')

   <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Jalankan AOS setelah konten dimuat
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                once: true, 
                duration: 800,
                // Matikan AOS di HP jika bikin berat (opsional)
                // disable: 'mobile' 
            });
        });

        // SweetAlert Logic
        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil', text: "{{ session('success') }}", timer: 3000, showConfirmButton: false });
        @endif
        @if(session('error'))
            Swal.fire({ icon: 'error', title: 'Gagal', text: "{{ session('error') }}" });
        @endif
        @if($errors->any())
            Swal.fire({ icon: 'warning', title: 'Periksa Input', text: 'Ada data yang belum valid.' });
        @endif
    </script>
</body>
</html>