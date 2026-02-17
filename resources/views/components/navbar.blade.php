<nav x-data="{ mobileMenuOpen: false, userDropdownOpen: false }" class="fixed w-full z-50 transition-all duration-300 bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    {{-- Ganti src ini dengan logo asli jika ada --}}
                    <div class="bg-blue-600 text-white p-2 rounded-lg group-hover:bg-blue-700 transition">
                        <i class="fas fa-shapes text-xl"></i>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-gray-800 group-hover:text-blue-600 transition">
                        Magang<span class="text-blue-600">Tonasa</span>
                    </span>
                </a>
            </div>

            <div class="hidden md:flex space-x-8 items-center">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 font-medium transition {{ request()->routeIs('home') ? 'text-blue-600' : '' }}">Beranda</a>
                <a href="#gallery" class="text-gray-600 hover:text-blue-600 font-medium transition">Galeri</a>
                <a href="#projects" class="text-gray-600 hover:text-blue-600 font-medium transition">Projek</a>
                
                @auth
                    <div class="relative ml-4">
                        <button @click="userDropdownOpen = !userDropdownOpen" @click.away="userDropdownOpen = false" class="flex items-center gap-2 text-gray-700 hover:text-blue-600 font-medium focus:outline-none">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff" class="h-8 w-8 rounded-full border border-gray-200">
                            <span>{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="{'rotate-180': userDropdownOpen}"></i>
                        </button>

                        <div x-show="userDropdownOpen" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50" 
                             style="display: none;">
                            
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm text-gray-500">Login sebagai</p>
                                <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                                    <i class="fas fa-tachometer-alt mr-2 w-5"></i> Dashboard Admin
                                </a>
                                <a href="{{ route('admin.users') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                                    <i class="fas fa-users mr-2 w-5"></i> Kelola User
                                </a>
                                <a href="{{ route('admin.anon.pending') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                                    <i class="fas fa-user-secret mr-2 w-5"></i> Approval Anonim
                                </a>
                                <div class="border-t border-gray-100 my-1"></div>
                            @endif

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium">
                                    <i class="fas fa-sign-out-alt mr-2 w-5"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-3 ml-4">
                        <button @click="loginModal = true" class="text-gray-600 hover:text-blue-600 font-medium px-4 py-2">Masuk</button>
                        <button @click="registerModal = true" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-full font-bold shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5">
                            Daftar
                        </button>
                    </div>
                @endauth
            </div>

            <div class="flex items-center md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-600 hover:text-blue-600 focus:outline-none p-2">
                    <i class="fas" :class="mobileMenuOpen ? 'fa-times text-2xl' : 'fa-bars text-2xl'"></i>
                </button>
            </div>
        </div>
    </div>

    <div x-show="mobileMenuOpen" 
         x-collapse 
         class="md:hidden bg-white border-t border-gray-100 shadow-lg overflow-hidden">
        
        <div class="px-4 pt-2 pb-6 space-y-2">
            <a href="{{ route('home') }}" class="block px-3 py-3 rounded-lg text-base font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600">Beranda</a>
            <a href="#gallery" @click="mobileMenuOpen = false" class="block px-3 py-3 rounded-lg text-base font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600">Galeri</a>
            <a href="#projects" @click="mobileMenuOpen = false" class="block px-3 py-3 rounded-lg text-base font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600">Projek</a>

            @auth
                <div class="border-t border-gray-100 my-2 pt-2">
                    <div class="flex items-center px-3 py-2 bg-blue-50 rounded-lg mb-2">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff" class="h-8 w-8 rounded-full mr-3">
                        <div>
                            <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->role === 'admin' ? 'Administrator' : 'Peserta Magang' }}</p>
                        </div>
                    </div>

                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-blue-600">
                            <i class="fas fa-tachometer-alt mr-2 text-blue-500 w-5"></i> Dashboard
                        </a>
                        <a href="{{ route('admin.users') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-blue-600">
                            <i class="fas fa-users mr-2 text-green-500 w-5"></i> Kelola User
                        </a>
                        <a href="{{ route('admin.anon.pending') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-blue-600">
                            <i class="fas fa-user-secret mr-2 text-orange-500 w-5"></i> Approval Anonim
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-3 rounded-lg text-base font-medium text-white bg-red-500 hover:bg-red-600 shadow transition">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="grid grid-cols-2 gap-3 mt-4 px-2">
                    <button @click="loginModal = true; mobileMenuOpen = false" class="text-center py-3 rounded-lg border border-gray-300 font-bold text-gray-700 hover:bg-gray-50">Masuk</button>
                    <button @click="registerModal = true; mobileMenuOpen = false" class="text-center py-3 rounded-lg bg-blue-600 text-white font-bold hover:bg-blue-700 shadow-md">Daftar</button>
                </div>
            @endauth
        </div>
    </div>
</nav>