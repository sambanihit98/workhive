<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class SiteSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
    protected static string $view = 'filament.pages.site-settings';
    protected static ?int $navigationSort = 8;
    protected static ?string $navigationGroup = 'Account & Settings';
}
