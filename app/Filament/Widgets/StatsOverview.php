<?php

namespace App\Filament\Widgets;

use App\Models\Huissier;
use App\Models\Region;
use App\Models\Tribunal;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();

        if ($user->isHuissier()) {
            return [
                Stat::make('إجراءاتي', \App\Models\Acte::where('huissier_id', $user->huissier_id)->count())
                    ->description('إجمالي الملفات المسندة')
                    ->color('primary'),
                Stat::make('إجراءات منجزة', \App\Models\Acte::where('huissier_id', $user->huissier_id)->where('status', 'completed')->count())
                    ->description('الملفات التي تم تنفيذها')
                    ->color('success'),
                Stat::make('في الانتظار', \App\Models\Acte::where('huissier_id', $user->huissier_id)->where('status', 'pending')->count())
                    ->description('الملفات قيد المعالجة')
                    ->color('warning'),
            ];
        }

        if ($user->isRegionalAdmin()) {
            $regionId = $user->region_id;
            return [
                Stat::make('مفوضو الجهة', Huissier::whereHas('tribunal', fn($q) => $q->where('region_id', $regionId))->count())
                    ->description('المفوضون التابعون للدائرة')
                    ->color('primary'),
                Stat::make('إجراءات الجهة', \App\Models\Acte::whereHas('huissier.tribunal', fn($q) => $q->where('region_id', $regionId))->count())
                    ->description('إجمالي الملفات بالجهة')
                    ->color('success'),
                Stat::make('المحاكم', Tribunal::where('region_id', $regionId)->count())
                    ->description('محاكم الدائرة الاستئنافية')
                    ->color('gray'),
            ];
        }

        // Super Admin & National Admin View
        return [
            Stat::make('المفوضون القضائيون', Huissier::count())
                ->description('إجمالي المفوضين المسجلين')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('المحاكم', Tribunal::count())
                ->description('عدد المحاكم المغطاة')
                ->descriptionIcon('heroicon-m-building-library')
                ->color('success'),

            Stat::make('الجهات', Region::count())
                ->description('التغطية الجهوية')
                ->descriptionIcon('heroicon-m-map')
                ->color('warning'),
        ];
    }
}
