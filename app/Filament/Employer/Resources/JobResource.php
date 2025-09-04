<?php

namespace App\Filament\Employer\Resources;

use App\Filament\Employer\Resources\JobResource\Pages;
use App\Filament\Employer\Resources\JobResource\RelationManagers;
use App\Filament\Employer\Resources\JobResource\RelationManagers\ApplicationRelationManager;
use App\Filament\Exports\JobExporter;
use App\Models\Job;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class JobResource extends Resource
{
    protected static ?string $model = Job::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    // protected static ?string $modelLabel = 'Job Listings';

    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('employer_id',  Auth::guard('employer')->id())
            ->with('tags')
            ->latest();
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ComponentsSection::make('Job Information')->schema([
                    TextEntry::make('title')
                        ->columnSpanFull()
                        ->label('')
                        ->html()
                        ->formatStateUsing(fn($state) => '<span class="font-bold mb-1">Title: </span>' . e($state) . ''),

                    TextEntry::make('salary')
                        ->label('')
                        ->html()
                        ->formatStateUsing(fn($state) => '<span class="font-bold mb-1">Salary: </span>' . e($state) . ''),

                    TextEntry::make('location')
                        ->label('')
                        ->html()
                        ->formatStateUsing(fn($state) => '<span class="font-bold mb-1">Location: </span>' . e($state) . ''),

                    TextEntry::make('employment_type')
                        ->label('')
                        ->html()
                        ->formatStateUsing(fn($state) => '<span class="font-bold mb-1">Employment Type: </span>' . e($state) . ''),

                    TextEntry::make('urgent_hiring')
                        ->label('') // hide default label
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold mb-1">Urgent Hiring: </span>' . ($state ? 'Yes' : 'No')
                        ),

                    TextEntry::make('description')
                        ->label('') // Hide default label
                        ->html()
                        ->columnSpanFull()
                        ->formatStateUsing(
                            fn($state) =>
                            '<div class="font-bold mb-1">Description:</div>' . $state
                        ),

                    TextEntry::make('tags')
                        ->label('') // Hide default label
                        ->html() // Render custom HTML
                        ->formatStateUsing(
                            fn($state, $record) =>
                            $record->tags->isNotEmpty()
                                ? '<span class="font-bold mb-1">Tags: </span>' . e($record->tags->pluck('name')->join(', '))
                                : null
                        )
                        ->hidden(fn($record) => $record->tags->isEmpty())
                        ->columnSpanFull(),


                    // TextEntry::make('tags')
                    //     ->label('Tags')
                    //     ->formatStateUsing(
                    //         fn($state, $record) =>
                    //         $record->tags->pluck('name')->join(', ')
                    //     )
                    //     ->columnSpanFull()
                    //     ->hidden(fn($record) => $record->tags->isEmpty()),

                ])->collapsible()

            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                //-----------------------------------------------------------
                //important
                Hidden::make('employer_id')
                    ->default(fn() => Auth::guard('employer')->id()),
                //-----------------------------------------------------------

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
                ])->collapsible(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Job Title')->searchable()->toggleable(),
                TextColumn::make('salary')->searchable()->toggleable(),
                TextColumn::make('employment_type')->searchable()->toggleable(),
                TextColumn::make('location')->searchable()->toggleable(),
                BadgeColumn::make('urgent_hiring')
                    ->label('Urgent Hiring')
                    ->formatStateUsing(fn(bool $state) => $state ? 'Yes' : 'No')
                    ->color(fn(bool $state) => $state ? 'success' : 'danger')
                    ->toggleable(),
                TextColumn::make('tags')
                    ->label('Tags')
                    ->formatStateUsing(fn($record) => $record->tags->pluck('name')->join(', '))
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('created_at')->label('Date Posted')->date('M. d, Y | h:i A')->toggleable(),


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
                Tables\Actions\EditAction::make()->color('info'),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make()->color('success'),
            ])
            ->headerActions([
                ExportAction::make()->exporter(JobExporter::class),
            ])
            ->bulkActions([
                ExportBulkAction::make()->exporter(JobExporter::class),
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ApplicationRelationManager::class,
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
