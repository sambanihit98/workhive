<?php

namespace App\Filament\Employer\Resources\ApplicationResource\Pages;

use App\Filament\Employer\Resources\ApplicationResource;
use Filament\Actions;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewApplication extends ViewRecord
{
    protected static string $resource = ApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Edit Status') // 👈 custom label
                ->icon('heroicon-m-pencil'),
        ];
    }
}
