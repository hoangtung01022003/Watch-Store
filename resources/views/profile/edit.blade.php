<x-customer>
    <!-- ✅ reviewed -->
    <x-slot name="header">
        <div class="bg-white border-b border-gray-100 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="font-serif text-3xl text-luxury-dark tracking-tight">
                    {{ __('Profile') }}
                </h2>
                <div class="w-12 h-0.5 bg-luxury-gold mt-4"></div>
            </div>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ tab: 'personal' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Navigation Tabs -->
            <div class="bg-white shadow-sm border border-gray-100">
                <div class="border-b border-gray-100">
                    <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                        <button @click="tab = 'personal'" 
                                :class="tab === 'personal' ? 'border-luxury-gold text-luxury-gold' : 'border-transparent text-gray-500 hover:text-luxury-dark hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-semibold text-xs uppercase tracking-widest transition-colors">
                            Personal Info
                        </button>
                        <button @click="tab = 'password'" 
                                :class="tab === 'password' ? 'border-luxury-gold text-luxury-gold' : 'border-transparent text-gray-500 hover:text-luxury-dark hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-semibold text-xs uppercase tracking-widest transition-colors">
                            Change Password
                        </button>
                        <button @click="window.location.href='{{ route('profile.addresses.index') }}'"
                                class="border-transparent text-gray-500 hover:text-luxury-dark hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-semibold text-xs uppercase tracking-widest transition-colors">
                            Address Book
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Tab Contents -->
            <div>
                <!-- Personal Info Tab -->
                <div x-show="tab === 'personal'" class="space-y-6">
                    <div class="p-6 sm:p-10 bg-white shadow-sm border border-gray-100">
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>

                <!-- Password Tab -->
                <div x-show="tab === 'password'" class="space-y-6" x-cloak>
                    <div class="p-6 sm:p-10 bg-white shadow-sm border border-gray-100">
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-customer>
