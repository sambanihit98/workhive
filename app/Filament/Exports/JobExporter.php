<?php

namespace App\Filament\Exports;

use App\Models\Job;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class JobExporter extends Exporter
{
    protected static ?string $model = Job::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('employer.name')->enabledByDefault(false),
            ExportColumn::make('title'),
            ExportColumn::make('salary'),
            ExportColumn::make('location'),
            ExportColumn::make('employment_type')->label('Employment Type'),
            ExportColumn::make('urgent_hiring')->label('Urgent Hiring'),
            ExportColumn::make('created_at')->label('Joined'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your job export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
