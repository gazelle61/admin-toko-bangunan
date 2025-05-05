<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenjualanResource\Pages;
use App\Filament\Resources\PenjualanResource\RelationManagers;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Penjualan;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenjualanResource extends Resource
{
    protected static ?string $model = Penjualan::class;

    protected static ?string $navigationIcon = 'heroicon-s-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Section::make('Create a Receipt')
                ->description('create receipts over here.')
                ->schema([
                Select::make('barang_id')
                    ->label('Nama barang')
                    ->options(Barang::all()->pluck('nama_barang', 'id'))
                    ->searchable()
                    ->required(),

                DatePicker::make('tgl_transaksi')
                    ->label('Tanggal transaksi')
                    ->required(),

                Select::make('kategori_id')
                    ->label('Kategori barang')
                    ->options(Kategori::all()->pluck('nama_kategori', 'id'))
                    ->searchable()
                    ->required(),

                TextInput::make('total_pemasukan')
                    ->label('Pemasukan')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                TextInput::make('jumlah_terjual')
                    ->label('Jumlah terjual')
                    ->numeric()
                    ->required(),

                TextInput::make('kontak_pelanggan')
                    ->label('Kontak pelanggan')
                    ->maxLength(15)
                    ->required(),
                ])
                ->columnSpan(1)
                ->columns(1),

            Section::make('Unggah struk transaksi')
                ->schema([
                    FileUpload::make('bukti_transaksi')
                    ->image()
                    ->directory('bukti_transaksi')
                    ->columnSpanFull(),
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

                TextColumn::make('barang.nama_barang')
                    ->label('Nama Barang')
                    ->searchable(),

                TextColumn::make('tgl_transaksi')
                    ->label('Tanggal Transaksi')
                    ->date(),

                TextColumn::make('kategori.nama_kategori')
                    ->label('Kategori Barang')
                    ->searchable(),

                TextColumn::make('total_pemasukan')
                    ->label('Pemasukan')
                    ->money('IDR', true),

                TextColumn::make('jumlah_terjual')
                    ->label('Jumlah Terjual')
                    ->numeric(),

                TextColumn::make('kontak_pelanggan')
                    ->label('Kontak Pelanggan')
                    ->searchable(),

                ImageColumn::make('bukti_transaksi')
                    ->label('Struk Transaksi')
                    ->height(100)
                    ->width(100),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
        return 'Penjualan Barang';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Penjualan';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenjualans::route('/'),
            'create' => Pages\CreatePenjualan::route('/create'),
            'edit' => Pages\EditPenjualan::route('/{record}/edit'),
        ];
    }
}
