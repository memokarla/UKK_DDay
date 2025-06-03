<?php

namespace App\Filament\Resources;

use App\Models\Siswa;
use App\Models\Industri;
use App\Models\Guru;

use App\Filament\Resources\PklResource\Pages;
use App\Filament\Resources\PklResource\RelationManagers;
use App\Models\Pkl;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PklResource extends Resource
{
    protected static ?string $model = Pkl::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Data PKL';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                ->schema([

                    Forms\Components\Grid::make(2) // form dibagi jadi 2 kolom per baris
                        ->schema([
                            // siswa_id
                            Forms\Components\Select::make('siswa_id') // menghasilkan dorpdown untuk memilih data berdasarkan FK siswa_id
                                ->label('Nama Siswa') 
                                ->relationship('siswa', 'nama') // mengambil field name dari tabel siswa (jadi dropdownnya akan menampilkan field nama)
                                                                // dengan ini, model utama (pkl) harus memiliki relasi ke model Siswa
                                                                // siswa di sini merupakan nama relasi di App\Models\Pkl.php, jadi jika relasinya bernama hokya maka ->relationship('hokya', 'nama')
                                ->native(false) // menonaktifkan tampilan dropdown bawaan browser
                                ->columnSpan(2)
                                ->required(),

                            // industri_id
                            Forms\Components\Select::make('industri_id') 
                                ->label('Nama Industri') 
                                ->relationship('industri', 'nama') 
                                ->native(false) 
                                ->required(),

                            // guru_id
                            Forms\Components\Select::make('guru_id') 
                                ->label('Nama Guru Pendamping') 
                                ->relationship('guru', 'nama') 
                                ->native(false) 
                                ->required(),

                            // mulai
                            Forms\Components\DatePicker::make('mulai') // membuat input tanggal dengan date picker bawaan browser/Filament
                                ->label('Tanggal Mulai')
                                ->maxDate(now()->addYears(5)) //  input maksimal tanggal hanya sampai 5 tahun dari hari ini
                                ->required(),

                            // selesai
                            Forms\Components\DatePicker::make('selesai')
                                ->label('Tanggal Selesai')
                                ->maxDate(now()->addYears(5))
                                ->after('mulai') // memastikan tanggal selesai tidak lebih awal dari mulai
                                ->minDate(fn ($get) => $get('mulai') ? \Carbon\Carbon::parse($get('mulai'))->addMonths(3)->toDateString() : null)
                                    // minDate = mengatur tanggal minimal yang boleh dipilih
                                    // $get('mulai') = ambil nilai tanggal mulai dari input form mulai
                                    // jika mulai benar (sudah diisi) = 
                                                    // addMonths(3) = tambahkan 3 bulan ke tanggal mulai
                                                    // toDateString() = knversi tanggal ke format string tanggal YYYY-MM-DD
                                    // jika mulai salah (belum diisi) =
                                                    // null = tidak ada batas minimal
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
                    ->getStateUsing(fn ($record) => pkl::orderBy('id')->pluck('id') 
                    ->search($record->id) + 1), 

                // nama siswa
                Tables\Columns\TextColumn::make('siswa.nama')
                    ->label('Nama Siswa')
                    ->searchable(),

                // nama industri
                Tables\Columns\TextColumn::make('industri.nama')
                    ->label('Nama Industri')
                    ->searchable(),

                // nama guru
                Tables\Columns\TextColumn::make('guru.nama')
                    ->label('Nama Guru')
                    ->searchable(),
                
                // mulai
                Tables\Columns\TextColumn::make('mulai')
                    ->label('Mulai')
                    ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)->format('d M Y')),
                        // formatStateUsing() → mengubah tampilan nilai sebelum ditampilkan.
                        // Carbon::parse($state)->format('d M Y') → memformat tanggal, misalnya jadi: 01 Jul 2025

                // selesai
                Tables\Columns\TextColumn::make('selesai')
                    ->label('Selesai')
                    ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)->format('d M Y')),

                // durasi
                Tables\Columns\TextColumn::make('durasi')
                    ->label('Durasi')
                    ->getStateUsing(fn ($record) => 
                        \Carbon\Carbon::parse($record->mulai)->diffInDays(\Carbon\Carbon::parse($record->selesai)) . ' hari'
                        // Carbon adalah library tanggal & waktu
                        // parse() adalah fungsi dari Carbon yang mengubah string tanggal menjadi objek Carbon yang bisa dihitung ('2025-05-01' menjadi 1 Mei 2025)
                        // diffInDays() → selisih hari antar tanggal
                    ),
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
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
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
            'index' => Pages\ListPkls::route('/'),
            'create' => Pages\CreatePkl::route('/create'),
            'view' => Pages\ViewPkl::route('/{record}'),
            'edit' => Pages\EditPkl::route('/{record}/edit'),
        ];
    }
}
