<?php

namespace App\Filament\Widgets;

use App\Models\Huissier;
use Filament\Widgets\ChartWidget;

class HuissiersByStatusChart extends ChartWidget
{
    protected static ?string $heading = 'توزيع المفوضين حسب الحالة';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $active = Huissier::where('status', 'active')->count();
        $suspended = Huissier::where('status', 'suspended')->count();
        $retired = Huissier::where('status', 'retired')->count();

        return [
            'datasets' => [
                [
                    'label' => 'عدد المفوضين',
                    'data' => [$active, $suspended, $retired],
                    'backgroundColor' => [
                        '#10b981', // green-500
                        '#ef4444', // red-500
                        '#6b7280', // gray-500
                    ],
                ],
            ],
            'labels' => ['نشط', 'موقف', 'متقاعد'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
