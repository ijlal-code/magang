<div class="flex h-screen items-center justify-center bg-gray-200">
    <form action="{{ route('admin.auth') }}" method="POST" class="bg-white p-8 rounded shadow-lg">
        @csrf
        <h2 class="text-2xl mb-4 font-bold">Admin Area</h2>
        <input type="text" name="username" placeholder="Username" class="border p-2 w-full mb-2">
        <input type="password" name="password" placeholder="Password" class="border p-2 w-full mb-4">
        <button class="bg-blue-600 text-white w-full py-2 rounded">Masuk</button>
    </form>
</div>