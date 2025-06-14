<?php

namespace App\Filament\Resources\CustomerResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Customer;

class CustomerOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Customers', Customer::count()),
            Stat::make('Active Plans', '42'),
            Stat::make('Orders Today', '17'),
            Stat::make('Pending Issues', '3'),
        ];
    }
}