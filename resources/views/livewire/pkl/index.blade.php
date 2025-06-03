<!-- Close your eyes. Count to one. That is how long forever feels.  -->
<div class="pt-16">

    <!-- Notifikasi pesan sukses / error -->
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded-md mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="m-4">
        <div class="flex justify-between mb-4">
            <a href="{{ route('pklCreate') }}" type="button" 
            class="text-center text-white bg-[#FCD34D] hover:bg-yellow-500 font-medium rounded-lg text-sm py-2.5 px-6">
                Tambahkan Data PKL
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

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="font-bold text-white bg-[#FCD34D]">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            NIS
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Guru Pembimbing
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Industri
                        </th>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Bidang Usaha
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Mulai
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Selesai
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Durasi
                        </th>
                        <th scope="col" class="px-6 py-3">
                             <span class="sr-only">Aksi</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pkls as $key => $pkl)
                        <tr class="bg-white border-b border-gray-200 hover:bg-yellow-100">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $pkl->id }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $pkl->siswa->nis }} 
                                <!-- siswa ini merupakan nama relasinya ya -->
                            </td>
                            <td class="px-6 py-4">
                                {{ $pkl->siswa->nama }} 
                                <!-- siswa ini merupakan nama relasinya ya -->
                            </td>
                            <td class="px-6 py-4">
                                {{ $pkl->guru->nama }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $pkl->industri->nama }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $pkl->industri->bidang_usaha }}
                            </td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($pkl->mulai)->format('d F Y') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($pkl->selesai)->format('d F Y') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($pkl->mulai)->diffInDays(\Carbon\Carbon::parse($pkl->selesai)) }} hari
                            </td>
                            <td class="px-6 py-4 cursor-pointer text-white font-medium">
                                <!-- membuat tautan ke rute pklView (di web.php) dengan id dari data $pkl -->
                                <a href="{{ route('pklView', ['id' => $pkl->id]) }}" 
                                class="bg-[#10B981] hover:bg-[#059669] py-2 px-4 rounded-lg">View</a>

                                <!-- menyimpan data pengguna yang sedang login ke $user -->
                                @php
                                    $user = Auth::user();
                                @endphp

                                <!-- $user -->
                                    <!-- ini ni dari varibel yang kita buat di atas, data pengguna yang sedang login saat ini -->
                                <!-- operator && -->
                                    <!-- jika 1 salah, maka salah -->
                                    <!-- jika user belum login, maka ini tidak bisa dijalankan -->
                                <!-- $user->email -->
                                    <!-- properti (nilai) email dari pengguna yang sedang login -->
                                    <!-- misalnya pengguna login dengan karla@gmail.com, maka Auth::user()->email (alias $user->email) nilainya "karla@gmail.com" -->
                                <!-- $pkl->siswa->email -->
                                    <!-- ->siswa adalah relasi Eloquent antara tabel pkl dan siswa -->
                                    <!-- ambil email siswa dari relasi tadi -->
                                @if ($user && $user->email === $pkl->siswa->email)
                                    <!-- tombol Edit hanya muncul jika email user = email siswa -->
                                    <a href="{{ route('pklEdit', ['id' => $pkl->id]) }}" 
                                        class="bg-[#FBBF24] hover:bg-[#F59E0B] py-2 px-4 rounded-lg">Edit</a>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-gray-500">Data PKL Tidak Terdaftar</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $pkls->links('vendor.pagination.tailwind') }}
        </div>
    </div>

</div>
