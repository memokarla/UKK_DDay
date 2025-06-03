<!-- f you look to others for fulfillment, you will never truly be fulfilled. -->
<div class="pt-16">

    <div class="m-4">
        <div class="bg-white py-4 px-8 rounded-xl shadow-md">
            <div class="text-xl border-b pb-4 mb-2 border-[#FCD34D] font-medium text-black/70">
                Edit Siswa
            </div>
    
            <div class="w-full flex flex-col gap-y-4">
    
                <!-- siswa -->
                <form class="">
                    <label for="siswa_id" class="block mb-2 text-lg font-medium text-black/70">Nama Siswa</label>
                    <select wire:model='siswa_id' id="siswa_id"
                    class="text-sm rounded-lg block w-full p-2.5 bg-[#E7EBE8] text-black-700 border border-[#FCD34D]
                    focus:ring-[#FCD34D] focus:border-[#FCD34D]
                            @error('siswa_id') border-red-600 @enderror" 
                    required>
                        <option value="">Nama Siswa</option>
                        @foreach($siswas as $siswa)
                            <!-- menampilkan data siswa yang dipilih edit -->
                            <option value="{{ $siswa->id }}">{{ $siswa->nama }}</option> 
                        @endforeach
                    </select>
                    @error('siswa_id')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    @if(session()->has('error'))
                        <div class="text-red-500">{{ session('error') }}</div>
                    @endif
                </form>
    
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 w-full">
                    <!-- guru -->
                    <form class="">
                        <label for="guru_id" class="block mb-2 text-lg font-medium text-black/70">Nama Guru</label>
                        <select wire:model='guru_id' id="guru_id"
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
                            <span class="text-red-600">{{ $message }}</span> 
                        @enderror
                    </form>
    
                    <!-- industri -->
                    <form class="">
                        <label for="industri_id" class="block mb-2 text-lg font-medium text-black/70">Nama Industri</label>
                        <select wire:model='industri_id' id="industri_id"
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
                            <span class="text-red-600">{{ $message }}</span> 
                        @enderror
                    </form>
    
                    <!-- mulai -->
                    <form>
                        <label for="mulai" class="block mb-2 text-lg font-medium text-black/70">Mulai</label>
                        <input type="date" wire:model="mulai" id="mulai" class="text-sm rounded-lg block w-full p-2.5 bg-[#E7EBE8] text-black-700 border border-[#FCD34D]
                        focus:ring-[#FCD34D] focus:border-[#FCD34D]  @error('mulai') border-red-600 @enderror" ">
                        @error('mulai') <span class="text-red-600">{{ $message }}</span> @enderror
                    </form>
    
                    <!-- selesai -->
                    <form>
                        <label for="selesai" class="block mb-2 text-lg font-medium text-black/70">Selesai</label>
                        <input type="date" wire:model="selesai" id="selesai" class="text-sm rounded-lg block w-full p-2.5 bg-[#E7EBE8] text-black-700 border border-[#FCD34D]
                        focus:ring-[#FCD34D] focus:border-[#FCD34D]  @error('selesai') border-red-600 @enderror" ">
                        @error('selesai') <span class="text-red-600">{{ $message }}</span> @enderror
                    </form>
                </div>
    
                <div class="flex justify-end gap-4">
                    <a  href="{{ route('pkl') }}" type="button"
                            class="text-center text-white bg-[#FCD34D] hover:bg-yellow-500 font-medium rounded-lg text-sm py-2.5 px-6 mt-4">
                        Kembali
                    </a>
    
                    <a wire:click="update" type="button" class="text-center text-white bg-[#FCD34D] hover:bg-yellow-500 font-medium rounded-lg text-sm py-2.5 px-6 mt-4">
                        Update Data
                    </a>
                </div>
                
            </div>
        </div>
    </div>

</div>
