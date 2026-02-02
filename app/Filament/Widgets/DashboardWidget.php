<?php

namespace App\Filament\Widgets;

use App\Models\Bill;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            stat::make('عدد المذكرات :' ,Bill::count())
            ->description('عدد المذكرات التي تم ادخالها')
        ];
    }
}
