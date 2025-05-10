<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\OverviewStats;
use App\Filament\Widgets\PenjualanChart;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-s-home';

    protected static ?string $modelLabel = 'Dashboard';

    protected function getHeaderWidgets(): array
    {
        return[
            OverviewStats::class,
            PenjualanChart::class,
        ];
    }
}
