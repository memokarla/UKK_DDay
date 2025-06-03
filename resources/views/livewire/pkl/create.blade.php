<!-- Care about people's approval and you will be their prisoner. -->
<div class="pt-16">

    <div class="m-4">

        <!-- form -->
        <div class="bg-white py-4 px-8 rounded-xl shadow-md">
            <div class="text-xl border-b pb-4 mb-2 border-[#FCD34D] font-medium text-black/70">
                Tambahkan Data PKL
            </div>
    
            <!-- siswa -->
            <div class="">
                <form class="w-full">
                    <div class="">
                        <label for="siswa_id" class="block mt-4 mb-1 text-lg font-medium text-black/70">Nama Siswa</label>
                        <!-- wire:model ini memberi perintah "Sambungkan nilai input ini ke properti publik bernama $siswa_id di class PHP-nya -->
                        <!-- tambahkan disabled, agar fungsi selectnya ga berfungsi -->
                        <select wire:model='siswa_id' disabled
                        class="text-sm rounded-lg block w-full p-2.5 bg-[#E7EBE8] text-black-700 border border-[#FCD34D]" 
                        required>
                            <!-- ini diisi otomatis -->
                            <!-- value="{{ $siswa_id }}" → ID siswa -->
                            <!-- {{ $nama_siswa }} → nama siswa yang tampil -->
                            <option value="{{ $siswa_id }}">{{ $nama_siswa}}</option>
                        </select>
                    </div>
                </form>
            </div>
    
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 w-full">
                <!-- guru -->
                <div class="">
                    <form class="w-full">
                        <div class="">
                            <label for="guru_id" class="block mt-4 mb-1 text-lg font-medium text-black/70">Nama Guru</label>
                            <select wire:model='guru_id' type="text" id="guru_id"
                            class="text-sm rounded-lg block w-full p-2.5 bg-[#E7EBE8] text-black-700 border border-[#FCD34D]
                            focus:ring-[#FCD34D] focus:border-[#FCD34D]
                                    @error('guru_id') border-red-600 @enderror" 
                            required>
                                <option value="">Nama Guru</option>
                                @foreach($gurus as $guru)
                                    <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                                @endforeach
                            </select>
                            @error('guru_id')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
    
                <!-- industri -->
                <div class="">
                    <form class="w-full">
                        <div class="">
                            <label for="industri_id" class="block mt-4 mb-1 text-lg font-medium text-black/70">Nama Industri</label>
                            <select wire:model='industri_id' type="text" id="industri_id"
                            class="text-sm rounded-lg block w-full p-2.5 bg-[#E7EBE8] text-black-700 border border-[#FCD34D]
                            focus:ring-[#FCD34D] focus:border-[#FCD34D]
                                    @error('industri_id') border-red-600 @enderror" 
                            required>
                                <option value="">Nama Industri</option>
                                @foreach($industris as $industri)
                                    <option value="{{ $industri->id }}">{{ $industri->nama }}</option>
                                @endforeach
                            </select>
                            @error('industri_id')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
    
                <!-- mulai -->
                <div class="">
                    <form class="w-full">
                        <div class="">
                            <label for="mulai" class="block mt-4 mb-1 text-lg font-medium text-black/70">Mulai</label>
                            <input wire:model='mulai' type="date" id="mulai" placeholder="Mulai PKL"
                            class="text-sm rounded-lg block w-full p-2.5 bg-[#E7EBE8] text-black-700 border border-[#FCD34D]
                            focus:ring-[#FCD34D] focus:border-[#FCD34D]
                                    @error('mulai') border-red-600 @enderror" 
                            required />
                            @error('mulai')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
    
                <!-- selesai -->
                <div class="">
                    <form class="w-full">
                        <div class="">
                            <label for="selesai" class="block mt-4 mb-1 text-lg font-medium text-black/70">Selesai</label>
                            <input wire:model='selesai' type="date" id="selesai" placeholder="Selesai PKL"
                            class="text-sm rounded-lg block w-full p-2.5 bg-[#E7EBE8] text-black-700 border border-[#FCD34D]
                            focus:ring-[#FCD34D] focus:border-[#2E7D65]
                                    @error('selesai') border-red-600 @enderror" 
                            required />
                            @error('selesai')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>
    
            <!-- button -->
            <div class="flex justify-end gap-4">
                <a  href="{{ route('pkl') }}" type="button"
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

