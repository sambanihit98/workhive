<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class GeneralSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static string $view = 'filament.pages.general-settings';
    protected static ?int $navigationSort = 9;
    protected static ?string $navigationGroup = 'Account & Settings';
}
