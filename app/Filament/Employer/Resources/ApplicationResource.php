<?php

namespace App\Filament\Employer\Resources;

use App\Filament\Employer\Resources\ApplicationResource\Pages;
use App\Filament\Employer\Resources\ApplicationResource\RelationManagers;
use App\Filament\Employer\Resources\JobResource\RelationManagers\ApplicationsRelationManager;
use App\Models\Application;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?int $navigationSort = 2;

    public static function getEloquentQuery(): Builder
    {
        // Use Filament's auth so it respects the panel's guard (e.g., 'employer')
        $employer = Filament::auth()->user();

        // If no authenticated employer (e.g., during CLI), fall back to default
        if (!$employer) {
            return parent::getEloquentQuery()->latest();
        }

        // Show only applications for jobs owned by this employer
        return parent::getEloquentQuery()
            ->whereHas('job', fn(Builder $q) => $q->where('employer_id', $employer->id))
            ->latest();
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ComponentsSection::make('Application Information')->schema([
                    TextEntry::make('created_at')
                        ->label('') // Hide default label
                        ->html() // Enable custom HTML output
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold mb-1">Date Applied: </span>' . Carbon::parse($state)->format('M. d, Y | h:i A')
                        ),

                    TextEntry::make('status')
                        ->label('') // Hide the default label
                        ->html()    // Allow custom HTML rendering
                        ->formatStateUsing(
                            fn(string $state) =>
                            '<span class="font-bold">Status: </span>' . e($state)
                        ),

                    TextEntry::make('resume')
                        ->label('') // Optional: hides the default label
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            $state
                                ? '<span class="font-bold">Resume: </span><a href="' . asset('storage/' . ltrim($state, '/')) . '" target="_blank" class="text-primary underline ">View Resume (PDF)</a>'
                                : '<span class="text-gray-500 italic">No resume uploaded.</span>'
                        ),

                    TextEntry::make('cover_letter')
                        ->label('') // Hide default label
                        ->html()
                        ->columnSpanFull()
                        ->formatStateUsing(
                            fn($state) =>
                            '<div class="font-bold mb-1">Cover Letter:</div>' . $state
                        ),

                ])->collapsible(),

                ComponentsSection::make("Applicant's Personal Information")->schema([
                    TextEntry::make('user.full_name')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">Full Name: </span>' . e($state)
                        ),

                    TextEntry::make('user.birthdate')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">Birthdate: </span>' . Carbon::parse($state)->format('M. d, Y')
                        ),

                    TextEntry::make('user.email')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">Email: </span>' . e($state)
                        ),

                    TextEntry::make('user.phone_number')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">Phone Number: </span>' . e($state)
                        ),
                ])->collapsible()->collapsed(),

                ComponentsSection::make("Applicant's Address")->schema([
                    TextEntry::make('user.user_address.street')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">Street: </span>' . e($state)
                        ),
                    TextEntry::make('user.user_address.barangay')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">Barangay: </span>' . e($state)
                        ),
                    TextEntry::make('user.user_address.city')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">City: </span>' . e($state)
                        ),
                    TextEntry::make('user.user_address.province')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">Province: </span>' . e($state)
                        ),
                    TextEntry::make('user.user_address.zip_code')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">Zip Code: </span>' . e($state)
                        ),
                ])->collapsible()->collapsed(),

                ComponentsSection::make('Job Information')->schema([
                    TextEntry::make('job.title')
                        ->columnSpanFull()
                        ->label('')
                        ->html()
                        ->formatStateUsing(fn($state) => '<span class="font-bold mb-1">Title: </span>' . e($state) . ''),

                    TextEntry::make('job.salary')
                        ->label('')
                        ->html()
                        ->formatStateUsing(fn($state) => '<span class="font-bold mb-1">Salary: </span>' . e($state) . ''),

                    TextEntry::make('job.location')
                        ->label('')
                        ->html()
                        ->formatStateUsing(fn($state) => '<span class="font-bold mb-1">Location: </span>' . e($state) . ''),

                    TextEntry::make('job.employment_type')
                        ->label('')
                        ->html()
                        ->formatStateUsing(fn($state) => '<span class="font-bold mb-1">Employment Type: </span>' . e($state) . ''),

                    TextEntry::make('job.urgent_hiring')
                        ->label('') // hide default label
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold mb-1">Urgent Hiring: </span>' . ($state ? 'Yes' : 'No')
                        ),

                    TextEntry::make('job.description')
                        ->label('') // Hide default label
                        ->html()
                        ->columnSpanFull()
                        ->formatStateUsing(
                            fn($state) =>
                            '<div class="font-bold mb-1">Description:</div>' . $state
                        ),

                    TextEntry::make('job.tags')
                        ->label('') // Hide default label
                        ->html()
                        ->formatStateUsing(function ($state, $record) {
                            $tags = $record->job?->tags;

                            if ($tags && $tags->isNotEmpty()) {
                                return '<span class="font-bold mb-1">Tags: </span>' . e($tags->pluck('name')->join(', '));
                            }

                            return '<span class="text-gray-500 italic">No tags assigned.</span>';
                        })
                        ->columnSpanFull(),


                ])->collapsible()->collapsed()

            ]);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            //----------------------------------------------------------------------------------------------------------
            //----------------------------------------------------------------------------------------------------------
            Section::make('Application Information')
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

            //----------------------------------------------------------------------------------------------------------
            //----------------------------------------------------------------------------------------------------------
            Section::make("Applicant's Personal Information")
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

            //----------------------------------------------------------------------------------------------------------
            //----------------------------------------------------------------------------------------------------------
            Section::make("Applicant's Address")
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
                ])->disabled()->columns(1)->collapsible()->collapsed(),

            //----------------------------------------------------------------------------------------------------------
            //----------------------------------------------------------------------------------------------------------
            Section::make('Job Information')->schema([
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
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.full_name')
                    ->formatStateUsing(function ($state, $record) {
                        $first = $record->user?->first_name;
                        $middle = $record->user?->middle_name;
                        $last = $record->user?->last_name;
                        return trim("{$first} {$middle} {$last}");
                    })
                    ->label('Full Name')
                    ->searchable(
                        query: function (Builder $query, string $search): Builder {
                            return $query->whereHas('user', function ($query) use ($search) {
                                $query->where('first_name', 'like', "%{$search}%")
                                    ->orWhere('middle_name', 'like', "%{$search}%")
                                    ->orWhere('last_name', 'like', "%{$search}%");
                            });
                        }
                    )
                    ->toggleable(),

                // TextColumn::make('user.first_name')->label('First Name')->toggleable()->searchable(),
                // TextColumn::make('user.middle_name')->label('Middle Name')->toggleable()->searchable(),
                // TextColumn::make('user.last_name')->label('Last Name')->toggleable()->searchable(),
                TextColumn::make('job.title')->label('Job Title')->searchable()->toggleable(),
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
                TextColumn::make('created_at')->label('Date Applied')->date('M. d, Y | h:i A')->toggleable(),
            ])

            ->searchPlaceholder('Search name or job title')

            ->filters([
                // Filter::make('Hired Applicants')->query(
                //     function ($query) {
                //         return $query->where('status', 'Hired');
                //     }
                // ),

                SelectFilter::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'Reviewed' => 'Reviewed',
                        'Hired' => 'Hired',
                        'Rejected' => 'Rejected',
                        'Withdrawn' => 'Withdrawn',
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make()->color('info'),
                Tables\Actions\ViewAction::make()->color('success'),

                Action::make('view_resume')
                    ->label('View Resume')
                    ->icon('heroicon-o-document-text')
                    ->url(fn($record) => asset('storage/' . $record->resume))
                    ->openUrlInNewTab()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListApplications::route('/'),
            'create' => Pages\CreateApplication::route('/create'),
            'edit' => Pages\EditApplication::route('/{record}/edit'),
            'view' => Pages\ViewApplication::route('/{record}'),
        ];
    }
}
