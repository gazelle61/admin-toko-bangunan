<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierResource\Pages;
use App\Filament\Resources\SupplierResource\RelationManagers;
use App\Models\Kategori;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static ?string $navigationIcon = 'heroicon-s-user-group';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nama_supplier')
                ->label('Nama supplier')
                ->maxLength(255)
                ->required(),

            Select::make('kategori_id')
                ->label('Kategori supplier')
                ->options(Kategori::all()->pluck('nama_kategori', 'id'))
                ->searchable()
                ->required(),

            Textarea::make('barang_supplyan')
                ->label('Barang supplier')
                ->required(),

            TextInput::make('kontak_supplier')
                ->label('Kontak supplier')
                ->maxLength(15)
                ->required(),

            Textarea::make('alamat_supplier')
                ->label('Alamat supplier')
                ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID'),

                TextColumn::make('nama_supplier')
                    ->label('Nama Supplier')
                    ->searchable(),

                TextColumn::make('kategori.nama_kategori')
                    ->label('Kategori Supplier')
                    ->searchable(),

                TextColumn::make('barang_supplyan')
                    ->label('Barang Supplier'),

                TextColumn::make('kontak_supplier')
                    ->label('Kontak Supplier')
                    ->searchable(),

                TextColumn::make('alamat_supplier')
                    ->label('Alamat Supplier'),
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
        return 'Supplier';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Pengeluaran';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }
}
