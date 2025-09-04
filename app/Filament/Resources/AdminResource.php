<?php

namespace App\Filament\Resources;

use App\Filament\Exports\AdminExporter;
use App\Filament\Resources\AdminResource\Pages;
use App\Filament\Resources\AdminResource\RelationManagers;
use App\Models\Admin;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->columnSpanFull(),
                TextInput::make('email')->columnSpanFull(),
                TextInput::make('password')->password()->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->toggleable(),
                TextColumn::make('email')->toggleable(),
                TextColumn::make('created_at')->label('Joined')->date('M. d, Y | h:i A')->sortable()->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                ExportAction::make()->exporter(AdminExporter::class),
            ])
            ->bulkActions([
                ExportBulkAction::make()->exporter(AdminExporter::class),
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdmins::route('/'),
            // 'create' => Pages\CreateAdmin::route('/create'),
            // 'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}
