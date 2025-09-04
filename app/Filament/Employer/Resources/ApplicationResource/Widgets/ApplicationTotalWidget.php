<?php

namespace App\Filament\Employer\Resources\ApplicationResource\Widgets;

use App\Models\Application;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ApplicationTotalWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            //TOTAL OVERALL
            Stat::make('Applications', Application::whereHas(
                'job',
                function ($query) {
                    $query->where('employer_id', auth()->id());
                }
            )->count())
                ->description('Total Applications')
                ->color('sucess'),

            Stat::make('Pending Applications', Application::whereHas(
                'job',
                function ($query) {
                    $query->where('employer_id', auth()->id());
                }
            )->where('status', 'Pending')->count())
                ->description('Total Pending Applications')
                ->color('warning'),

            Stat::make('Reviewed Applications', Application::whereHas(
                'job',
                function ($query) {
                    $query->where('employer_id', auth()->id());
                }
            )->where('status', 'Reviewed')->count())
                ->description('Total Reviewed Applications')
                ->color('info'),

            Stat::make('Hired Applications', Application::whereHas(
                'job',
                function ($query) {
                    $query->where('employer_id', auth()->id());
                }
            )->where('status', 'Hired')->count())
                ->description('Total Hired Applications')
                ->color('success'),

            Stat::make('Rejected Applications', Application::whereHas(
                'job',
                function ($query) {
                    $query->where('employer_id', auth()->id());
                }
            )->where('status', 'Rejected')->count())
                ->description('Total Rejected Applications')
                ->color('danger'),

            Stat::make('Withdrawn Applications', Application::whereHas(
                'job',
                function ($query) {
                    $query->where('employer_id', auth()->id());
                }
            )->where('status', 'Withdrawn')->count())
                ->description('Total Withdrawn Applications')
                ->color('gray'),
        ];
    }
}
