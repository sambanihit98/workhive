<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisteredEmployerController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SessionUserController;
use App\Http\Controllers\TagController;
use App\Livewire\Companies;
use App\Livewire\Companies\Index as CompaniesIndex;
use App\Livewire\EmployerLogin;
use App\Livewire\EmployerRegister;
use App\Livewire\Employers\Auth\Login;
use App\Livewire\Employers\Auth\Register;
use App\Livewire\Employers\Index as EmployersIndex;
use App\Livewire\Employers\Jobs;
use App\Livewire\Employers\Reviews;
use App\Livewire\Employers\Search;
use App\Livewire\Employers\Show;
use App\Livewire\Home;
use App\Livewire\Jobs\Apply;
use App\Livewire\Jobs\Index as JobsIndex;
use App\Livewire\Jobs\Search as JobsSearch;
use App\Livewire\Jobs\Show as JobsShow;
use App\Livewire\Salaries\Index as SalariesIndex;
use App\Livewire\TermsAndConditions;
use App\Livewire\User\Account\Index;
use App\Livewire\User\Applications\Index as ApplicationsIndex;
use App\Livewire\User\Auth\Login as AuthLogin;
use App\Livewire\User\Auth\Register as AuthRegister;
use Filament\Actions\Exports\Http\Controllers\DownloadExport;
use Illuminate\Support\Facades\Route;

//------------------------------------
// important!
// for multiple panels exporting data
Route::get('/filament/exports/{export}/download', DownloadExport::class)
    ->name('filament.exports.download')
    ->middleware(['web', 'auth.multi']);

//------------------------------------
//Homepage // Livewire
Route::get('/', Home::class);

//------------------------------------
//LOGIN AREA for USER //Livewire
Route::get('/login', AuthLogin::class)->middleware('guest')->name('login');

//------------------------------------
// SIGN-UP AREA for USER //Livewire
Route::get('/register', AuthRegister::class)->middleware('guest');

//------------------------------------
//USER // Livewire 
Route::get('/user/account', Index::class)->name('user.account')->middleware('auth');

//------------------------------------
//USER'S APPLICATIONS // Livewire 
Route::get('/applications', ApplicationsIndex::class)->middleware('auth');

//------------------------------------
//EMPLOYERS // Livewire

Route::get('/employer/login', Login::class)->name('filament.employer.auth.login');
Route::get('/employer/register', Register::class);
Route::get('/employers', EmployersIndex::class);
Route::get('/employers/{employer}', Show::class);
Route::get('/employers/jobs/{employer}', Jobs::class);
Route::get('/employers/reviews/{employer}', Reviews::class);

Route::get('/search/employers', Search::class)->name('employers.search');

//------------------------------------
//JOBS // Livewire
Route::get('/jobs', JobsIndex::class);
Route::get('/jobs/{job}', JobsShow::class)->name('jobs.show');;
Route::get('/jobs/{job}/apply', Apply::class)->middleware('auth');

Route::get('/search/jobs', JobsSearch::class);

//------------------------------------
//SALARIES // Livewire

Route::get('/salaries', SalariesIndex::class);

//------------------------------------
//TERMS & CONDITIONS // Livewire
Route::get('/terms-and-conditions', TermsAndConditions::class);

//------------------------------------
//------------------------------------
//NOT LIVEWIRE
//LOGOUT AREA 
Route::delete('/logout', [SessionController::class, 'destroy'])->middleware('auth');

Route::get('/tags/{tag:name}', TagController::class); //if no :name, it will find "id" by default
//------------------------------------
//------------------------------------