<section class="py-10 bg-red-50 border-b border-red-100">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-bold text-red-800 mb-6"><i class="fas fa-users-cog"></i> Kelola Pengguna (Admin Area)</h2>
        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-red-100 text-red-800">
                        <th class="p-4">Nama</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Terdaftar</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4">{{ $u->name }}</td>
                        <td class="p-4">{{ $u->email }}</td>
                        <td class="p-4 text-sm text-gray-500">{{ $u->created_at->format('d M Y') }}</td>
                        <td class="p-4">
                            <form action="{{ route('admin.deleteUser', $u->id) }}" method="POST" onsubmit="return confirm('Hapus user ini beserta semua karyanya?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>