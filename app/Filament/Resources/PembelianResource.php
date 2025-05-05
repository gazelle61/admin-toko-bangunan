<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembelianResource\Pages;
use App\Filament\Resources\PembelianResource\RelationManagers;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Pembelian;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
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
use PhpParser\Node\Stmt\Label;

class PembelianResource extends Resource
{
    protected static ?string $model = Pembelian::class;

    protected static ?string $navigationIcon = 'heroicon-s-clipboard-document-list';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Create a Receipt')
                ->description('create receipts over here.')
                ->schema([
                    Select::make('supplier_id')
                        ->label('Nama supplier')
                        ->options(Supplier::all()->pluck('nama_supplier', 'id'))
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

                    Select::make('barang_id')
                        ->label('Nama barang')
                        ->options(Barang::all()->pluck('nama_barang', 'id'))
                        ->searchable()
                        ->required(),

                    TextInput::make('jumlah_pembelian')
                        ->label('Jumlah pembelian')
                        ->numeric()
                        ->required(),

                    TextInput::make('harga')
                        ->label('Total pengeluaran')
                        ->numeric()
                        ->prefix('Rp')
                        ->required(),
                ])
                ->columnSpan(1)
                ->columns(2),

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

                TextColumn::make('supplier.nama_supplier')
                    ->label('Nama Supplier')
                    ->searchable(),

                TextColumn::make('tgl_transaksi')
                    ->label('Tanggal Transaksi')
                    ->date(),

                TextColumn::make('kategori.nama_kategori')
                    ->label('Kategori Barang')
                    ->searchable(),

                TextColumn::make('barang.nama_barang')
                    ->label('Nama Barang')
                    ->searchable(),

                TextColumn::make('jumlah_pembelian')
                    ->label('Jumlah Pembelian')
                    ->numeric(),

                TextColumn::make('harga')
                    ->label('Total Pengeluaran')
                    ->money('IDR', true),

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
                    ->toggleable(isToggledHiddenByDefault: true)
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
        return 'Pembelian Barang';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Pengeluaran';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPembelians::route('/'),
            'create' => Pages\CreatePembelian::route('/create'),
            'edit' => Pages\EditPembelian::route('/{record}/edit'),
        ];
    }
}
