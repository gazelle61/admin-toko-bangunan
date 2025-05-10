<?php

namespace App\Filament\Widgets;

use App\Models\Penjualan;
use Illuminate\Support\Carbon;
use Filament\Widgets\ChartWidget;

class PenjualanChart extends ChartWidget
{
    protected static ?string $heading = 'Total Penjualan';

    public ?string $filter = 'mingguan';

    protected function getData(): array
    {
        switch ($this->filter) {
            case 'mingguan':
                default:
                    $data = Penjualan::selectRaw('DATE(created_at) as tanggal, SUM(jumlah_terjual) as total')
                        ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                        ->groupBy('tanggal')
                        ->orderBy('tanggal')
                        ->get();

                    $labels = $data->pluck('tanggal')
                        ->map(fn ($tgl) => Carbon::parse($tgl)->format('D'))
                        ->toArray();
                    break;

            case 'bulanan':
                $data = Penjualan::selectRaw('DATE(created_at) as tanggal, SUM(jumlah_terjual) as total')
                    ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                    ->groupBy('tanggal')
                    ->orderBy('tanggal')
                    ->get();

                $labels = $data->pluck('tanggal')
                    ->map(fn ($tgl) => Carbon::parse($tgl)->format('d M'))
                    ->toArray();
                break;

            case 'tahunan':
                $data = Penjualan::selectRaw('MONTH(created_at) as bulan, SUM(jumlah_terjual) as total')
                    ->whereYear('created_at', now()->year)
                    ->groupBy('bulan')
                    ->orderBy('bulan')
                    ->get();

                $labels = $data->pluck('bulan')
                    ->map(fn ($bulan) => Carbon::create()->month($bulan)->format('F'))
                    ->toArray();
                break;
        }
        $values = $data->pluck('total')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Total Penjualan',
                    'data' => $values,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59,130,246,0.4)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    public static function getColumns(): int
    {
        return 12;
    }

    protected function getFilters(): ?array
    {
        return [
            'mingguan' => 'Mingguan',
            'bulanan' => 'Bulanan',
            'tahunan' => 'Tahunan',
        ];
    }

}
