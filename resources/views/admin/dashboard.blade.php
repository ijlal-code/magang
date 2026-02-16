<!DOCTYPE html>
<html lang="id">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dashboard Admin</title>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-6">Dashboard Approval</h1>
        
        <h2 class="text-xl font-bold mt-4 mb-2">Pending Dokumentasi</h2>
        <table class="w-full text-left border mb-8">
            <tr class="bg-gray-200"><th>Foto</th><th>Judul</th><th>Oleh</th><th>Aksi</th></tr>
            @foreach($pendingDocs as $doc)
            <tr class="border-b">
                <td class="p-2"><img src="{{ asset($doc->image_path) }}" class="h-10"></td>
                <td class="p-2">{{ $doc->title }}</td>
                <td class="p-2">{{ $doc->author_name }}</td>
                <td class="p-2">
                    <a href="{{ route('admin.approve', ['type'=>'doc', 'id'=>$doc->id]) }}" class="bg-green-500 text-white px-2 py-1 rounded">Approve</a>
                </td>
            </tr>
            @endforeach
        </table>

        <h2 class="text-xl font-bold mt-4 mb-2">Pending Projek</h2>
        <table class="w-full text-left border">
            <tr class="bg-gray-200"><th>Thumb</th><th>Judul</th><th>Link</th><th>Aksi</th></tr>
            @foreach($pendingProjects as $proj)
            <tr class="border-b">
                <td class="p-2"><img src="{{ asset($proj->thumbnail_path) }}" class="h-10"></td>
                <td class="p-2">{{ $proj->title }}</td>
                <td class="p-2"><a href="{{ $proj->project_url }}" class="text-blue-500">Link</a></td>
                <td class="p-2">
                    <a href="{{ route('admin.approve', ['type'=>'project', 'id'=>$proj->id]) }}" class="bg-green-500 text-white px-2 py-1 rounded">Approve</a>
                </td>
            </tr>
            @endforeach
        </table>
        
        <a href="{{ route('home') }}" class="block mt-8 text-blue-600 underline">Kembali ke Halaman Utama</a>
    </div>
</body>
</html>