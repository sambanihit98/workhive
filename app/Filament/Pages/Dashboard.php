<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DateOverviewWidget;
use App\Filament\Widgets\TotalOverallWidget;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;



class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form->schema([

            Section::make('Date Range Filter')->schema([
                DatePicker::make('startDate'),
                DatePicker::make('endDate'),
                // Actions::make([
                //     Action::make('Clear Dates')
                //         ->label('Clear')
                //         ->outlined()
                //         ->color('danger')
                //         ->action(function (\Filament\Forms\Set $set) {
                //             $set('startDate', '');
                //             $set('endDate', '');
                //         }),
                // ])->alignEnd()->columnSpanFull()

            ])
                ->columns(2)
                ->description('Select a start and end date to filter the statistics and chart data.')
                ->collapsible()
                ->collapsed()
        ]);
    }

    public function getWidgets(): array
    {
        return [
            TotalOverallWidget::class,
            DateOverviewWidget::class,
        ];
    }
}
