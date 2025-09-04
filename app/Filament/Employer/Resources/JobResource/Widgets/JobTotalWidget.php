<?php

namespace App\Filament\Employer\Resources\JobResource\Widgets;

use App\Models\Employer;
use App\Models\Job;
use Carbon\Carbon;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;


class JobTotalWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            //TOTAL OVERALL
            Stat::make('Total Jobs', Job::where('employer_id', auth()->id())->count())
                ->description('All job posts you have created')
                ->color('info'),

            Stat::make('Non-Urgent Hiring', Job::where('employer_id', auth()->id())->where('urgent_hiring', 0)->count())
                ->description('All non-urgent hiring jobs')
                ->color('success'),

            Stat::make('Urgent Hiring', Job::where('employer_id', auth()->id())->where('urgent_hiring', 1)->count())
                ->description('All urgent hiring jobs')
                ->color('danger'),
        ];
    }
}
