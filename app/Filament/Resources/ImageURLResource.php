<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImageURLResource\Pages;
use App\Filament\Resources\ImageURLResource\RelationManagers;
use App\Models\Image;
use App\Models\ImageURL;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ImageURLResource extends Resource
{
    protected static ?string $model = Image::class;

    protected static ?string $navigationIcon = 'heroicon-s-photo';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Masukkan gambar barang')
                ->schema([
                    TextInput::make('nama_barang')
                        ->maxLength(255)
                        ->required(),

                    FileUpload::make('image_url')
                        ->label('Foto barang')
                        ->image()
                        ->directory('image_url')
                        ->required(),
                    ])
                    ->columnSpan(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID'),

                ImageColumn::make('image_url')
                    ->label('Foto Barang')
                    ->height(100)
                    ->width(100)
                    ->extraImgAttributes(['style' => 'object-fit: cover;']),

                TextColumn::make('nama_barang')
                    ->label('Nama Barang')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
        return 'Foto Barang';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Penjualan';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListImageURLS::route('/'),
            'create' => Pages\CreateImageURL::route('/create'),
            'edit' => Pages\EditImageURL::route('/{record}/edit'),
        ];
    }
}
