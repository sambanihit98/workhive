<?php

namespace App\Filament\Employer\Resources\JobResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApplicationRelationManager extends RelationManager
{
    protected static string $relationship = 'application';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('status')
                    ->required()
                    ->options([
                        'Pending' => 'Pending',
                        'Reviewed' => 'Reviewed',
                        'Hired' => 'Hired',
                        'Rejected' => 'Rejected',
                        'Withdrawn' => 'Withdrawn',
                    ])
                    ->columnSpanFull()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('user.first_name')->label('First Name')->toggleable(),
                TextColumn::make('user.middle_name')->label('Middle Name')->toggleable(),
                TextColumn::make('user.last_name')->label('Last Name')->toggleable(),
                // TextColumn::make('job.title')->label('Job Title')->toggleable(),
                // TextColumn::make('resume'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Pending'    => 'warning',   // yellow
                        'Reviewed'   => 'info',      // blue
                        'Hired'      => 'success',   // green
                        'Rejected'   => 'danger',    // red
                        'Withdrawn'  => 'gray',      // gray
                        default      => 'gray',      // fallback
                    })->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->modalWidth('md'),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
