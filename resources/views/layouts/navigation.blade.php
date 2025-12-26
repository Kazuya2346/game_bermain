<nav x-data="{ 
    open: false, 
    isDarkMode: (localStorage.getItem('dark_mode') === 'true' || 
                (localStorage.getItem('dark_mode') === null && window.matchMedia('(prefers-color-scheme: dark)').matches)) 
}" 
x-init="
   if (isDarkMode) {
       document.documentElement.classList.add('dark');
   } else {
       document.documentElement.classList.remove('dark');
   }
   $watch('isDarkMode', (value) => {
       localStorage.setItem('dark_mode', value);
       if (value) {
           document.documentElement.classList.add('dark');
       } else {
           document.documentElement.classList.remove('dark');
       }
   });
"
class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-r from-teal-600 via-emerald-600 to-cyan-600 dark:from-gray-900 dark:via-teal-900 dark:to-emerald-900 shadow-lg backdrop-blur-sm">

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
   <div class="flex justify-between h-16">
       <!-- Left Side: Logo & Brand -->
       <div class="flex items-center">
           <div class="shrink-0 flex items-center group">
               <a href="{{ route('dashboard') }}" class="flex items-center gap-3 hover:scale-105 transition-transform duration-300">
                   <!-- Islamic Logo -->
                   <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-md group-hover:bg-white/30 transition-all duration-300 group-hover:rotate-6">
                       <span class="text-2xl">🕌</span>
                   </div>
                   <div class="hidden sm:block">
                       <h1 class="text-xl font-bold text-white">TPQ Learning</h1>
                       <p class="text-xs text-white/80">Islamic Education</p>
                   </div>
               </a>
           </div>

           <!-- Navigation Links (Desktop) -->
           <div class="hidden md:flex md:items-center md:space-x-2 md:ms-8">
               <a href="{{ route('dashboard') }}" 
                  class="px-4 py-2 rounded-xl text-white font-medium hover:bg-white/20 backdrop-blur-md transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-white/30 shadow-lg' : '' }}">
                   <span class="flex items-center gap-2">
                       <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                           <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                       </svg>
                       Dashboard
                   </span>
               </a>
           </div>
       </div>

       <!-- Right Side: Dark Mode, Profile -->
       <div class="hidden sm:flex sm:items-center sm:gap-3">
           
           <!-- Dark Mode Toggle -->
           <button @click="isDarkMode = !isDarkMode" 
                   type="button" 
                   class="p-2.5 rounded-xl bg-white/20 backdrop-blur-md text-white hover:bg-white/30 transition-all duration-300 hover:scale-110 hover:rotate-12" 
                   aria-label="Toggle dark mode">
               <!-- Sun Icon (Show in Dark Mode) -->
               <svg x-show="isDarkMode" 
                    class="h-5 w-5" 
                    fill="currentColor" 
                    viewBox="0 0 20 20" 
                    style="display: none;">
                   <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/>
               </svg>
               <!-- Moon Icon (Show in Light Mode) -->
               <svg x-show="!isDarkMode" 
                    class="h-5 w-5" 
                    fill="currentColor" 
                    viewBox="0 0 20 20">
                   <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
               </svg>
           </button>

           <!-- Profile Dropdown -->
           <div class="relative" x-data="{ dropdownOpen: false }">
               <button @click="dropdownOpen = !dropdownOpen" 
                       class="flex items-center gap-2 px-4 py-2 rounded-xl bg-white/20 backdrop-blur-md text-white hover:bg-white/30 transition-all duration-300 group">
                   <!-- Avatar -->
                   <div class="w-8 h-8 rounded-full bg-white/30 flex items-center justify-center font-bold text-sm group-hover:scale-110 transition-transform duration-300">
                       {{ substr(Auth::user()->name, 0, 1) }}
                   </div>
                   <span class="font-medium text-sm hidden lg:block">{{ Auth::user()->name }}</span>
                   <svg class="w-4 h-4 transition-transform duration-300" 
                        :class="{'rotate-180': dropdownOpen}"
                        fill="currentColor" 
                        viewBox="0 0 20 20">
                       <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                   </svg>
               </button>

               <!-- Dropdown Menu -->
               <div x-show="dropdownOpen" 
                    @click.away="dropdownOpen = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden z-50"
                    style="display: none;">
                   
                   <!-- User Info -->
                   <div class="px-4 py-3 bg-gradient-to-br from-teal-50 to-emerald-50 dark:from-gray-700 dark:to-gray-600">
                       <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
                       <p class="text-xs text-gray-600 dark:text-gray-300 truncate">{{ Auth::user()->email }}</p>
                   </div>

                   <!-- Menu Items -->
                   <div class="py-2">
                       <a href="{{ route('profile.edit') }}" 
                          class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-200 hover:bg-teal-50 dark:hover:bg-gray-700 transition-colors duration-200">
                           <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                           </svg>
                           Profile Settings
                       </a>

                       <form method="POST" action="{{ route('logout') }}">
                           @csrf
                           <button type="submit"
                                   class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-200">
                               <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                               </svg>
                               Sign Out
                           </button>
                       </form>
                   </div>
               </div>
           </div>
       </div>

       <!-- Mobile Menu Button -->
       <div class="flex items-center sm:hidden">
           <button @click="open = !open" 
                   class="p-2 rounded-xl bg-white/20 backdrop-blur-md text-white hover:bg-white/30 transition-all duration-300">
               <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                   <path :class="{'hidden': open, 'inline-flex': !open}" 
                         class="inline-flex" 
                         stroke-linecap="round" 
                         stroke-linejoin="round" 
                         stroke-width="2" 
                         d="M4 6h16M4 12h16M4 18h16"/>
                   <path :class="{'hidden': !open, 'inline-flex': open}" 
                         class="hidden" 
                         stroke-linecap="round" 
                         stroke-linejoin="round" 
                         stroke-width="2" 
                         d="M6 18L18 6M6 6l12 12"/>
               </svg>
           </button>
       </div>
   </div>
