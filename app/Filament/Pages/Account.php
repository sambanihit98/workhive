<?php

namespace App\Filament\Pages;

use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Pages\Page;

use Filament\Infolists\Components\ActionEntry;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;

class Account extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static string $view = 'filament.pages.account';

    protected static ?int $navigationSort = 6;
    protected static ?string $navigationGroup = 'Account & Settings';
    protected static ?string $navigationLabel = 'My Account';

    public ?array $user;

    public function mount(): void
    {
        $this->user = auth()->guard('admin')->user()->toArray(); // get logged in user data
    }

    public function infolist(): Infolist
    {
        return Infolist::make()
            ->state($this->user)
            ->schema([

                Section::make('Account Information')->schema([
                    TextEntry::make('name')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">Full Name: </span>' . e($state)
                        ),
                    TextEntry::make('email')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">Email: </span>' . e($state)
                        ),

                    TextEntry::make('created_at')
                        ->label('')
                        ->html()
                        ->formatStateUsing(
                            fn($state) =>
                            '<span class="font-bold">Joined: </span>' . Carbon::parse($state)->format('M. d, Y | h:i A')
                        ),
                ])->collapsible(),

            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('edit')
                ->label('Edit')
                ->form($this->getEditAccountFormSchema())
                ->modalWidth('md')
                ->fillForm(fn() => [  // This is used to pre-populate the form fields when the modal opens.
                    'name' => $this->user['name'],
                    'email' => $this->user['email'],
                ])
                ->action(function (array $data) {
                    $user = auth()->guard('admin')->user();
                    $user->update($data);

                    $this->user = $user->fresh()->toArray();

                    Notification::make()
                        ->title('Account updated!')
                        ->success()
                        ->send();
                }),

            Action::make('change-password')
                ->label('Change Password')
                ->form($this->getChangePasswordFormSchema())
                ->action(function (array $data) {

                    $user = auth()->guard('admin')->user();
                    auth()->guard('admin')->user()->update([
                        'password' => bcrypt($data['password']),
                    ]);

                    // Re-login and regenerate session
                    // auth()->guard('admin')->login($user);

                    Notification::make()
                        ->title('Password updated!')
                        ->success()
                        ->send();
                })
                ->modalWidth('md'),
        ];
    }

    protected function getEditAccountFormSchema(): array
    {
        return [
            TextInput::make('name')
                // ->default(auth()->guard('admin')->user()->name)
                ->required(),
            TextInput::make('email')
                // ->default(auth()->guard('admin')->user()->email)
                ->required()
                ->email(),
        ];
    }

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
