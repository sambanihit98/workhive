<?php

namespace App\Filament\Widgets;

// use Carbon\Carbon;

use App\Models\Employer;
use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\View;

class TotalOverallWidget extends BaseWidget
{

    use InteractsWithPageFilters;

    protected function getStats(): array
    {

        // $startDate = $this->filters['startDate'] ?? null;
        // $endDate = $this->filters['endDate'] ?? null;

        // Filter values
        $startDate = $this->filters['startDate'] ?: now()->startOfYear()->toDateString();
        $endDate = $this->filters['endDate'] ?: now()->endOfYear()->toDateString();


        // Convert to Carbon and set bounds
        $start = Carbon::parse($startDate)->startOfMonth();
        $end = Carbon::parse($endDate)->endOfMonth();

        // Get all months between start and end
        $months = [];
        $current = $start->copy();
        while ($current->lte($end)) {
            $months[] = $current->copy();
            $current->addMonth();
        }

        //-----------------------------------------------------------------------
        //-----------------------------------------------------------------------
        $monthlyUserCounts = collect($months)->map(function ($month) {
            return User::whereBetween('created_at', [
                $month->copy()->startOfMonth(),
                $month->copy()->endOfMonth()
            ])->count();
        })->toArray();
        //-----------------------------------------------------------------------
        $monthlyEmployerCounts = collect($months)->map(function ($month) {
            return Employer::whereBetween('created_at', [
                $month->copy()->startOfMonth(),
                $month->copy()->endOfMonth()
            ])->count();
        })->toArray();
        //-----------------------------------------------------------------------
        $monthlyJobsCounts = collect($months)->map(function ($month) {
            return Job::whereBetween('created_at', [
                $month->copy()->startOfMonth(),
                $month->copy()->endOfMonth()
            ])->count();
        })->toArray();
        //-----------------------------------------------------------------------
        //-----------------------------------------------------------------------

        return [

            //TOTAL OVERALL

            Stat::make(
                'Users',
                User::when(
                    $startDate,
                    fn($query) => $query->whereDate('created_at', '>', $startDate)
                )
                    ->when($endDate, fn($query) => $query->whereDate('created_at', '<', $endDate))->count()
            )

                ->description('Total users (applicants) joined')
                ->chart($monthlyUserCounts)
                ->descriptionIcon('heroicon-o-users', IconPosition::Before)
                ->color('info'),


            Stat::make(
                'Employers',
                Employer::when(
                    $startDate,
                    fn($query) => $query->whereDate('created_at', '>', $startDate)
                )
                    ->when($endDate, fn($query) => $query->whereDate('created_at', '<', $endDate))->count()
            )
                ->description('Total employers joined')
                ->chart($monthlyEmployerCounts)
                ->descriptionIcon('heroicon-o-rectangle-stack', IconPosition::Before)
                ->color('success'),

            Stat::make(
                'Jobs',
                Job::when(
                    $startDate,
                    fn($query) => $query->whereDate('created_at', '>', $startDate)
                )
                    ->when($endDate, fn($query) => $query->whereDate('created_at', '<', $endDate))->count()
            )
                ->description('Total jobs posted')
                ->chart($monthlyJobsCounts)
                ->descriptionIcon('heroicon-o-briefcase', IconPosition::Before)
                ->color('warning'),

        ];
    }
}
