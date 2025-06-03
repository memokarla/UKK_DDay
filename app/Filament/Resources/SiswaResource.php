<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
use App\Filament\Resources\SiswaResource\RelationManagers;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Data Siswa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                ->schema([

                    Forms\Components\Grid::make(2) // form dibagi jadi 2 kolom per baris
                        ->schema([
                            // foto
                            Forms\Components\FileUpload::make('foto')
                                ->label('Foto Siswa')
                                ->image() // Menjadikan file yang di-upload sebagai foto
                                ->directory('siswa') // Folder penyimpanan di storage/app/public/[siswa]
                                ->columnspan(2), // Wajib

                            // nama
                            Forms\Components\TextInput::make('nama')
                                ->label('Nama')             // ada di atas form
                                ->placeholder('Nama Siswa')  // ada di dalam form
                                ->required(),

                            // nis
                            Forms\Components\TextInput::make('nis')
                                ->label('NIS')           
                                ->placeholder('NIS Siswa') 
                                ->validationMessages([ // ini pesan error yang akan tampil jika user memasukkan nis yang sudah digunakan, agar lebih user friednly
                                    'unique' => 'NIS ini sudah dimiliki pengguna lain',
                                ])
                                ->required(),

                            // gender
                            Forms\Components\Select::make('gender') // menghasilkan dorpdown untuk memilih data berdasarkan field gender
                                ->label('Jenis Kelamin')
                                ->options([  // pilihan untuk dropdownnya
                                    'L' => 'Laki-Laki',
                                    'P' => 'Perempuan',
                                ])
                                ->native(false) // menonaktifkan tampilan dropdown bawaan browser
                                ->required(),

                            // rombel
                            Forms\Components\Select::make('rombel') 
                                ->label('Rombongan Belajar')
                                ->options([  // pilihan untuk dropdownnya
                                    'SijaA' => 'SIJA A',
                                    'SijaB' => 'SIJA B',
                                ])
                                ->native(false) // menonaktifkan tampilan dropdown bawaan browser
                                ->required(),

                            // email
                            Forms\Components\TextInput::make('email')
                                ->label('Email') 
                                ->placeholder('Email Siswa') 
                                ->email() // mengatur input type="email" dan validasi email otomatis
                                ->unique(ignoreRecord: true)
                                ->validationMessages([ // ini pesan error yang akan tampil jika user memasukkan email yang sudah digunakan, agar lebih user friendly
                                    'unique' => 'Email ini sudah dimiliki pengguna lain',
                                ])
                                ->required(),
        
                            // kontak
                            Forms\Components\TextInput::make('kontak')
                                ->label('Kontak') 
                                ->placeholder('Kontak Siswa') 
                                ->prefix('+62') // untuk awalan +62
                                ->dehydrateStateUsing(fn ($state) => ltrim($state, '0')) // saat disimpan, hilangkan angka 0 di depan
                                ->required(),

                            // alamat
                            Forms\Components\TextInput::make('alamat')
                                ->label('Alamat') 
                                ->placeholder('Alamat Siswa ') 
                                ->columnSpan(2) // membuat field tersebut melebar ke 2 kolom dalam grid layout
                                ->required(),
                        ])
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // id
                // id menjadi nomor urut berdasarkan id terkecil hingga terbesar
                // ini sekadar di table filamentnya, pada database tetap sesuai dengan id yang tersimpan dan terhapus
                Tables\Columns\TextColumn::make('id')
                    ->label('ID') 
                    ->getStateUsing(fn ($record) => siswa::orderBy('id')->pluck('id') 
                    ->search($record->id) + 1), 

                // foto
                Tables\Columns\ImageColumn::make('foto')
                    ->label('Foto')
                    ->circular()
                    ->getStateUsing(function ($record) {
                        return $record->foto
                            ? asset('storage/' . $record->foto) // jika ada foto, ambil dari storage
                            : asset('images/siswa.png');        // jika kosong, fallback ke gambar default
                    }),

                // nama
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                // gender
                Tables\Columns\TextColumn::make('gender')
                    ->label('Gender')
                    ->searchable()
                    ->formatStateUsing(fn ($state) => DB::select("select getGenderDescription(?) AS gender", [$state])[0]->gender)
                    // ->formatStateUsing(fn (string $state): string => $state === 'L' ? 'Laki-Laki' : 'Perempuan')
                        // formatStateUsing(...) akan mengubah tampilan nilai yang ditampilkan di kolom
                        // $state adalah nilai field gender dari database ('L' atau 'P')
                        // Fungsi fn (...) => ... digunakan untuk memetakan
                        // 'L' jadi 'Laki-Laki'
                        // 'P' jadi 'Perempuan'
                    ->sortable(),

                // rombel
                Tables\Columns\TextColumn::make('rombel')
                    ->label('Rombel')
                    ->searchable()
                    ->formatStateUsing(fn ($state) => DB::select("select getRombelDescription(?) AS rombel", [$state])[0]->rombel)
                    // ->formatStateUsing(fn (string $state): string => $state === 'SijaA' ? 'SIJA A' : 'SIJA B')
                        // formatStateUsing(...) akan mengubah tampilan nilai yang ditampilkan di kolom
                        // $state adalah nilai field gender dari database ('SijaA' atau 'SijaB')
                        // Fungsi fn (...) => ... digunakan untuk memetakan
                        // 'SijaA' jadi 'SIJA A'
                        // 'SijaB' jadi 'SIJA B'
                    ->sortable(),
                
                // email
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                
                // kontak
                Tables\Columns\TextColumn::make('kontak')
                    ->label('Kontak')
                    ->searchable()
                    ->formatStateUsing(fn ($state) => '+62' . $state) // menampilkan dengan +62 di depan
                    ->sortable(),

                // status pkl
                Tables\Columns\BadgeColumn::make('status_lapor_pkl')
                    ->label('Status PKL')
                    ->formatStateUsing(fn ($state) => $state ? 'Aktif' : 'Tidak Aktif') // untuk mengubah nilai boolean jadi teks 'Aktif' atau 'Tidak Aktif'
                    ->color(fn ($state) => $state ? 'success' : 'danger'), // untuk memberi warna badge: success jika active, danger jika inactive

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('gender') // membuat dropdown filter
                    ->label('Gender')
                    ->options([ // pilihannya
                        'Laki-Laki' => 'Laki-Laki',
                        'Perempuan' => 'Perempuan',
                    ]),
                Tables\Filters\SelectFilter::make('rombel') // membuat dropdown filter
                    ->label('Rombongan Belajar')
                    ->options([ // pilihannya
                        'SIJA A' => 'SIJA A',
                        'SIJA B' => 'SIJA B',
                    ]),
                Tables\Filters\TernaryFilter::make('status_lapor_pkl') // Menyaring status_pkl berdasarkan status:
                    ->trueLabel('Aktif') // Menampilkan hanya yang aktif
                    ->falseLabel('Nonaktif'), // Menampilkan hanya yang tidak aktif
            ])
            ->actions([
                \Filament\Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ViewAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    // collection $records: daftar semua baris (record) yang dipilih oleh user
                    // Filament mengirim data yang DIPILIH dalam bentuk Collection, bukan array biasa
                    ->action(function (\Illuminate\Support\Collection $records) {

                        // kan ini bulkAction ya, aksi massal, ini tu yang checkbox itu, jadi bisa multiple select
                        // makannya kita menggunakan Collection seperti di atas, kita bisa milih banyak
                        // $records: sebuah koleksi data (biasanya array atau Collection), misalnya semua siswa yang dipilih user di tabel
                        // as $record: setiap item tunggal dari koleksi tersebut akan ditampung ke variabel $record
                        foreach ($records as $record) {
                            // memanggil method deleteSiswa() untuk tiap data siswa yang dipilih
                            static::deleteSiswa($record);
                        }
                    }),
            ]);
    }

    // fungsi inilah yang dijalankan ketika tombol hapus diklik
    protected static function deleteSiswa($record) 
    {
        if ($record->pkl()->exists()) {
            \Filament\Notifications\Notification::make()
            // $record->pkl() = mengambil relasi pkl yang terkait dengan siswa tersebut (berdasarkan hasMany di model siswa)
            // ->exists() = Mengecek apakah ada data pkls yang masih menggunakan merk ini.
            // jika ada, pkl yang menggunakan siswa ini, penghapusan dibatalkan, dan muncul notifikasi error.
                ->title('Gagal menghapus!')
                ->body('Siswa ini masih digunakan dalam PKL. Hapus PKL terkait terlebih dahulu.')
                ->danger() // merah
                ->send();
            return;
        }

        // jika siswa tidak digunakan dalam PKL, maka datanya     akan dihapus
        $record->delete();

        \Filament\Notifications\Notification::make()
            ->title('Siswa dihapus!')
            ->body('Siswa berhasil dihapus.')
            ->success() // hijau
            ->send();
    }

    public static function getNavigationBadge(): ?string
    {
        // return \App\Models\Siswa::where('status_lapor_pkl', '1')->count();
        $aktif = \App\Models\Siswa::where('status_lapor_pkl', '1')->count();
        $tidakAktif = \App\Models\Siswa::where('status_lapor_pkl', '0')->count();

        return "{$aktif} / {$tidakAktif}";
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'info'; 
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'view' => Pages\ViewSiswa::route('/{record}'),
            'edit' => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }
}
