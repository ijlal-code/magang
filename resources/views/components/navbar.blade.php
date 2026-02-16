<nav class="fixed w-full z-50 transition-all duration-300 glass-effect shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <span class="font-bold text-2xl text-blue-800 tracking-wider">MAGANG<span class="text-green-600">TONASA</span></span>
            
            <div class="hidden md:flex space-x-6 items-center">
                <a href="#home" class="hover:text-blue-600 font-medium">Beranda</a>
                <a href="#gallery" class="hover:text-blue-600 font-medium">Galeri</a>
                <a href="#projects" class="hover:text-blue-600 font-medium">Projek</a>
                
                @auth
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center text-blue-700 font-bold">
                            @if(Auth::user()->is_admin) 
                                <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-xs mr-2">ADMIN</span> 
                            @endif
                            {{ Auth::user()->name }} <i class="fas fa-caret-down ml-2"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1" x-cloak>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <button @click="loginModal = true" class="bg-blue-600 text-white px-5 py-2 rounded-full hover:bg-blue-700 transition shadow">Login</button>
                @endauth
            </div>
        </div>
    </div>
</nav>