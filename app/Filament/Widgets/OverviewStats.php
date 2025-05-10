<?php

namespace App\Filament\Widgets;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OverviewStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Kategori', Kategori::count())
                ->description('Jumlah kategori barang')
                ->color('primary')
                ->icon('heroicon-o-squares-plus')
                ->url(route('filament.admin.resources.kategoris.index')),

            Stat::make('Barang', Barang::count())
                ->description('Total barang tersedia')
                ->color('primary')
                ->icon('heroicon-o-cube')
                ->url(route('filament.admin.resources.barangs.index')),

            Stat::make('Supplier', Supplier::count())
                ->description('Total supplier terdaftar')
                ->color('primary')
                ->icon('heroicon-o-user-group')
                ->url(route('filament.admin.resources.suppliers.index')),
        ];
    }
}
