<?php

namespace App\Filament\Widgets;

use App\Models\Bill;
use App\Models\Customer;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            stat::make('اجمالي المذكرات :', Bill::count())
                ->description('عدد المذكرات التي تم ادخالها.')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->chart([15, 30, 22, 40, 25, 50])
                ->color('warning'),

            stat::make(' الزبائن:', Customer::count())
                ->description('الزبائن.')
                ->descriptionIcon('heroicon-o-identification')
                ->chart([10, 30, 33, 20, 15, 40])
                ->color('success'),
        ];
    }
}

