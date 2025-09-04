<?php

namespace App\Filament\Resources\TagResource\RelationManagers;

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

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->description('These jobs are tagged with "' . $this->getOwnerRecord()->name . '"')
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
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
