<?php

namespace App\Filament\Resources;

use App\Filament\Exports\JobExporter;
use App\Filament\Resources\JobResource\Pages;
use App\Filament\Resources\JobResource\RelationManagers;
use App\Filament\Resources\JobResource\RelationManagers\ApplicationRelationManager;
use App\Models\Job;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JobResource extends Resource
{
    protected static ?string $model = Job::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?int $navigationSort = 4;

    //------------------------------------------------------
    //------------------------------------------------------
    // disables actions
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
    //IMPORTANT
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with('tags') //eager loads the tags model
            ->latest(); // same as ->orderBy('created_at', 'desc')
    }
    //------------------------------------------------------
    //------------------------------------------------------

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Job Information')->schema([
                    TextInput::make('title')->required()->columnSpanFull(),
                    Grid::make(2)->schema([
                        TextInput::make('salary')->required(),
                        TextInput::make('location')->required(),
                        TextInput::make('employment_type')->required(),
                        Select::make('urgent_hiring')
                            ->required()
                            ->options([
                                '0' => 'No',
                                '1' => 'Yes',
                            ]),
                    ]),
                    RichEditor::make('description')
                        ->required()
                        ->columnSpanFull(),

                    Select::make('tags')
                        ->label('Tags')
                        ->multiple()
                        ->relationship('tags', 'name') // assumes Application hasMany Tags
                        // ->preload() // tells Filament to load all tag options upfront, which makes them all visible in the dropdown immediately
                        ->searchable()
                        ->columnSpanFull()
                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employer.name')->label('Employer | Company')->searchable()->toggleable(),
                TextColumn::make('title')->label('Job Title')->sortable()->searchable()->toggleable(),
                TextColumn::make('salary')->sortable()->searchable()->toggleable(),
                TextColumn::make('employment_type')->sortable()->searchable()->toggleable(),
                TextColumn::make('location')->sortable()->searchable()->toggleable(),
                BadgeColumn::make('urgent_hiring')
                    ->label('Urgent Hiring')
                    ->formatStateUsing(fn(bool $state) => $state ? 'Yes' : 'No')
                    ->color(fn(bool $state) => $state ? 'success' : 'danger')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('tags')
                    ->label('Tags')
                    ->formatStateUsing(fn($record) => $record->tags->pluck('name')->join(', '))
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('created_at')->label('Date Posted')->date('M. d, Y | h:i A')->sortable()->toggleable(),
            ])
            ->filters([
                Filter::make('Urgent Hiring')->query(
                    function ($query) {
                        return $query->where('urgent_hiring', 1);
                    }
                ),

                Filter::make('Non-Urgent Hiring')->query(
                    function ($query) {
                        return $query->where('urgent_hiring', 0);
                    }
                ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->color('success'),
            ])
            ->headerActions([
                ExportAction::make()->exporter(JobExporter::class),
            ])
            ->bulkActions([
                ExportBulkAction::make()->exporter(JobExporter::class),
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ApplicationRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobs::route('/'),
            'create' => Pages\CreateJob::route('/create'),
            'edit' => Pages\EditJob::route('/{record}/edit'),
            'view' => Pages\ViewJob::route('/{record}'),
        ];
    }
}
