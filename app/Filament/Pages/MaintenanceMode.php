<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class MaintenanceMode extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static string $view = 'filament.pages.maintenance-mode';

    protected static ?int $navigationSort = 7;
    protected static ?string $navigationGroup = 'Account & Settings';
}
