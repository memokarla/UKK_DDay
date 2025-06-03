<!-- The best athlete wants his opponent at his best. -->
<!-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. -->
<div class="pt-16">

        <div class="bg-[#F6F7EF] py-4 px-8 rounded-xl flex flex-col gap-y-4">
            <div class="text-xl mb-2">
                Data PKL <span class="font-medium">{{ $pkl->siswa->nama }}</span>
            </div>   

            <!-- informasi siswa -->
            <div class="bg-[#FDFEFB] shadow-lg px-4 py-2 rounded-md">
                <!-- dropdownnya -->
                <div class="flex justify-between cursor-pointer text-lg m-2" data-collapse-toggle="detailSiswa">
                    Informasi Siswa
                    <i class="fa-solid fa-chevron-down text-black/70"></i>
                </div> 

                <!-- detailnya -->
                <div id="detailSiswa" class="flex flex-col gap-y-1.5 pt-4 m-2 border-t border-[#FCD34D]">
                    <div class="text-base font-regular flex">
                        <div class="flex items-center w-[15%]">
                            <i class="fa-solid fa-user pr-2 text-[#FCD34D]"></i>
                            Nama
                        </div>    
                        <div class="">
                            <span class="text-[#FCD34D]">:</span>
                            {{ $pkl->siswa->nama }}
                        </div>
                    </div>

                    <div class="text-base font-regular flex">
                        <div class="flex items-center w-[15%]">
                            <i class="fa-solid fa-id-card pr-2 text-[#FCD34D]"></i>
                            NIS
                        </div>    
                        <div class="">
                            <span class="text-[#FCD34D]">:</span>
                            {{ $pkl->siswa->nis }}
                        </div>
                    </div>
                    
                    <div class="text-base font-regular flex">
                        <div class="flex items-center w-[15%]">
                            <i class="fa-solid fa-venus-mars pr-2 text-[#FCD34D]"></i>
                            Gender
                        </div>    
                        <div class="">
                            <span class="text-[#FCD34D]">:</span>
                            {{ $pkl->siswa->gender }}
                        </div>
                    </div>

                    <div class="text-base font-regular flex">
                        <div class="flex items-center w-[15%]">
                            <i class="fa-solid fa-users-rectangle pr-2 text-[#FCD34D]"></i>
                            Rombel
                        </div>    
                        <div class="">
                            <span class="text-[#FCD34D]">:</span>
                            {{ $pkl->siswa->rombel }}
                        </div>
                    </div>

                    <div class="text-base font-regular flex">
                        <div class="flex items-center w-[15%]">
                            <i class="fas fa-phone-alt pr-2 text-[#FCD34D]"></i>
                            Kontak
                        </div>    
                        <div class="">
                            <span class="text-[#FCD34D]">:</span>
                            {{ $pkl->siswa->kontak }}
                        </div>
                    </div>

                    <div class="text-base font-regular flex">
                        <div class="flex items-center w-[15%]">
                            <i class="fas fa-envelope pr-2 text-[#FCD34D]"></i>
                            Email
                        </div>    
                        <div class="">
                            <span class="text-[#FCD34D]">:</span>
                            {{ $pkl->siswa->email }}
                        </div>
                    </div>

                    <div class="text-base font-regular flex">
                        <div class="flex items-center w-[15%]">
                            <i class="fas fa-map-marker-alt pr-2 text-[#FCD34D]"></i>
                            Alamat
                        </div>    
                        <div class="">
                            <span class="text-[#FCD34D]">:</span>
                            {{ $pkl->siswa->alamat }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- informasi guru pembimbing -->
            <div class="bg-[#FDFEFB] shadow-lg px-4 py-2 rounded-md">
                <!-- dropdownnya -->
                <div class="flex justify-between cursor-pointer text-lg m-2" data-collapse-toggle="detailGuru">
                    Informasi Guru Pembimbing
                    <i class="fa-solid fa-chevron-down text-black/70"></i>
                </div> 

                <!-- detailnya -->
                <div id="detailGuru" class="flex flex-col gap-y-1.5 pt-4 m-2 border-t border-[#FCD34D]">
                    <div class="text-base font-regular flex">
                        <div class="flex items-center w-[15%]">
                            <i class="fa-solid fa-user pr-2 text-[#FCD34D]"></i>
                            Nama
                        </div>    
                        <div class="">
                            <span class="text-[#FCD34D]">:</span>
                            {{ $pkl->guru->nama }}
                        </div>
                    </div>

                    <div class="text-base font-regular flex">
                        <div class="flex items-center w-[15%]">
                            <i class="fa-solid fa-id-card pr-2 text-[#FCD34D]"></i>
                            NIP
                        </div>    
                        <div class="">
                            <span class="text-[#FCD34D]">:</span>
                            {{ $pkl->guru->nip }}
                        </div>
                    </div>
                    
                    <div class="text-base font-regular flex">
                        <div class="flex items-center w-[15%]">
                            <i class="fa-solid fa-venus-mars pr-2 text-[#FCD34D]"></i>
                            Gender
                        </div>    
                        <div class="">
                            <span class="text-[#FCD34D]">:</span>
                            {{ $pkl->guru->gender }}
                        </div>
                    </div>

                    <div class="text-base font-regular flex">
                        <div class="flex items-center w-[15%]">
                            <i class="fas fa-phone-alt pr-2 text-[#FCD34D]"></i>
                            Kontak
                        </div>    
                        <div class="">
                            <span class="text-[#FCD34D]">:</span>
                            {{ $pkl->guru->kontak }}
                        </div>
                    </div>

                    <div class="text-base font-regular flex">
                        <div class="flex items-center w-[15%]">
                            <i class="fas fa-envelope pr-2 text-[#FCD34D]"></i>
                            Email
                        </div>    
                        <div class="">
                            <span class="text-[#FCD34D]">:</span>
                            {{ $pkl->guru->email }}
                        </div>
                    </div>

                    <div class="text-base font-regular flex">
                        <div class="flex items-center w-[15%]">
                            <i class="fas fa-map-marker-alt pr-2 text-[#FCD34D]"></i>
                            Alamat
                        </div>    
                        <div class="">
                            <span class="text-[#FCD34D]">:</span>
                            {{ $pkl->guru->alamat }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- informasi industri -->
            <div class="bg-[#FDFEFB] shadow-lg px-4 py-2 rounded-md">
                <!-- dropdownnya -->
                <div class="flex justify-between cursor-pointer text-lg m-2" data-collapse-toggle="detailIndustri">
                    Informasi Industri
                    <i class="fa-solid fa-chevron-down text-black/70"></i>
                </div> 

                <!-- detailnya -->
                <div id="detailIndustri" class="flex flex-col gap-y-1.5 pt-4 m-2 border-t border-[#FCD34D]">
                    <div class="text-base font-regular flex">
                        <div class="flex items-center w-[15%]">
                            <i class="fa-solid fa-user pr-2 text-[#FCD34D]"></i>
                            Nama
                        </div>    
                        <div class="">
                            <span class="text-[#FCD34D]">:</span>
                            {{ $pkl->industri->nama }}
                        </div>
                    </div>

                    <div class="text-base font-regular flex">
                        <div class="flex items-center w-[15%]">
                            <i class="fa-solid fa-id-card pr-2 text-[#FCD34D]"></i>
                            Bidang Usaha
                        </div>    
                        <div class="">
                            <span class="text-[#FCD34D]">:</span>
                            {{ $pkl->industri->bidang_usaha }}
                        </div>
                    </div>
                    
                    <div class="text-base font-regular flex">
                        <div class="flex items-center w-[15%]">
                            <i class="fas fa-phone-alt pr-2 text-[#FCD34D]"></i>
                            Kontak
                        </div>    
                        <div class="">
                            <span class="text-[#FCD34D]">:</span>
                            {{ $pkl->industri->kontak }}
                        </div>
                    </div>

                    <div class="text-base font-regular flex">
                        <div class="flex items-center w-[15%]">
                            <i class="fas fa-envelope pr-2 text-[#FCD34D]"></i>
                            Email
                        </div>    
                        <div class="">
                            <span class="text-[#FCD34D]">:</span>
                            {{ $pkl->industri->email }}
                        </div>
                    </div>

                    <div class="text-base font-regular flex">
                        <div class="flex items-center w-[15%]">
                            <i class="fas fa-map-marker-alt pr-2 text-[#FCD34D]"></i>
                            Alamat
                        </div>    
                        <div class="">
                            <span class="text-[#FCD34D]">:</span>
                            {{ $pkl->industri->alamat }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- button -->
        <div class="flex justify-end mb-4 mr-8">
            <a  href="{{ route('pkl') }}" type="button"
                    class="text-center text-white bg-[#FCD34D] hover:bg-yellow-500 font-medium rounded-lg text-sm py-2.5 px-6 mt-4">
                Kembali
            </a>
        </div>

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-Xx..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- js flowbite -->
    <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>

</div>

