<div x-show="loginModal" class="fixed inset-0 z-[60] flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-sm" x-cloak>
    <div class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-md relative" @click.away="loginModal = false">
        <button @click="loginModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-red-500"><i class="fas fa-times text-xl"></i></button>
        
        <h2 class="text-2xl font-bold text-center mb-6 text-blue-800">Masuk ke Portal</h2>
        
        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <input type="email" name="email" placeholder="Email" class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
            <input type="password" name="password" placeholder="Password" class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition">LOGIN</button>
        </form>
        <p class="mt-4 text-center text-sm">Belum punya akun? <button @click="loginModal = false; registerModal = true" class="text-blue-600 font-bold hover:underline">Daftar</button></p>
    </div>
</div>

<div x-show="registerModal" class="fixed inset-0 z-[60] flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-sm" x-cloak>
    <div class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-md relative" @click.away="registerModal = false">
        <button @click="registerModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-red-500"><i class="fas fa-times text-xl"></i></button>
        
        <h2 class="text-2xl font-bold text-center mb-6 text-green-700">Daftar Akun Baru</h2>
        
        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <input type="text" name="name" placeholder="Nama Lengkap" class="w-full border p-3 rounded-lg" required>
            <input type="email" name="email" placeholder="Email" class="w-full border p-3 rounded-lg" required>
            <input type="password" name="password" placeholder="Password" class="w-full border p-3 rounded-lg" required>
            <input type="password" name="password_confirmation" placeholder="Ulangi Password" class="w-full border p-3 rounded-lg" required>
            <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 rounded-lg hover:bg-green-700 transition">DAFTAR</button>
        </form>
        <p class="mt-4 text-center text-sm">Sudah punya akun? <button @click="registerModal = false; loginModal = true" class="text-blue-600 font-bold hover:underline">Login</button></p>
    </div>
</div>