<?php

namespace App\Filament\Widgets;

use App\Models\Employer;
use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class DateOverviewWidget extends ChartWidget
{

    use InteractsWithPageFilters;

    protected static ?string $heading = 'Date Overview Chart';

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {

        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        //-------------------------------------------
        //-------------------------------------------
        $userData = Trend::model(User::class)
            ->between(
                start: $startDate ? Carbon::parse($startDate) : now()->startOfYear(),
                end: $endDate ? Carbon::parse($endDate) : now()->endOfYear(),
            )
            ->perMonth()
            ->count();
        //-------------------------------------------
        //-------------------------------------------
        $employerData = Trend::model(Employer::class)
            ->between(
                start: $startDate ? Carbon::parse($startDate) : now()->startOfYear(),
                end: $endDate ? Carbon::parse($endDate) : now()->endOfYear(),
            )
            ->perMonth()
            ->count();
        //-------------------------------------------
        //-------------------------------------------
        $jobData = Trend::model(Job::class)
            ->between(
                start: $startDate ? Carbon::parse($startDate) : now()->startOfYear(),
                end: $endDate ? Carbon::parse($endDate) : now()->endOfYear(),
            )
            ->perMonth()
            ->count();
        //-------------------------------------------
        //-------------------------------------------

        return [
            'datasets' => [
                [
                    'label' => 'Users Joined',
                    'data' => $userData->map(fn(TrendValue $value) => $value->aggregate),
                    'borderColor' => 'rgb(59, 130, 246)',
                    'tension' => 0.4,
                ],

                [
                    'label' => 'Employers Joined',
                    'data' => $employerData->map(fn(TrendValue $value) => $value->aggregate),
                    'borderColor' => 'rgb(34, 197, 94)',
                    'tension' => 0.4,
                ],

                [
                    'label' => 'Jobs Posted',
                    'data' => $jobData->map(fn(TrendValue $value) => $value->aggregate),
                    'borderColor' => 'rgb(234, 179, 8)',
                    'tension' => 0.4,
                ],
            ],

            // 'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            // 'labels' => $userData->map(fn(TrendValue $value) => $value->date),
            'labels' => $userData->map(fn(TrendValue $value) => \Carbon\Carbon::parse($value->date)->format('M')),

        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
