<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IndustriResource\Pages;
use App\Filament\Resources\IndustriResource\RelationManagers;
use App\Models\Industri;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IndustriResource extends Resource
{
    protected static ?string $model = Industri::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Data Industri';

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
                                ->label('Logo Industri')
                                ->image() // Menjadikan file yang di-upload sebagai foto
                                ->directory('industri') // Folder penyimpanan di storage/app/public/[industri]
                                ->columnspan(2)
                                ->required(), // Wajib

                            // nama
                            Forms\Components\TextInput::make('nama')
                                ->label('Nama')             // ada di atas form
                                ->placeholder('Nama Indsutri')  // ada di dalam form
                                ->columnspan(2)
                                ->required(),

                            // bidang usaha
                            Forms\Components\TextInput::make('bidang_usaha')
                                ->label('Bidang Usaha')           
                                ->placeholder('Bidang Usaha') 
                                ->required(),
                                
                            // website
                            Forms\Components\TextInput::make('website')
                                ->label('Website') 
                                ->placeholder('Website Industri') 
                                ->url() // validasi agar harus berupa URL
                                ->required(),

                            // email
                            Forms\Components\TextInput::make('email')
                                ->label('Email')           
                                ->placeholder('Email Industri') 
                                ->email()
                                ->unique(ignoreRecord: true)
                                ->validationMessages([ // ini pesan error yang akan tampil jika user memasukkan email yang sudah digunakan, agar lebih user friednly
                                    'unique' => 'Email ini sudah dimiliki pengguna lain',
                                ])
                                ->required(),

                            // kontak
                            Forms\Components\TextInput::make('kontak')
                                ->label('Kontak')           
                                ->placeholder('Kontak Industri') 
                                ->prefix('+62') // untuk awalan +62
                                ->dehydrateStateUsing(fn ($state) => ltrim($state, '0')) // saat disimpan, hilangkan angka 0 di depan
                                ->required(),

                            // alamat
                            Forms\Components\TextInput::make('alamat')
                                ->label('Alamat') 
                                ->placeholder('Alamat Industri') 
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
                    ->getStateUsing(fn ($record) => industri::orderBy('id')->pluck('id') 
                    ->search($record->id) + 1), 

                // gambar
                Tables\Columns\ImageColumn::make('foto')
                    ->label('Logo'),

                // nama
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                // bidang usaha
                Tables\Columns\TextColumn::make('bidang_usaha')
                    ->label('Bidang Usaha')
                    ->searchable()
                    ->sortable(),

                // website
                Tables\Columns\TextColumn::make('website')
                    ->label('Website')
                    ->searchable()
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
                        // $records: sebuah koleksi data (biasanya array atau Collection), misalnya semua industri yang dipilih user di tabel
                        // as $record: setiap item tunggal dari koleksi tersebut akan ditampung ke variabel $record
                        foreach ($records as $record) {
                            // memanggil method deleteIndustri() untuk tiap data industri yang dipilih
                            static::deleteIndustri($record);
                        }
                    }),
            ]);
    }

    // fungsi inilah yang dijalankan ketika tombol hapus diklik
    protected static function deleteIndustri($record) 
    {
        if ($record->pkls()->exists()) {
            \Filament\Notifications\Notification::make()
            // $record->pkls() = mengambil relasi pkls yang terkait dengan industri tersebut (berdasarkan hasMany di model Industri)
            // ->exists() = Mengecek apakah ada data pkls yang masih menggunakan merk ini.
            // jika ada, pkl yang menggunakan industri ini, penghapusan dibatalkan, dan muncul notifikasi error.
                ->title('Gagal menghapus!')
                ->body('Industri ini masih digunakan dalam PKL. Hapus PKL terkait terlebih dahulu.')
                ->danger() // merah
                ->send();
            return;
        }

        // jika industri tidak digunakan dalam PKL, maka datanya     akan dihapus
        $record->delete();

        \Filament\Notifications\Notification::make()
            ->title('Industri dihapus!')
            ->body('Industri berhasil dihapus.')
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
            'index' => Pages\ListIndustris::route('/'),
            'create' => Pages\CreateIndustri::route('/create'),
            'view' => Pages\ViewIndustri::route('/{record}'),
            'edit' => Pages\EditIndustri::route('/{record}/edit'),
        ];
    }
}
