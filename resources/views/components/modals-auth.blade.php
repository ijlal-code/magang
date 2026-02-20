<div x-show="loginModal" 
     class="fixed inset-0 z-[60] flex items-center justify-center bg-black bg-opacity-60 backdrop-blur-sm" 
     x-cloak>
    
    <div x-show="loginModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-90"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-90"
         class="bg-white rounded-xl shadow-2xl border border-gray-100 p-8 w-full max-w-md relative" 
         @click.away="loginModal = false">
        
        <button @click="loginModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition">
            <i class="fas fa-times text-xl"></i>
        </button>
        
        <h2 class="text-2xl font-bold text-center mb-6 text-blue-800">Masuk ke Portal</h2>
        
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 rounded mb-4 text-sm flex items-start">
                <i class="fas fa-exclamation-triangle mt-1 mr-2"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@gmail.com" 
                       class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition bg-gray-50" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" placeholder="********" 
                       class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition bg-gray-50" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition transform hover:scale-[1.02] shadow-lg">
                LOGIN
            </button>
        </form>
        
        <p class="mt-6 text-center text-sm text-gray-600">
            Belum punya akun? 
            <button @click="loginModal = false; registerModal = true" class="text-blue-600 font-bold hover:underline">
                Daftar sekarang
            </button>
        </p>
    </div>
</div>

<div x-show="registerModal" 
     class="fixed inset-0 z-[60] flex items-center justify-center bg-black bg-opacity-60 backdrop-blur-sm" 
     x-cloak>
    
    <div x-show="registerModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-90"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-90"
         class="bg-white rounded-xl shadow-2xl border border-gray-100 p-8 w-full max-w-md relative" 
         @click.away="registerModal = false">
        
        <button @click="registerModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition">
            <i class="fas fa-times text-xl"></i>
        </button>
        
        <h2 class="text-2xl font-bold text-center mb-6 text-green-700">Daftar Akun Baru</h2>
        
        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap" 
                       class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-green-500 outline-none bg-gray-50 @error('name') border-red-500 @enderror" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" 
                       class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-green-500 outline-none bg-gray-50 @error('email') border-red-500 @enderror" required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" placeholder="Min. 6 karakter" 
                       class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-green-500 outline-none bg-gray-50 @error('password') border-red-500 @enderror" required>
                @error('password')
                    <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password" 
                       class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-green-500 outline-none bg-gray-50" required>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 rounded-lg hover:bg-green-700 transition transform hover:scale-[1.02] shadow-lg">
                DAFTAR SEKARANG
            </button>
        </form>
        
        <p class="mt-6 text-center text-sm text-gray-600">
            Sudah punya akun? 
            <button @click="registerModal = false; loginModal = true" class="text-blue-600 font-bold hover:underline">
                Login disini
            </button>
        </p>
    </div>
</div>