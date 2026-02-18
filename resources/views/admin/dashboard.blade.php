<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Magang Tonasa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-gray-100 font-sans text-gray-800">

          <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-blue-900">
                <a href="{{ route('home') }}" class="hover:underline"><i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard</a>
            </h1>
            <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-bold">Admin Area</span>
        </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 mt-20">
        
        <div class="mb-8 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin</h1>
            <div class="text-sm text-gray-500">
                Halo, <span class="font-bold text-blue-600">{{ Auth::user()->name }}</span>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-blue-500 md:col-span-1">
                <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <i class="fas fa-sliders-h text-blue-500"></i> Pengaturan Upload
                </h3>
                
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="font-semibold text-sm text-gray-700 block">Upload Anonim</label>
                                <span class="text-xs text-gray-500">Perlu persetujuan admin?</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="anon_needs_approval" class="sr-only peer" 
                                    {{ ($anonSetting && $anonSetting->value == '1') ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between border-t pt-4">
                            <div>
                                <label class="font-semibold text-sm text-gray-700 block">User Baru Daftar</label>
                                <span class="text-xs text-gray-500">Perlu persetujuan posting?</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="new_user_needs_approval" class="sr-only peer"
                                    {{ ($userSetting && $userSetting->value == '1') ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" class="mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-bold text-sm transition">
                        Simpan Pengaturan
                    </button>
                </form>
            </div>

            <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <a href="{{ route('admin.users') }}" class="bg-white rounded-xl shadow-md p-6 border-t-4 border-green-500 hover:shadow-xl transition flex items-center justify-between group">
                    <div>
                        <h3 class="text-lg font-bold group-hover:text-green-600 transition">Kelola User</h3>
                        <p class="text-sm text-gray-500">Lihat daftar member & hak akses.</p>
                    </div>
                    <i class="fas fa-users text-4xl text-green-200 group-hover:text-green-500 transition"></i>
                </a>

                <a href="{{ route('admin.anon.pending') }}" class="bg-white rounded-xl shadow-md p-6 border-t-4 border-orange-500 hover:shadow-xl transition flex items-center justify-between group relative">
                    <div>
                        <h3 class="text-lg font-bold group-hover:text-orange-600 transition">Approval Anonim</h3>
                        <p class="text-sm text-gray-500">Cek postingan tamu pending.</p>
                    </div>
                    <div class="relative">
                        <i class="fas fa-user-secret text-4xl text-orange-200 group-hover:text-orange-500 transition"></i>
                        @if($totalPendingAnon > 0)
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold w-6 h-6 flex items-center justify-center rounded-full animate-bounce">
                                {{ $totalPendingAnon }}
                            </span>
                        @endif
                    </div>
                </a>
            </div>
        </div>
    </div>

    @include('components.footer')
</body>
</html>