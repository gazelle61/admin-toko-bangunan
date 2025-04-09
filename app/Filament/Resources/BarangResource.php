<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangResource\Pages;
use App\Filament\Resources\BarangResource\RelationManagers;
use App\Models\Barang;
use App\Models\Kategori;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static ?string $navigationIcon = 'heroicon-s-cube';

    protected static ?string $modelLabel = 'Barang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_barang')
                ->required()
                ->maxLength(255),

                Select::make('kategori_id')
                ->options(Kategori::all()->pluck('nama_kategori', 'id'))
                ->searchable()
                ->required(),

                TextInput::make('harga')
                ->numeric()
                ->prefix('Rp')
                ->required(),

                TextInput::make('stok')
                ->numeric()
                ->required(),

                Textarea::make('deskripsi')
                ->required(),

                FileUpload::make('foto_barang')
                ->image()
                ->directory('foto_barang')
                ->nullable()
                ->multiple(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_barang')->searchable()->sortable(),
                TextColumn::make('kategori.nama_kategori')->label('Kategori'),
                TextColumn::make('harga')->money('IDR', true),
                TextColumn::make('stok'),
                TextColumn::make('deskripsi'),
                ImageColumn::make('foto_barang')->label('Foto Barang'),
            ])
            ->filters([
                //
            ])
            ->actions([
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarangs::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
        ];
    }
}
