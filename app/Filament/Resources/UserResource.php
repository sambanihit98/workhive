<?php

namespace App\Filament\Resources;

use App\Filament\Exports\AdminExporter;
use App\Filament\Exports\UserExporter;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\RelationManagers\ApplicationRelationManager;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 2;

    //------------------------------------------------------
    //------------------------------------------------------
    //IMPORTANT
    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()->latest(); // same as ->orderBy('created_at', 'desc')
    // }

    public static function canCreate(): bool
    {
        return false;
    }
    //------------------------------------------------------
    //------------------------------------------------------

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ComponentsSection::make("Personal Information")->schema([
                    TextEntry::make('first_name')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">First Name: </span>' . e($state)
                        ),

                    TextEntry::make('middle_name')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">Middle Name: </span>' . e($state)
                        ),

                    TextEntry::make('last_name')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">Last Name: </span>' . e($state)
                        ),

                    TextEntry::make('birthdate')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">Birthdate: </span>' . Carbon::parse($state)->format('M. d, Y')
                        ),

                    TextEntry::make('email')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">Email: </span>' . e($state)
                        ),

                    TextEntry::make('phone_number')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">Phone Number: </span>' . e($state)
                        ),

                    TextEntry::make('created_at')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">Joined In: </span>' . Carbon::parse($state)->format('M. d, Y | h:i A')
                        ),

                    TextEntry::make('bio')
                        ->label('') // Hide default label
                        ->html()
                        ->columnSpanFull()
                        ->formatStateUsing(
                            fn($state) =>
                            '<div class="font-bold mb-1">Bio:</div>' . $state
                        ),

                ])->collapsible(),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Personal Information')->schema([
                    Grid::make(3)->schema([
                        TextInput::make('first_name')->required()->label('First Name'),
                        TextInput::make('middle_name')->required()->label('Middle Name'),
                        TextInput::make('last_name')->required()->label('Last Name'),

                        TextInput::make('birthdate')->required(),
                        TextInput::make('email')->required(),
                        TextInput::make('phone_number')->required()->label('Phone Number'),
                    ]),

                    Grid::make(1)->schema([
                        Textarea::make('bio')->required()->rows('8'),
                    ]),
                ])->collapsible(),

                Section::make('Address')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('street')
                            ->required()
                            ->afterStateHydrated(fn($component, $record) => $component->state($record?->user_address?->street)),
                        TextInput::make('barangay')
                            ->required()
                            ->afterStateHydrated(fn($component, $record) => $component->state($record?->user_address?->barangay)),
                    ]),

                    Grid::make(3)->schema([
                        TextInput::make('city')
                            ->required()
                            ->afterStateHydrated(fn($component, $record) => $component->state($record?->user_address?->city)),
                        TextInput::make('province')
                            ->required()
                            ->afterStateHydrated(fn($component, $record) => $component->state($record?->user_address?->province)),
                        TextInput::make('zip_code')
                            ->label('Zip Code')
                            ->required()
                            ->afterStateHydrated(fn($component, $record) => $component->state($record?->user_address?->zip_code)),
                    ]),

                ])->collapsible(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')->label('First Name')->sortable()->searchable()->toggleable(),
                TextColumn::make('middle_name')->label('Middle Name')->sortable()->searchable()->toggleable(),
                TextColumn::make('last_name')->label('Last Name')->sortable()->searchable()->toggleable(),
                TextColumn::make('email')->sortable()->searchable()->toggleable(),
                TextColumn::make('phone_number')->label('Phone Number')->sortable()->searchable()->toggleable(),
                TextColumn::make('created_at')->label('Joined')->date('M. d, Y | h:i A')->sortable()->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make()->color('success'),
            ])
            ->headerActions([
                ExportAction::make()->exporter(UserExporter::class),
            ])
            ->bulkActions([
                ExportBulkAction::make()->exporter(UserExporter::class),
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListUsers::route('/'),
            'view' => Pages\ViewUser::route('/{record}'),
            // 'create' => Pages\CreateUser::route('/create'),
            // 'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
