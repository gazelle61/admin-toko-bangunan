<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangResource\Pages;
use App\Filament\Resources\BarangResource\RelationManagers;
use App\Models\Barang;
use App\Models\Kategori;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
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

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Masukkan barang baru')
                ->schema([
                    TextInput::make('nama_barang')
                        ->maxLength(255)
                        ->required(),

                    Select::make('kategori_id')
                        ->options(Kategori::all()->pluck('nama_kategori', 'id'))
                        ->label('Kategori barang')
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
                ])
                ->columnSpan(1)
                ->columns(1),

            Section::make('Unggah foto barang')
                ->schema([
                    FileUpload::make('foto_barang')
                        ->image()
                        ->directory('foto_barang')
                        ->nullable()
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

                ImageColumn::make('foto_barang')
                    ->label('Foto Barang')
                    ->height(100)
                    ->width(100)
                    ->extraImgAttributes(['style' => 'object-fit: cover;']),

                TextColumn::make('nama_barang')
                    ->label('Nama Barang')
                    ->searchable(),
                    // ->sortable()

                TextColumn::make('kategori.nama_kategori')
                    ->label('Kategori')
                    ->searchable(),

                TextColumn::make('harga')
                    ->money('IDR', true),

                TextColumn::make('stok'),

                TextColumn::make('deskripsi'),
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
                    Tables\Actions\DeleteBulkAction::make()
                ])
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
        return 'Barang';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Penjualan';
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
