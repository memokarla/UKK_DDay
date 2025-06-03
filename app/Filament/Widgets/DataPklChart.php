<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Pkl;
use App\Models\Industri;
use Illuminate\Support\Facades\DB;

class DataPklChart extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Siswa per Industri';

    protected function getData(): array
    {
        // Ambil jumlah siswa per industri
        $data = Pkl::select('industri_id', DB::raw('count(*) as total'))
            ->groupBy('industri_id')
            ->with('industri')
            ->get()
            ->map(function ($item) {
                return [
                    'nama' => $item->industri->nama ?? 'Tidak diketahui',
                    'total' => $item->total,
                ];
            });

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Siswa',
                    'data' => $data->pluck('total'),
                    'backgroundColor' => '#FCD34D',
                ],
            ],
            'labels' => $data->pluck('nama'),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected static ?int $sort = 3;

    public function getColumnSpan(): int | string | array
    {
        return 'full'; // agar lebar penuh
    }
}
