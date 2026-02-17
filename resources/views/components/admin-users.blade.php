<section class="py-10 bg-red-50 border-b border-red-100">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-bold text-red-800 mb-6"><i class="fas fa-users-cog"></i> Kelola Pengguna</h2>
        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-red-100 text-red-800">
                        <th class="p-4">Nama</th>
                        <th class="p-4">Role</th>
                        <th class="p-4">Status Upload</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4 font-bold">{{ $u->name }}</td>
                        <td class="p-4"><span class="bg-gray-200 px-2 py-1 rounded text-xs">{{ strtoupper($u->role) }}</span></td>
                        
                        <td class="p-4">
                            @if($u->can_post_directly)
                                <span class="text-green-600 font-bold text-sm"><i class="fas fa-check-circle"></i> Langsung Tayang</span>
                            @else
                                <span class="text-yellow-600 font-bold text-sm"><i class="fas fa-clock"></i> Perlu Approve</span>
                            @endif
                        </td>

                        <td class="p-4 flex gap-2">
                            <form action="{{ route('admin.toggleUser', $u->id) }}" method="POST">
                                @csrf
                                <button class="px-3 py-1 text-xs rounded text-white {{ $u->can_post_directly ? 'bg-orange-500 hover:bg-orange-600' : 'bg-green-500 hover:bg-green-600' }}">
                                    {{ $u->can_post_directly ? 'Batasi' : 'Bebaskan' }}
                                </button>
                            </form>

                            <form action="{{ route('admin.deleteUser', $u->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline text-sm ml-2">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>