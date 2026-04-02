<?php

namespace App\Filament\Widgets;

use App\Models\Region;
use Filament\Widgets\ChartWidget;

class HuissiersByRegionChart extends ChartWidget
{
    protected static ?string $heading = 'توزيع المفوضين حسب الجهة';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $data = Region::withCount('huissiers')->pluck('huissiers_count', 'name');

        return [
            'datasets' => [
                [
                    'label' => 'المفوضون',
                    'data' => $data->values()->toArray(),
                    'backgroundColor' => '#f59e0b', // amber-500
                ],
            ],
            'labels' => $data->keys()->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
