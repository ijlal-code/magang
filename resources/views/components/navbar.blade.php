<nav class="fixed w-full z-50 transition-all duration-300 glass-effect shadow-md" 
     x-data="{ scrolled: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 20)"
     :class="{ 'bg-white/90 backdrop-blur-md shadow-lg': scrolled, 'bg-white/80 backdrop-blur-sm': !scrolled }">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            
            <div class="flex-shrink-0 flex items-center cursor-pointer" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
                <div class="w-10 h-10 bg-blue-800 rounded-lg flex items-center justify-center text-white font-bold text-xl mr-2 shadow-lg">
                    M
                </div>
                <span class="font-bold text-2xl text-blue-900 tracking-wider">MAGANG<span class="text-green-600">TONASA</span></span>
            </div>

            <div class="hidden md:flex space-x-8 items-center">
                <a href="#home" class="text-gray-700 hover:text-blue-600 font-medium transition duration-300 relative group">
                    Beranda
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#about" class="text-gray-700 hover:text-blue-600 font-medium transition duration-300 relative group">
                    Tentang
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#gallery" class="text-gray-700 hover:text-blue-600 font-medium transition duration-300 relative group">
                    Galeri
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#projects" class="text-gray-700 hover:text-blue-600 font-medium transition duration-300 relative group">
                    Projek
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                </a>
                
                @auth
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-blue-700 focus:outline-none transition bg-gray-100 px-4 py-2 rounded-full border border-gray-200">
                           @if(Auth::user()->role === 'admin')
    <a href="{{ route('admin.users') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700">
        <i class="fas fa-users-cog mr-2 text-blue-500"></i> Kelola User
    </a>
    @else
                                <span class="bg-blue-500 text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider">USER</span>
                            @endif
                            
                            <span class="font-semibold">{{ Auth::user()->name }}</span>
                            <i class="fas fa-caret-down transition-transform duration-300" :class="{'rotate-180': open}"></i>
                        </button>

                        <div x-show="open" 
                             @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl py-2 z-50 border border-gray-100" 
                             x-cloak>
                             
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm leading-5 text-gray-500">Masuk sebagai</p>
                                <p class="text-sm font-bold leading-5 text-gray-900 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition flex items-center">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Keluar / Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-3">
                        <button @click="loginModal = true" class="text-gray-600 hover:text-blue-600 font-medium transition">
                            Masuk
                        </button>
                        <button @click="registerModal = true" class="bg-blue-600 text-white px-5 py-2.5 rounded-full font-bold hover:bg-blue-700 transition shadow-lg hover:shadow-blue-500/30">
                            Daftar
                        </button>
                    </div>
                @endauth
            </div>
            
            <div class="md:hidden flex items-center">
                <button class="text-gray-700 hover:text-blue-600 focus:outline-none">
                   <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
    </div>
</nav>