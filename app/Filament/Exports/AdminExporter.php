<?php

namespace App\Filament\Exports;

use App\Models\Admin;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;

class AdminExporter extends Exporter
{
    protected static ?string $model = Admin::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name'),
            ExportColumn::make('email'),
            ExportColumn::make('created_at')->label('Joined'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your admin export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
