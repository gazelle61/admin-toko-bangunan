<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TentangResource\Pages;
use App\Filament\Resources\TentangResource\RelationManagers;
use App\Models\Tentang;
use App\Models\Toko;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TentangResource extends Resource
{
    protected static ?string $model = Toko::class;

    protected static ?string $navigationIcon = 'heroicon-s-information-circle';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Masukkan Informasi Tentang Toko')
                ->schema([
                TextInput::make('nama_toko')
                    ->label('Nama toko')
                    ->required(),

                TextInput::make('alamat')
                    ->label('Alamat')
                    ->required(),

                TextInput::make('domisili')
                    ->label('Kota/Kabupaten')
                    ->required(),

                TextInput::make('kontak')
                    ->label('Kontak')
                    ->maxLength(15)
                    ->required(),

                TextInput::make('website')
                    ->label('Website')
                    ->required(),
                ])
                ->columnSpan(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_toko')
                    ->label('Nama Toko'),

                TextColumn::make('alamat')
                    ->label('Alamat'),

                TextColumn::make('domisili')
                    ->label('Kota/Kabupaten'),

                TextColumn::make('kontak')
                    ->label('Kontak'),

                TextColumn::make('website')
                    ->label('Website'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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

    public static function getPluralModelLabel(): string
    {
        return 'Tentang';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Pengaturan';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTentangs::route('/'),
            'create' => Pages\CreateTentang::route('/create'),
            'edit' => Pages\EditTentang::route('/{record}/edit'),
        ];
    }
}
