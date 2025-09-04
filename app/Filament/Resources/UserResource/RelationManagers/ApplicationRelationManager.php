<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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
                //---------------------------------------------------------------------------------------------
                //---------------------------------------------------------------------------------------------
                Section::make('Application Information')->schema([
                    TextInput::make('employer')
                        ->label('Employer')
                        ->afterStateHydrated(fn($component, $record) => $component->state($record?->job?->employer?->name)),
                    Grid::make(1)->schema([
                        TextInput::make('title')
                            ->label('Job Title')
                            ->afterStateHydrated(fn($component, $record) => $component->state($record?->job?->title)),
                    ]),
                    Grid::make(2)->schema([
                        TextInput::make('created_at')
                            ->label('Date Applied')
                            ->afterStateHydrated(
                                function ($component, $record) {
                                    $formatted = optional($record?->created_at)->format('F d, Y | h:i A'); // ex: June 23, 2025 04:15 AM
                                    $component->state($formatted);
                                }
                            )
                            ->disabled()
                            ->dehydrated(false),
                        TextInput::make('status')
                            ->label('Status')
                    ]),
                    Grid::make(1)->schema([
                        Textarea::make('cover_letter')->label('Cover Letter')->rows(8)->disabled()
                    ]),

                ])->collapsible(),
                //---------------------------------------------------------------------------------------------
                //---------------------------------------------------------------------------------------------
                Section::make('Job Information')->schema([
                    TextInput::make('employer')
                        ->label('Employer')
                        ->afterStateHydrated(fn($component, $record) => $component->state($record?->job?->employer?->name)),
                    TextInput::make('title')
                        ->afterStateHydrated(fn($component, $record) => $component->state($record?->job?->title)),
                    Grid::make(2)->schema([
                        TextInput::make('salary')
                            ->afterStateHydrated(fn($component, $record) => $component->state($record?->job?->salary)),
                        TextInput::make('location')
                            ->afterStateHydrated(fn($component, $record) => $component->state($record?->job?->location)),
                        TextInput::make('employment_type')
                            ->afterStateHydrated(fn($component, $record) => $component->state($record?->job?->employment_type)),
                        Select::make('urgent_hiring')
                            ->afterStateHydrated(fn($component, $record) => $component->state($record?->job?->urgent_hiring))
                            ->options([
                                '0' => 'No',
                                '1' => 'Yes',
                            ]),
                    ]),

                    RichEditor::make('description')
                        ->afterStateHydrated(fn($component, $record) => $component->state($record?->job?->description))
                        ->columnSpanFull(),

                    Select::make('tags')
                        ->label('Tags')
                        ->multiple()
                        ->options(
                            fn($record) =>
                            $record?->job?->tags->pluck('name', 'id')->toArray() ?? []
                        )
                        ->afterStateHydrated(
                            fn($component, $record) =>
                            $component->state($record?->job?->tags->pluck('id')->toArray())
                        )
                        ->disabled()


                ])->disabled()->collapsible()->collapsed(),
                //---------------------------------------------------------------------------------------------
                //---------------------------------------------------------------------------------------------
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('job.employer.name')->label('Employer')->searchable()->toggleable(),
                TextColumn::make('job.title')->label('Job Title')->searchable()->toggleable(),
                TextColumn::make('job.salary')->label('Salary')->searchable()->toggleable(),
                TextColumn::make('job.location')->label('Location')->searchable()->toggleable(),
                TextColumn::make('job.employment_type')->label('Employment Type')->searchable()->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Pending'    => 'warning',   // yellow
                        'Reviewed'   => 'info',      // blue
                        'Hired'      => 'success',   // green
                        'Rejected'   => 'danger',    // red 
                        'Withdrawn'  => 'gray',      // gray
                        default      => 'gray',      // fallback
                    })->searchable()->toggleable(),
                TextColumn::make('created_at')->label('Date Applied')->date('M. d, Y | h:i A')->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make()->color('success'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
