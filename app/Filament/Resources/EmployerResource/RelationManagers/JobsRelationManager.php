<?php

namespace App\Filament\Resources\EmployerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JobsRelationManager extends RelationManager
{
    protected static string $relationship = 'jobs';

    //------------------------------------------------------
    //------------------------------------------------------
    //IMPORTANT
    public function getTableQuery(): Builder
    {
        return $this->getRelationship() //Eloquent relationship "jobs"
            ->getQuery() //underlying query builder for the Job model // where employer = employer
            ->with('tags')
            ->latest();
    }
    //------------------------------------------------------
    //------------------------------------------------------


    public function form(Form $form): Form
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
                ])->collapsible(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
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
