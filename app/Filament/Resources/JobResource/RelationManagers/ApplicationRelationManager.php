<?php

namespace App\Filament\Resources\JobResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Grid;
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
                Section::make('Personal Information')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('first_name')
                                ->label('First Name')
                                ->afterStateHydrated(fn($component, $record) => $component->state($record?->user?->first_name)),
                            TextInput::make('middle_name')
                                ->label('Middle Name')
                                ->afterStateHydrated(fn($component, $record) => $component->state($record?->user?->middle_name)),
                            TextInput::make('last_name')
                                ->label('Last Name')
                                ->afterStateHydrated(fn($component, $record) => $component->state($record?->user?->last_name)),
                        ]),
                        Grid::make(3)->schema([
                            TextInput::make('birthdate')
                                ->afterStateHydrated(fn($component, $record) => $component->state($record?->user?->birthdate)),

                            TextInput::make('email')
                                ->afterStateHydrated(fn($component, $record) => $component->state($record?->user?->email)),

                            TextInput::make('phone_number')
                                ->label('Phone Number')
                                ->afterStateHydrated(fn($component, $record) => $component->state($record?->user?->phone_number)),
                        ]),
                    ])
                    ->disabled()
                    ->columns(1)
                    ->collapsible(),

                Section::make('Address')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('street')
                                ->afterStateHydrated(fn($component, $record) => $component->state($record?->user?->user_address?->street)),
                            TextInput::make('barangay')
                                ->afterStateHydrated(fn($component, $record) => $component->state($record?->user?->user_address?->barangay)),
                        ]),
                        Grid::make(3)->schema([
                            TextInput::make('city')
                                ->afterStateHydrated(fn($component, $record) => $component->state($record?->user?->user_address?->city)),
                            TextInput::make('province')
                                ->afterStateHydrated(fn($component, $record) => $component->state($record?->user?->user_address?->province)),
                            TextInput::make('zip_code')
                                ->label('Zip Code')
                                ->afterStateHydrated(fn($component, $record) => $component->state($record?->user?->user_address?->zip_code)),

                        ]),
                    ])
                    ->disabled()
                    ->columns(1)
                    ->collapsible()
                    ->collapsed(),
                Section::make('Application Info')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('created_at')
                                ->label('Date Applied')
                                ->afterStateHydrated(function ($component, $record) {
                                    $formatted = optional($record?->created_at)->format('F d, Y | h:i A'); // e.g., June 23, 2025 04:15 AM
                                    $component->state($formatted);
                                })
                                ->disabled()
                                ->dehydrated(false),
                            Select::make('status')
                                ->required()
                                ->options([
                                    'Pending' => 'Pending',
                                    'Reviewed' => 'Reviewed',
                                    'Hired' => 'Hired',
                                    'Rejected' => 'Rejected',
                                    'Withdrawn' => 'Withdrawn',
                                ])
                        ]),
                        Grid::make(1)->schema([
                            Textarea::make('cover_letter')->label('Cover Letter')->rows(8)->disabled()
                        ]),
                    ])->collapsible(),
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
