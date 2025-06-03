<!-- Knowing others is intelligence; knowing yourself is true wisdom. -->
<div class="pt-16">

    <div class="m-4">
        <!-- search dan add industri-->
        <div class="flex justify-between mb-4">
            <a href="{{ route('industriCreate') }}" type="button" 
            class="text-center text-white bg-[#FCD34D] hover:bg-yellow-500 font-medium rounded-lg text-sm py-2.5 px-6">
                Tambahkan Industri
            </a>
        
            <form class="">   
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="search" id="default-search" class="block w-full ps-10 text-sm text-gray-900 border border-yellow-300 rounded-lg bg-gray-50 focus:ring-yellow-500 focus:border-yellow-500" 
                    wire:model.live="search" placeholder="Search" required />
                </div>
            </form>
        </div>

        <div class="shadow-md rounded-xl">
            <div class="py-2 px-8 text-white bg-[#FCD34D] rounded-t-xl font-semibold text-lg">
                Industri
            </div>
            @forelse($industris as $industri)
            <div class="flex justify-start px-8 py-4 rounded-b-xl border-t border-t-[#FCD34D] bg-white">
                <div class="flex gap-8">
                    <div class="">
                        <img  src="{{ Str::startsWith($industri->foto, 'images/') ? asset($industri->foto) : asset('storage/' . $industri->foto) }}" 
                        class="w-28 h-28 rounded-md shadow-xl">
                    </div>
                    <div class="">
                        <div class="text-lg font-semibold">
                            {{ $industri->nama }}
                        </div>
                        <div class="text-sm text-black/50 py-2">
                            {{ $industri->bidang_usaha }}
                        </div>
                        <div class="text-base font-regular">
                            <i class="fas fa-phone-alt pr-2 text-[#FCD34D]"></i>
                            {{ $industri->kontak }}
                        </div>
                        <div class="text-base font-regular">
                            <i class="fas fa-envelope pr-2 text-[#FCD34D]"></i>
                            {{ $industri->email }}
                        </div>
                        <div class="text-base font-regular">
                            <a href="{{ $industri->website }}" target="_blank" class="text-blue-600 hover:underline">
                                {{ $industri->website }}
                            </a>
                        </div>
                        <div class="text-base font-regular mt-4">
                            <i class="fas fa-map-marker-alt pr-2 text-[#FCD34D]"></i>
                            {{ $industri->alamat }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
                <div class="text-center py-4 text-gray-500">
                    <h1>Data Industri Belum Ditemukan, Kamu Bisa Menambahkannya!</h1>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $industris->links('vendor.pagination.tailwind') }}
        </div>
    </div>

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-Xx..." crossorigin="anonymous" referrerpolicy="no-referrer" />

</div>
