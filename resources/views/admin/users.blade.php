<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User - Admin Magang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-50 font-sans text-gray-800">

    <div class="bg-white shadow-sm border-b sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-blue-900">
                <a href="{{ route('admin.dashboard') }}" class="hover:underline"><i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard</a>
            </h1>
            <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-bold">Admin Area</span>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-10">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Manajemen Pengguna</h2>
                <p class="text-gray-500">Kelola hak akses upload peserta magang.</p>
            </div>
            
            <form action="{{ route('admin.users') }}" method="GET" class="w-full md:w-auto">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." 
                           class="pl-10 pr-4 py-2 border rounded-lg w-full md:w-64 focus:ring-2 focus:ring-blue-500 outline-none">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </form>
        </div>

        <form action="{{ route('admin.users.bulk') }}" method="POST" id="bulkForm" x-data="{ selectAll: false }">
            @csrf
            
            <div class="bg-white p-4 rounded-t-lg border-b flex flex-wrap gap-2 items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <input type="checkbox" x-model="selectAll" @change="toggleAll($el)" class="w-5 h-5 text-blue-600 rounded">
                    <span class="text-sm font-semibold text-gray-600">Pilih Semua</span>
                </div>
                
                <div class="flex gap-2">
                    <button type="submit" name="action" value="allow" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition shadow">
                        <i class="fas fa-check-circle mr-1"></i> Bebaskan Upload
                    </button>
                    <button type="submit" name="action" value="restrict" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm transition shadow">
                        <i class="fas fa-ban mr-1"></i> Batasi Upload
                    </button>
                    <button type="button" onclick="confirmBulkDelete()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm transition shadow">
                        <i class="fas fa-trash mr-1"></i> Hapus User
                    </button>
                </div>
            </div>

            <div class="bg-white shadow-lg rounded-b-lg overflow-hidden overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="p-4 w-10"></th>
                            <th class="p-4">Nama Peserta</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">Status Upload</th>
                            <th class="p-4">Terdaftar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($users as $u)
                        <tr class="hover:bg-blue-50 transition duration-150">
                            <td class="p-4 text-center">
                                <input type="checkbox" name="ids[]" value="{{ $u->id }}" class="user-checkbox w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                            </td>
                            <td class="p-4 font-semibold text-gray-800">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3 font-bold text-xs">
                                        {{ substr($u->name, 0, 1) }}
                                    </div>
                                    {{ $u->name }}
                                </div>
                            </td>
                            <td class="p-4 text-gray-600">{{ $u->email }}</td>
                            <td class="p-4">
                                @if($u->can_post_directly)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Langsung Tayang
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i> Perlu Approval
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-sm text-gray-500">{{ $u->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">
                                <i class="fas fa-users-slash text-4xl mb-3 text-gray-300"></i>
                                <p>Tidak ada user ditemukan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <script>
        @if(session('success')) Swal.fire({ icon: 'success', title: 'Berhasil', text: "{{ session('success') }}", timer: 3000, showConfirmButton: false }); @endif
        @if(session('error')) Swal.fire({ icon: 'error', title: 'Gagal', text: "{{ session('error') }}" }); @endif

        function toggleAll(source) {
            checkboxes = document.querySelectorAll('.user-checkbox');
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
            }
        }

        // SCRIPT SWEETALERT UNTUK HAPUS MASSAL
        function confirmBulkDelete() {
            let checkedCount = document.querySelectorAll('.user-checkbox:checked').length;
            
            if(checkedCount === 0) {
                Swal.fire({ icon: 'warning', title: 'Oops...', text: 'Pilih minimal satu user terlebih dahulu!' });
                return;
            }

            Swal.fire({
                title: `Hapus ${checkedCount} User Terpilih?`,
                text: "Semua data terkait user tersebut juga akan terhapus dan tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus Semua!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.getElementById('bulkForm');
                    // Buat input hidden agar controller tahu ini adalah request Hapus
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'action';
                    input.value = 'delete';
                    form.appendChild(input);
                    form.submit();
                }
            });
        }
    </script>
</body>
</html>