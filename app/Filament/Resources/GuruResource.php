<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuruResource\Pages;
use App\Filament\Resources\GuruResource\RelationManagers;
use App\Models\Guru;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class GuruResource extends Resource
{
    protected static ?string $model = Guru::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Data Guru';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                ->schema([

                    Forms\Components\Grid::make(2) // form dibagi jadi 2 kolom per baris
                        ->schema([
                            // nama
                            Forms\Components\TextInput::make('nama')
                                ->label('Nama')             // ada di atas form
                                ->placeholder('Nama Guru')  // ada di dalam form
                                ->required(),

                            // nip
                            Forms\Components\TextInput::make('nip')
                                ->label('NIP')           
                                ->placeholder('NIP Guru') 
                                ->unique(ignoreRecord: true)
                                ->validationMessages([ // ini pesan error yang akan tampil jika user memasukkan nip yang sudah digunakan, agar lebih user friednly
                                    'unique' => 'NIP ini sudah dimiliki pengguna lain',
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
                                ->columnspan(2)
                                ->required(),
                        
                            // email
                            Forms\Components\TextInput::make('email')
                                ->label('Email') 
                                ->placeholder('Email Guru') 
                                ->email() // mengatur input type="email" dan validasi email otomatis
                                ->unique(ignoreRecord: true)
                                ->validationMessages([ // ini pesan error yang akan tampil jika user memasukkan email yang sudah digunakan, agar lebih user friednly
                                    'unique' => 'Email ini sudah dimiliki pengguna lain',
                                ])
                                ->required(),
        
                            // kontak
                            Forms\Components\TextInput::make('kontak')
                                ->label('Kontak') 
                                ->placeholder('Kontak Guru') 
                                ->prefix('+62') // untuk awalan +62
                                ->dehydrateStateUsing(fn ($state) => ltrim($state, '0')) // saat disimpan, hilangkan angka 0 di depan
                                ->required(),

                            // alamat
                            Forms\Components\TextInput::make('alamat')
                                ->label('Alamat') 
                                ->placeholder('Alamat Guru') 
                                ->columnspan(2)
                                ->required(),
                        ]),
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
                    ->getStateUsing(fn ($record) => guru::orderBy('id')->pluck('id') 
                    ->search($record->id) + 1), 

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
            ])
            ->filters([
                //
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
                        // $records: sebuah koleksi data (biasanya array atau Collection), misalnya semua guru yang dipilih user di tabel
                        // as $record: setiap item tunggal dari koleksi tersebut akan ditampung ke variabel $record
                        foreach ($records as $record) {
                            // memanggil method deleteGuru() untuk tiap data guru yang dipilih
                            static::deleteGuru($record);
                        }
                    }),
            ]);
    }

    // fungsi inilah yang dijalankan ketika tombol hapus diklik
    protected static function deleteGuru($record) 
    {
        if ($record->pkls()->exists()) {
            \Filament\Notifications\Notification::make()
            // $record->pkl() = mengambil relasi pkl yang terkait dengan guru tersebut (berdasarkan hasMany di model guru)
            // ->exists() = Mengecek apakah ada data pkls yang masih menggunakan merk ini.
            // jika ada, pkl yang menggunakan guru ini, penghapusan dibatalkan, dan muncul notifikasi error.
                ->title('Gagal menghapus!')
                ->body('Guru ini masih digunakan dalam PKL. Hapus PKL terkait terlebih dahulu.')
                ->danger() // merah
                ->send();
            return;
        }

        // jika guru tidak digunakan dalam PKL, maka datanya     akan dihapus
        $record->delete();

        \Filament\Notifications\Notification::make()
            ->title('Guru dihapus!')
            ->body('Guru berhasil dihapus.')
            ->success() // hijau
            ->send();
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
            'index' => Pages\ListGurus::route('/'),
            'create' => Pages\CreateGuru::route('/create'),
            'view' => Pages\ViewGuru::route('/{record}'),
            'edit' => Pages\EditGuru::route('/{record}/edit'),
        ];
    }
}
