<?php

namespace App\Filament\Widgets;

use App\Models\Acte;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;
use Illuminate\Support\Facades\DB;

class AdvancedStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $user = auth()->user();
        
        // 1. Base Query Scoped by User Role
        $query = Acte::query();

        if ($user->isHuissier()) {
            $query->where('huissier_id', $user->huissier_id);
        } elseif ($user->isRegionalAdmin()) {
            $query->whereHas('huissier.tribunal', function ($q) use ($user) {
                $q->where('region_id', $user->region_id);
            });
        }
        // National Admin sees everything (no filter needed)

        // 2. Calculate Metrics
        
        // A. Total Volume
        $totalActs = (clone $query)->count();
        
        // B. Pending Backlog
        $pendingActs = (clone $query)->whereIn('status', ['pending', 'in_progress'])->count();
        
        // C. Completed Count
        $completedQuery = (clone $query)->whereIn('status', ['completed', 'archived']);
        $completedActs = $completedQuery->count();

        // D. Success Rate calculation
        // Formula: (Completed / Total) * 100. 
        // Note: You might want (Completed / (Completed + Failed)) if you had a failure status. 
        // Here we stick to Completion Rate vs Total.
        $completionRate = $totalActs > 0 ? ($completedActs / $totalActs) * 100 : 0;
        
        // E. Average Execution Time (Days)
        // Only for completed acts that have valid dates
        $avgDays = (clone $query)
            ->whereNotNull('date_depot')
            ->whereNotNull('date_execution')
            ->select(DB::raw('AVG(DATEDIFF(date_execution, date_depot)) as avg_days'))
            ->value('avg_days');
            
        $formattedAvgDays = $avgDays ? number_format((float)$avgDays, 1) . ' يوم' : '--';

        return [
            Stat::make('إجمالي الملفات', $totalActs)
                ->description("منها {$pendingActs} قيد المعالجة")
                ->descriptionIcon('heroicon-m-document-duplicate')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3])
                ->color('primary'),

            Stat::make('نسبة الإنجاز', number_format($completionRate, 1) . '%')
                ->description($completedActs . ' ملف منجز')
                ->descriptionIcon('heroicon-m-check-badge')
                ->chart([$completionRate, $completionRate - 5, $completionRate + 5])
                ->color($completionRate > 80 ? 'success' : ($completionRate > 50 ? 'warning' : 'danger')),

            Stat::make('متوسط مدة التنفيذ', $formattedAvgDays)
                ->description('المدة الزمنية من الدفع للتنفيذ')
                ->descriptionIcon('heroicon-m-clock')
                ->color('info'),
        ];
    }
}
