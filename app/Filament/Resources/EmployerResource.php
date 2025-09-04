<?php

namespace App\Filament\Resources;

use App\Filament\Exports\EmployerExporter;
use App\Filament\Resources\EmployerResource\Pages;
use App\Filament\Resources\EmployerResource\RelationManagers;
use App\Filament\Resources\EmployerResource\RelationManagers\ApplicationRelationManager;
use App\Filament\Resources\EmployerResource\RelationManagers\JobsRelationManager;
use App\Models\Employer;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployerResource extends Resource
{
    protected static ?string $model = Employer::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 3;

    //------------------------------------------------------
    //------------------------------------------------------
    //IMPORTANT
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            // ->with('jobs.tags') //eager loads the tags model
            ->latest(); // same as ->orderBy('created_at', 'desc')
    }
    //------------------------------------------------------
    //------------------------------------------------------
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }
    //------------------------------------------------------
    //------------------------------------------------------


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Employer Information')->schema([
                        Grid::make(1)->schema([
                            TextInput::make('name'),
                        ]),

                        Grid::make(2)->schema([
                            TextInput::make('industry'),
                            TextInput::make('type'),
                        ]),
                        Grid::make(2)->schema([
                            TextInput::make('number_of_employees')->label('Number of Employees'),
                            TextInput::make('created_at')
                                ->label('Joined')
                                ->afterStateHydrated(
                                    function ($component, $record) {
                                        $formatted = optional($record?->created_at)->format('F d, Y | h:i A'); // ex: June 23, 2025 04:15 AM
                                        $component->state($formatted);
                                    }
                                )
                                ->disabled()
                                ->dehydrated(false),
                        ])
                    ]),

                    Section::make('About')->schema([
                        Textarea::make('description')
                            ->label('Description')
                            ->rows(9),
                    ]),
                ])->columnSpan(2),

                Group::make()->schema([
                    Section::make('Contact Details')->schema([
                        Grid::make(1)->schema([
                            TextInput::make('email'),
                            TextInput::make('phonenumber')->label('Phone Number'),
                            TextInput::make('website'),
                        ])
                    ]),
                    Section::make('Company Logo')->schema([
                        FileUpload::make('logo')
                            ->label(false)
                            ->disk('public')
                            ->directory('logos')
                            ->image(),
                    ]),
                ])->columnSpan(1),

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->getStateUsing(fn($record) => $record->logo ? asset($record->logo) : null) // this builds the full URL
                    ->height(40)
                    ->circular(),
                TextColumn::make('name')->searchable()->toggleable(),
                TextColumn::make('industry')->searchable()->toggleable(),
                TextColumn::make('website')->searchable()->toggleable(),
                TextColumn::make('email')->searchable()->toggleable(),
                TextColumn::make('phonenumber')->label('Phone Number')->searchable()->toggleable(),
                TextColumn::make('type')->searchable()->toggleable(),
                TextColumn::make('number_of_employees')->label('Number of Employees')->toggleable(),
                TextColumn::make('created_at')->label('Joined')->date('M. d, Y | h:i A')->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make()->color('success'),
            ])
            ->headerActions([
                ExportAction::make()->exporter(EmployerExporter::class),
            ])
            ->bulkActions([
                ExportBulkAction::make()->exporter(EmployerExporter::class),
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            JobsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployers::route('/'),
            'create' => Pages\CreateEmployer::route('/create'),
            'edit' => Pages\EditEmployer::route('/{record}/edit'),
            'view' => Pages\ViewEmployer::route('/{record}'),
        ];
    }
}
