<?php

namespace App\Filament\Employer\Resources\JobResource\Pages;

use App\Filament\Employer\Resources\JobResource;
use App\Filament\Employer\Resources\JobResource\Widgets\JobTotalWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJobs extends ListRecords
{
    protected static string $resource = JobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            JobTotalWidget::class,
        ];
    }
}
