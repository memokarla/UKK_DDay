<?php

namespace App\Filament\Widgets;

use App\Models\Siswa;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DataPklOverall extends BaseWidget
{
    protected static ?string $pollingInterval = '15s';
    
    protected function getStats(): array
    {
        $totalSiswa = Siswa::count();
        $siswaLaporPkl = Siswa::where('status_lapor_pkl', true)->count();
        $siswaBelumLapor = $totalSiswa - $siswaLaporPkl;
        
        $persentaseLapor = $totalSiswa > 0 ? round(($siswaLaporPkl / $totalSiswa) * 100, 1) : 0;

        return [
            Stat::make('Total Siswa', $totalSiswa)
                ->description('Jumlah seluruh siswa')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),

            Stat::make('Sudah Lapor PKL', $siswaLaporPkl)
                ->description($persentaseLapor . '% dari total siswa')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Belum Lapor PKL', $siswaBelumLapor)
                ->description('Siswa yang belum lapor')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}