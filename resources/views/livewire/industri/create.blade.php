<!-- Care about people's approval and you will be their prisoner.  -->
<div class="pt-16">

    <div class="m-4">
        <!-- form -->
        <div class="bg-white py-4 px-8 rounded-xl shadow-md">
            <div class="text-xl border-b pb-4 mb-2 border-[#FCD34D] font-medium text-black/70">
                Tambahkan Industri
            </div>

            <!-- foto -->
            <div class="">
                 <form class="w-full">
                    <div class="">
                        <label for="foto" class="block mt-4 mb-1 text-lg font-medium text-black/70">Logo</label>
                        <input wire:model='foto' type="file" id="foto"
                        class="text-sm rounded-lg block w-full p-2.5 bg-[#E7EBE8] text-black-700 border border-[#FCD34D]
                        focus:ring-[#FCD34D] focus:border-[#FCD34D]
                                @error('foto') border-red-600 @enderror" 
                        required />
                        @error('gambar')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>

            
            <!-- nama -->
            <div class="">
                <form class="w-full">
                    <div class="">
                        <label for="nama" class="block mt-4 mb-1 text-lg font-medium text-black/70">Nama</label>
                        <input wire:model='nama' type="text" id="nama" placeholder="Nama Industri"
                        class="text-sm rounded-lg block w-full p-2.5 bg-[#E7EBE8] text-black-700 border border-[#FCD34D]
                        focus:ring-[#FCD34D] focus:border-[#FCD34D]
                                @error('nama') border-red-600 @enderror" 
                        required />
                        @error('nama')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 w-full">
                <!-- bidang usaha -->
                <div class="">
                    <form class="w-full">
                        <div class="">
                            <label for="bidang_usaha" class="block mt-4 mb-1 text-lg font-medium text-black/70">Bidang Usaha</label>
                            <input wire:model='bidang_usaha' type="text" id="bidang_usaha" placeholder="Bidang Usaha Industri"
                            class="text-sm rounded-lg block w-full p-2.5 bg-[#E7EBE8] text-black-700 border border-[#FCD34D]
                            focus:ring-[#FCD34D] focus:border-[#FCD34D]
                                    @error('bidang_usaha') border-red-600 @enderror" 
                            required />
                            @error('bidang_usaha')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>

                <!-- website -->
                <div class="">
                    <form class="w-full">
                        <div class="">
                            <label for="website" class="block mt-4 mb-1 text-lg font-medium text-black/70">Websie</label>
                            <input wire:model='website' type="text" id="website" placeholder="Website Industri"
                            class="text-sm rounded-lg block w-full p-2.5 bg-[#E7EBE8] text-black-700 border border-[#FCD34D]
                            focus:ring-[#FCD34D] focus:border-[#FCD34D]
                                    @error('website') border-red-600 @enderror" 
                            required />
                            @error('website')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>

                <!-- kontak -->
                <div class="">
                    <form class="w-full">
                        <div class="">
                            <label for="kontak" class="block mt-4 mb-1 text-lg font-medium text-black/70">Kontak</label>
                            <input wire:model='kontak' type="text" id="kontak" placeholder="Kontak Industri"
                            class="text-sm rounded-lg block w-full p-2.5 bg-[#E7EBE8] text-black-700 border border-[#FCD34D]
                            focus:ring-[#FCD34D] focus:border-[#FCD34D]
                                    @error('kontak') border-red-600 @enderror" 
                            required />
                            @error('kontak')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>

                <!-- email -->
                <div class="">
                    <form class="w-full">
                        <div class="">
                            <label for="email" class="block mt-4 mb-1 text-lg font-medium text-black/70">Email</label>
                            <input wire:model='email' type="email" id="email" placeholder="Email Industri"
                            class="text-sm rounded-lg block w-full p-2.5 bg-[#E7EBE8] text-black-700 border border-[#FCD34D]
                            focus:ring-[#FCD34D] focus:border-[#FCD34D]
                                    @error('email') border-red-600 @enderror" 
                            required />
                            @error('email')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>

            <!--alamat -->
            <div class="">
                 <form class="w-full">
                    <div class="">
                        <label for="alamat" class="block mt-4 mb-1 text-lg font-medium text-black/70">Alamat</label>
                        <textarea wire:model='alamat' type="text" id="alamat" rows="3" placeholder="Alamat Industri"
                        class="text-sm rounded-lg block w-full p-2.5 bg-[#E7EBE8] text-black-700 border border-[#FCD34D]
                        focus:ring-[#FCD34D] focus:border-[#FCD34D]
                                @error('alamat') border-red-600 @enderror" 
                        required></textarea>
                        @error('alamat')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>

            <!-- button -->
            <div class="flex justify-end gap-4">
                <a  href="{{ route('industri') }}" type="button"
                        class="text-center text-[#F6F7EF] bg-[#FCD34D] hover:bg-yellow-500 font-medium rounded-lg text-sm py-2.5 px-6 mt-4">
                    Kembali
                </a>

                <button wire:click="create" type="button"
                    class="text-center text-white bg-[#FCD34D] hover:bg-yellow-500 font-medium rounded-lg text-sm py-2.5 px-6 mt-4">
                    Tambahkan
                </button>
            </div>
        </div>
    </div>

</div>
