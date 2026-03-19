
    <div class="fixed bottom-8 left-8 z-50 flex flex-col gap-5 items-start">
        
        <!-- Phone (Call) Icon -->
        @if($global_setting->phone)
            <div class="group relative flex items-center">
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $global_setting->phone) }}" 
                   class="w-14 h-14 rounded-full bg-gradient-to-tr from-green-600 to-green-400 text-white flex items-center justify-center shadow-lg hover:scale-110 hover:shadow-green-500/50 transition-all duration-300 z-10"
                   aria-label="Call Us">
                   
                   <!-- Pulse ring for phone -->
                   <span class="absolute inset-0 rounded-full border border-green-400 animate-[ping_2s_cubic-bezier(0,0,0.2,1)_infinite] opacity-75 group-hover:hidden"></span>
                   
                   <svg class="w-6 h-6 z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                   </svg>
                </a>

                <!-- Tooltip -->
                <div class="absolute left-full ml-4 px-4 py-2.5 bg-white/95 backdrop-blur-sm text-gray-800 text-sm font-semibold rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-gray-100/50 opacity-0 -translate-x-4 pointer-events-none group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300 ease-out whitespace-nowrap">
                    {{ $global_setting->phone }}
                </div>
            </div>
        @endif

        <!-- Zalo Icon -->
        @if($global_setting->zalo_url)
            <div class="group relative flex items-center">
                <a href="{{ $global_setting->zalo_url }}" target="_blank" rel="noopener noreferrer" 
                   class="w-14 h-14 rounded-full bg-gradient-to-tr from-[#0056cc] to-[#0088FF] text-white flex items-center justify-center shadow-lg hover:scale-110 hover:shadow-[#0068FF]/50 transition-all duration-300 z-10"
                   aria-label="Chat via Zalo">
                    <span class="font-black text-[14px] tracking-wider z-10 group-hover:scale-110 transition-transform">Zalo</span>
                </a>

                <!-- Tooltip -->
                <div class="absolute left-full ml-4 px-4 py-2.5 bg-white/95 backdrop-blur-sm text-gray-800 text-sm font-semibold rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-gray-100/50 opacity-0 -translate-x-4 pointer-events-none group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300 ease-out whitespace-nowrap">
                    Chat on Zalo
                </div>
            </div>
        @endif
        
        <!-- Facebook Icon -->
        @if($global_setting->facebook_url)
            <div class="group relative flex items-center">
                <a href="{{ $global_setting->facebook_url }}" target="_blank" rel="noopener noreferrer"
                   class="w-14 h-14 rounded-full bg-gradient-to-tr from-[#155dbf] to-[#1877F2] text-white flex items-center justify-center shadow-lg hover:scale-110 hover:shadow-[#1877F2]/50 transition-all duration-300 z-10"
                   aria-label="Visit Facebook Page">
                    <svg class="w-7 h-7 z-10" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                    </svg>
                </a>

                <!-- Tooltip -->
                <div class="absolute left-full ml-4 px-4 py-2.5 bg-white/95 backdrop-blur-sm text-gray-800 text-sm font-semibold rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-gray-100/50 opacity-0 -translate-x-4 pointer-events-none group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300 ease-out whitespace-nowrap">
                    Follow on Facebook
                </div>
            </div>
        @endif
        
    </div>


