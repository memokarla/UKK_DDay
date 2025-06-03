<!-- Nothing in the world is as soft and yielding as water. -->
<div>

    <div class="flex items-center justify-center min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 m-4">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <!-- Header dengan ilustrasi -->
                <div class="bg-gradient-to-r from-[#FCD34D] to-[#FFF9D6] p-8">
                    <div class="flex items-center justify-between">

                        <!-- poll ini merupakan polling, 5000ms adalah 5 detik -->
                        <!-- polling adalah teknik untuk mengecek kondisi secara berkala (berulang-ulang setiap beberapa detik) -->
                        <div wire:poll.5000ms="checkRoles">
                            <h2 class="text-3xl font-bold mb-2 text-gray-800">Menunggu Persetujuan</h2>
                            <p class="text-gray-700">Akun Anda sedang dalam proses verifikasi</p>
                            <p class="text-gray-700">Halaman ini akan otomatis redirect jika sudah diberikan role.</p>
                        </div>
                        <div class="hidden md:block">
                            <i class="fas fa-clock text-black/50 text-8xl"></i>
                        </div>
                        
                    </div>
                </div>

                <!-- Status card -->
                <div class="p-6">
                    <div class="flex items-center p-4 mb-6 bg-yellow-50 border-l-4 border-yellow-400 rounded-r-md">
                        <i class="fas fa-exclamation-triangle text-yellow-400 mr-3 text-xl"></i>
                        <p class="text-yellow-700"> 
                            Akun Anda telah berhasil terdaftar dan sedang menunggu persetujuan administrator.
                        </p>
                    </div>
                    
                    <!-- Progress indicator -->
                    <div class="flex items-center justify-center my-8">
                        <!-- Step 1: Registrasi -->
                        <div class="flex flex-col items-center text-center">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center bg-green-500 text-white font-semibold">
                                ✓
                            </div>
                            <span class="text-xs mt-2 text-green-600">Registrasi</span>
                        </div>

                        <!-- Garis antar step -->
                        <div class="flex-auto border-t-2 border-blue-500 mx-2 mb-4"></div>

                        <!-- Step 2: Menunggu -->
                        <div class="flex flex-col items-center text-center">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center bg-blue-500 text-white font-semibold animate-pulse">
                                2
                            </div>
                            <span class="text-xs mt-2 text-blue-600">Persetujuan</span>
                        </div>

                        <!-- Garis antar step -->
                        <div class="flex-auto border-t-2 border-gray-300 mx-2 mb-4"></div>

                        <!-- Step 3: Akses -->
                        <div class="flex flex-col items-center text-center">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-300 text-white font-semibold">
                                3
                            </div>
                            <span class="text-xs mt-2 text-gray-400">Akses Penuh</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-Xx..." crossorigin="anonymous" referrerpolicy="no-referrer" />

</div>
