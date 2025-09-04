<?php

namespace App\Filament\Employer\Resources\JobResource\Pages;

use App\Filament\Employer\Resources\JobResource;
use Filament\Actions;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewJob extends ViewRecord
{
    protected static string $resource = JobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Edit') // 👈 custom label
                ->icon('heroicon-m-pencil'),
        ];
    }
}
