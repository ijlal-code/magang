<nav x-data="{ mobileMenuOpen: false, userDropdownOpen: false }" class="fixed w-full z-50 transition-all duration-300 bg-white/90 backdrop-blur-md shadow-sm border-b border-brand-light/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-24 items-center">
            
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="bg-brand-primary text-white w-10 h-10 flex items-center justify-center rounded-xl group-hover:bg-brand-dark transition-colors duration-300 shadow-lg shadow-brand-primary/20">
                        <i class="fas fa-industry text-lg"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold text-xl leading-none text-brand-dark group-hover:text-brand-primary transition">
                            Magang<span class="text-brand-primary">Tonasa</span>
                        </span>
                        
                    </div>
                </a>
            </div>

            <div class="hidden md:flex space-x-8 items-center">
                <a href="{{ request()->routeIs('home') ? '#home' : route('home') }}" 
                   class="text-sm font-semibold uppercase tracking-wide transition duration-300 {{ request()->routeIs('home') ? 'text-brand-primary' : 'text-gray-500 hover:text-brand-primary' }}">
                   Beranda
                </a>
                
                <a href="{{ request()->routeIs('home') ? '#gallery' : url('/#gallery') }}" 
                   class="text-sm font-semibold uppercase tracking-wide text-gray-500 hover:text-brand-primary transition duration-300">
                   Galeri
                </a>
                
                <a href="{{ request()->routeIs('home') ? '#projects' : url('/#projects') }}" 
                   class="text-sm font-semibold uppercase tracking-wide text-gray-500 hover:text-brand-primary transition duration-300">
                   Projek
                </a>
                
                @auth
                    <div class="relative ml-6">
                        <button @click="userDropdownOpen = !userDropdownOpen" @click.away="userDropdownOpen = false" class="flex items-center gap-3 text-brand-dark hover:text-brand-primary font-medium focus:outline-none transition group">
                            <div class="text-right hidden lg:block">
                                <p class="text-sm font-bold">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">Online</p>
                            </div>
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=005C53&color=fff" class="h-10 w-10 rounded-full border-2 border-brand-light group-hover:border-brand-primary transition">
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="{'rotate-180': userDropdownOpen}"></i>
                        </button>

                        <div x-show="userDropdownOpen" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
                             class="absolute right-0 mt-4 w-60 bg-white rounded-2xl shadow-xl border border-brand-light/50 py-2 z-50 overflow-hidden" 
                             style="display: none;">
                            
                            <div class="px-5 py-3 border-b border-gray-100 bg-brand-light/10">
                                <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Akun</p>
                                <p class="text-sm font-bold text-brand-dark truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <div class="py-2">
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-5 py-2.5 text-sm text-gray-600 hover:bg-brand-primary/5 hover:text-brand-primary transition">
                                        <i class="fas fa-tachometer-alt mr-3 w-4"></i> Dashboard
                                    </a>
                                    <a href="{{ route('admin.users') }}" class="flex items-center px-5 py-2.5 text-sm text-gray-600 hover:bg-brand-primary/5 hover:text-brand-primary transition">
                                        <i class="fas fa-users mr-3 w-4"></i> Kelola User
                                    </a>
                                    <a href="{{ route('admin.anon.pending') }}" class="flex items-center px-5 py-2.5 text-sm text-gray-600 hover:bg-brand-primary/5 hover:text-brand-primary transition">
                                        <i class="fas fa-user-secret mr-3 w-4"></i> Approval Anonim
                                    </a>
                                    <div class="border-t border-gray-100 my-1 mx-4"></div>
                                @endif

                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center px-5 py-2.5 text-sm text-red-600 hover:bg-red-50 font-medium transition">
                                        <i class="fas fa-sign-out-alt mr-3 w-4"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-3 ml-6 pl-6 border-l border-gray-200">
                        <button @click="loginModal = true" class="text-brand-dark hover:text-brand-primary font-bold text-sm px-4 py-2 transition">Masuk</button>
                        <button @click="registerModal = true" class="bg-brand-primary hover:bg-brand-dark text-white px-6 py-2.5 rounded-full font-bold text-sm shadow-lg shadow-brand-primary/30 transition-all transform hover:-translate-y-0.5">
                            Daftar
                        </button>
                    </div>
                @endauth
            </div>

            <div class="flex items-center md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-brand-dark hover:text-brand-primary focus:outline-none p-2 transition">
                    <i class="fas" :class="mobileMenuOpen ? 'fa-times text-2xl' : 'fa-bars text-2xl'"></i>
                </button>
            </div>
        </div>
    </div>

   <div x-show="mobileMenuOpen" 
         x-collapse 
         x-cloak
         style="display: none;"
         class="md:hidden bg-white border-t border-brand-light/50 shadow-xl">
        
        <div class="px-4 pt-4 pb-8 space-y-2">
            <a href="{{ request()->routeIs('home') ? '#home' : route('home') }}" 
               class="block px-4 py-3 rounded-xl text-base font-bold text-gray-700 hover:bg-brand-light/30 hover:text-brand-primary transition">
               Beranda
            </a>
            <a href="{{ request()->routeIs('home') ? '#gallery' : url('/#gallery') }}" 
               @click="mobileMenuOpen = false" 
               class="block px-4 py-3 rounded-xl text-base font-bold text-gray-700 hover:bg-brand-light/30 hover:text-brand-primary transition">
               Galeri
            </a>
            <a href="{{ request()->routeIs('home') ? '#projects' : url('/#projects') }}" 
               @click="mobileMenuOpen = false" 
               class="block px-4 py-3 rounded-xl text-base font-bold text-gray-700 hover:bg-brand-light/30 hover:text-brand-primary transition">
               Projek
            </a>

            @auth
                <div class="border-t border-gray-100 mt-4 pt-4">
                    <div class="flex items-center px-4 py-3 bg-brand-light/20 rounded-xl mb-3 border border-brand-light/50">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=005C53&color=fff" class="h-10 w-10 rounded-full mr-3">
                        <div>
                            <p class="text-sm font-bold text-brand-dark">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-brand-primary">{{ Auth::user()->role === 'admin' ? 'Administrator' : 'Peserta Magang' }}</p>
                        </div>
                    </div>

                    @if(Auth::user()->role === 'admin')
                        <div class="space-y-1 mb-3">
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-brand-primary">
                                <i class="fas fa-tachometer-alt mr-2 text-brand-primary w-5"></i> Dashboard
                            </a>
                            <a href="{{ route('admin.users') }}" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-brand-primary">
                                <i class="fas fa-users mr-2 text-brand-secondary w-5"></i> Kelola User
                            </a>
                        </div>
                    @endif

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-3 rounded-xl text-base font-bold text-white bg-red-500 hover:bg-red-600 shadow-md transition">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="grid grid-cols-2 gap-3 mt-6 px-2">
                    <button @click="loginModal = true; mobileMenuOpen = false" class="text-center py-3.5 rounded-xl border-2 border-brand-light/50 font-bold text-brand-dark hover:bg-brand-light/30 transition">Masuk</button>
                    <button @click="registerModal = true; mobileMenuOpen = false" class="text-center py-3.5 rounded-xl bg-brand-primary text-white font-bold hover:bg-brand-dark shadow-lg shadow-brand-primary/30 transition">Daftar</button>
                </div>
            @endauth
        </div>
    </div>
</nav>