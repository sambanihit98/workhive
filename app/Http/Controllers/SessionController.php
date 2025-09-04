<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{

    public function destroy()
    {
        Auth::logout();

        session()->flash('notify', [
            'message' => 'Logged out!',
            'status' => 'Warning',
        ]);

        return redirect('/');
    }
}
