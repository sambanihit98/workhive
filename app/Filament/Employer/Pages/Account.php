<?php

namespace App\Filament\Employer\Pages;

use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\Tabs\Tab;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\HtmlString;

class Account extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static string $view = 'filament.employer.pages.account';

    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'Account & Settings';
    protected static ?string $navigationLabel = 'My Account';

    public ?array $user;

    public function mount(): void
    {
        $this->user = auth()->guard('employer')->user()->toArray();
    }

    //--------------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------------
    public function infolist(): Infolist
    {
        return Infolist::make()
            ->state($this->user)
            ->schema([
                ComponentsSection::make('Account Information')->schema([

                    ImageEntry::make('logo')
                        ->label(''),

                    TextEntry::make('name')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">Name: </span>' . e($state)
                        ),
                    TextEntry::make('industry')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">Industry: </span>' . e($state)
                        ),
                    TextEntry::make('type')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">Type: </span>' . e($state)
                        ),
                    TextEntry::make('number_of_employees')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">Number of Employees: </span>' . e($state)
                        ),

                    TextEntry::make('created_at')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">Joined: </span>' . Carbon::parse($state)->format('M. d, Y | h:i A')
                        ),
                ])->collapsible(),

                ComponentsSection::make('About')->schema([
                    TextEntry::make('description')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) => ($state)
                        ),
                ])->collapsible(),

                ComponentsSection::make('Contact Details')->schema([
                    TextEntry::make('email')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">Email: </span>' . e($state)
                        ),
                    TextEntry::make('phonenumber')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">Phone Number: </span>' . e($state)
                        ),
                    TextEntry::make('website')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">Website: </span>' . e($state)
                        ),
                ])->collapsible(),

            ]);
    }

    //--------------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------------
    protected function getHeaderActions(): array
    {
        return [
            Action::make('edit')
                ->label('Edit Info')
                ->form($this->getEditFormSchema())
                ->fillForm(fn() => [
                    'name' => $this->user['name'],
                    'industry' => $this->user['industry'],
                    'type' => $this->user['type'],
                    'number_of_employees' => $this->user['number_of_employees'],
                    'description' => $this->user['description'],
                    'website' => $this->user['website'],
                    'email' => $this->user['email'],
                    'phonenumber' => $this->user['phonenumber'],

                ])
                ->action(function (array $data) {
                    $user = auth()->guard('employer')->user();
                    $user->update($data);

                    $this->user = $user->fresh()->toArray();

                    Notification::make()
                        ->title('Account updated!')
                        ->success()
                        ->send();
                }),

            Action::make('update-logo')
                ->label('Update Logo')
                ->form($this->getUpdateLogoFormSchema())
                ->action(function (array $data) {
                    $user = auth()->guard('employer')->user();

                    // Save the uploaded logo path into the DB
                    $user->update([
                        'logo' => $data['logo'] ?? $user->logo,
                    ]);

                    // Refresh your $this->user state
                    $this->user = $user->fresh()->toArray();

                    Notification::make()
                        ->title('Logo updated!')
                        ->success()
                        ->send();
                })
                ->modalWidth('md'),


            Action::make('change-password')
                ->label('Change Password')
                ->form($this->getChangePasswordFormSchema())
                ->action(function (array $data) {

                    $user = auth()->guard('employer')->user();
                    auth()->guard('employer')->user()->update([
                        'password' => bcrypt($data['password']),
                    ]);

                    // Re-login and regenerate session
                    // auth()->guard('employer')->login($user);

                    Notification::make()
                        ->title('Password updated!')
                        ->success()
                        ->send();
                })
                ->modalWidth('md'),
        ];
    }

    //--------------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------------
    protected function getEditFormSchema(): array
    {
        return [

            Group::make()->schema([
                Section::make('Account Information')->schema([

                    TextInput::make('name')
                        ->required(),

                    Grid::make(3)->schema([
                        TextInput::make('industry')
                            ->required(),
                        Select::make('type')
                            ->options([
                                'Private' => 'Private',
                                'Public' => 'Public',
                            ])
                            ->required(),
                        TextInput::make('number_of_employees')
                            ->numeric()
                            ->required(),
                    ]),

                ]),

                Section::make('About')->schema([
                    RichEditor::make('description')
                        ->required(),
                ]),

                Section::make('Contact Details')->schema([
                    TextInput::make('website'),

                    Grid::make(2)->schema([
                        TextInput::make('email')
                            ->email()
                            ->required(),
                        TextInput::make('phonenumber')
                            ->label('Phone Number')
                            ->required(),
                    ]),
                ]),
            ]),
        ];
    }

    //--------------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------------
    protected function getUpdateLogoFormSchema(): array
    {
        return [

            FileUpload::make('logo')
                ->label('Upload Employer Logo')
                ->image() // restricts to images
                ->disk('public')
                ->directory('logos') // stores in storage/app/public/logos
                ->visibility('public') // makes it publicly accessible
                ->required(false)
                ->maxSize(2048), // 2MB limit
        ];
    }

    //--------------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------------
    protected function getChangePasswordFormSchema(): array
    {
        return [
            TextInput::make('password')
                ->label('New Password')
                ->password()
                ->required()
                ->minLength(8),

            TextInput::make('password_confirmation')
                ->label('Confirm Password')
                ->password()
                ->required()
                // ->rule('confirmed'),
                ->same('password'),
        ];
    }
}
