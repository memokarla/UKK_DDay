<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?int $navigationSort = 5;
    protected static ?string $navigationLabel = 'Data User';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([

                        Forms\Components\Grid::make(2) // form dibagi jadi 2 kolom per baris
                            ->schema([
                                // nama
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama')
                                    ->placeholder('Nama')
                                    ->required(),

                                // email
                                Forms\Components\TextInput::make('email')
                                    ->label('Email')
                                    ->placeholder('Email')
                                    ->email()
                                    ->required(),

                                // email created
                                Forms\Components\DateTimePicker::make('created_at')
                                    ->label('Email Dibuat')
                                    ->placeholder('Email Dibuat')
                                    ->default(now()) // default dengan waktu saat ini saat data dibuat
                                    ->disabled(), // Membuat input tidak bisa diedit

                                // sandi
                                Forms\Components\TextInput::make('password')
                                    ->label('Sandi')
                                    ->placeholder('Biarkan kosong jika tidak ingin mengubah')
                                    ->password()
                                    ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                                    ->dehydrated(fn($state) => filled($state))
                                    ->required(fn($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord),

                                // roles
                                Forms\Components\Select::make('roles')
                                    ->relationship('roles', 'name') // Relasi dengan roles dari spatie/permission
                                    ->multiple() // memungkinkan pemilihan lebih dari satu opsi
                                    ->columnSpan(2) // membuat field tersebut melebar ke 2 kolom dalam grid layout
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
                    ->label('ID') // Ini kayak fieldnya, untuk memudahkan pengguna mengidentifikasi data
                    ->getStateUsing(fn ($record) => user::orderBy('id')->pluck('id') 
                    ->search($record->id) + 1), 
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Roles')
                    ->searchable(),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
