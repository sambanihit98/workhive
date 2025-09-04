<?php

namespace App\Filament\Resources\JobResource\Pages;

use App\Filament\Resources\JobResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;

class ListJobs extends ListRecords
{
    protected static string $resource = JobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // public function getTabs(): array
    // {
    //     return [
    //         'All' => Tab::make(),
    //         'Urgent Hiring' => Tab::make()->modifyQueryUsing(function ($query) {
    //             $query->where('urgent_hiring', true);
    //         }),
    //         'Non-Urgent Hiring' => Tab::make()->modifyQueryUsing(function ($query) {
    //             $query->where('urgent_hiring', false);
    //         })

    //     ];
    // }
}
