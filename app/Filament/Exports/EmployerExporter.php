<?php

namespace App\Filament\Exports;

use App\Models\Employer;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class EmployerExporter extends Exporter
{
    protected static ?string $model = Employer::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('ID')->enabledByDefault(false),
            ExportColumn::make('name'),
            ExportColumn::make('industry'),
            ExportColumn::make('website'),
            ExportColumn::make('email'),
            ExportColumn::make('phonenumber')->label('Phone Number'),
            ExportColumn::make('type'),
            ExportColumn::make('number_of_employees')->label('Number of Employees'),
            ExportColumn::make('created_at')->label('Joined'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your employer export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
