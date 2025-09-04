<?php

namespace App\Filament\Exports;

use App\Models\User;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Filament\Facades\Filament;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;

class UserExporter extends Exporter
{

    protected static ?string $model = User::class;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('user_address');
    }

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('ID')->enabledByDefault(false),
            ExportColumn::make('first_name'),
            ExportColumn::make('middle_name'),
            ExportColumn::make('last_name'),
            ExportColumn::make('email'),
            ExportColumn::make('phone_number')->label('Phone Number'),
            ExportColumn::make('birthdate'),
            ExportColumn::make('created_at')->label('Joined'),

            // Address fields (if they exist on the related model)
            ExportColumn::make('user_address.street')->label('Street')->enabledByDefault(false),
            ExportColumn::make('user_address.barangay')->label('Barangay')->enabledByDefault(false),
            ExportColumn::make('user_address.city')->label('City')->enabledByDefault(false),
            ExportColumn::make('user_address.province')->label('Province')->enabledByDefault(false),
            ExportColumn::make('user_address.zip_code')->label('ZIP Code')->enabledByDefault(false),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your user export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