</div>

<!-- Mobile Menu -->
<div :class="{'block': open, 'hidden': !open}" 
    class="hidden sm:hidden bg-white/10 backdrop-blur-md"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="transform opacity-0 scale-95"
    x-transition:enter-end="transform opacity-100 scale-100">
   
   <!-- Navigation Links -->
   <div class="px-2 pt-2 pb-3 space-y-1">
       <a href="{{ route('dashboard') }}" 
          class="block px-4 py-3 rounded-xl text-white font-medium hover:bg-white/20 transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-white/30' : '' }}">
           Dashboard
       </a>
   </div>

   <!-- User Info & Actions -->
   <div class="pt-4 pb-3 border-t border-white/20">
       <div class="px-4 mb-3">
           <div class="font-semibold text-white">{{ Auth::user()->name }}</div>
           <div class="text-sm text-white/80">{{ Auth::user()->email }}</div>
       </div>

       <div class="px-2 space-y-1">
           <!-- Dark Mode Toggle Mobile -->
           <button @click="isDarkMode = !isDarkMode"
                   class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-white hover:bg-white/20 transition-all duration-300">
               <svg x-show="isDarkMode" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" style="display: none;">
                   <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/>
               </svg>
               <svg x-show="!isDarkMode" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                   <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
               </svg>
               <span x-text="isDarkMode ? 'Light Mode' : 'Dark Mode'"></span>
           </button>

           <a href="{{ route('profile.edit') }}" 
              class="block px-4 py-3 rounded-xl text-white hover:bg-white/20 transition-all duration-300">
               Profile Settings
           </a>

           <form method="POST" action="{{ route('logout') }}">
               @csrf
               <button type="submit"
                       class="w-full text-left px-4 py-3 rounded-xl text-white hover:bg-red-500/20 transition-all duration-300">
                   Sign Out
               </button>
           </form>
       </div>
   </div>
</div>
</nav>

<style>
/* Smooth animations */
[x-cloak] { 
   display: none !important; 
}

/* Custom scrollbar for dropdown */
.overflow-y-auto::-webkit-scrollbar {
   width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
   background: transparent;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
   background: rgba(0, 0, 0, 0.2);
   border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
   background: rgba(0, 0, 0, 0.3);
}
</style>