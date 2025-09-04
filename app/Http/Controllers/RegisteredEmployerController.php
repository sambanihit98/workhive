<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\EmployerAddress;
use App\Models\Job;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisteredEmployerController extends Controller
{

    use AuthorizesRequests;

    public function dashboard()
    {
        return view('auth-employer.dashboard');
    }

    //-----------------------------------------------------------------------------
    //-----------------------------------------------------------------------------
    //EMPLOYER'S ACCOUNT
    public function create()
    {
        return view('auth-employer.register');
    }

    //------------------------------//------------------------------
    public function store(Request $request, Employer $employer)
    {
        //this will validated all input at once
        $validated = $request->validate([
            'name' => ['required'],
            'industry' => ['required'],
            'email' => ['required', 'email', 'unique:employers,email'],
            'phonenumber' => ['required'],
            'description' => ['required'],
            'type' => ['required'],
            'number_of_employees' => ['required'],
            'password' => ['required', 'confirmed', Password::min(5)->letters()->numbers()],
            'street'   => ['required'],
            'barangay' => ['required'],
            'city'     => ['required'],
            'province' => ['required'],
            'zip_code' => ['required']
        ]);

        //it will then be extracted to store to each of their table
        $employerAttributes = array_merge($request->only([
            'name',
            'industry',
            'website',
            'email',
            'phonenumber',
            'description',
            'type',
            'number_of_employees',
            'website',
            'password',
        ]), ['logo' => 'storage/logos/default-company-logo.png']);
        $employerAddress = Arr::only($validated, [
            'street',
            'barangay',
            'city',
            'province',
            'zip_code',
        ]);

        $employer = Employer::create($employerAttributes);
        $employer->employer_address()->create($employerAddress);

        Auth::guard('employer')->login($employer);

        session()->flash('message', 'Logged in!');
        session()->flash('status', 'Success');
        return redirect('/dashboard');
    }

    //------------------------------//------------------------------
    public function index()
    {
        $employer = auth()->guard('employer')->user()->load('employer_address');
        return view('auth-employer.account.index', compact('employer'));
    }

    //------------------------------//------------------------------
    public function edit()
    {
        $employer = auth()->guard('employer')->user()->load('employer_address');
        return view('auth-employer.account.edit', compact('employer'));
    }

    //------------------------------//------------------------------
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'industry' => ['required'],
            'email' => ['required', 'email', Rule::unique('employers', 'email')->ignore(auth()->guard('employer')->id())],
            'phonenumber' => ['required'],
            'description' => ['required'],
            'type' => ['required'],
            'number_of_employees' => ['required'],
            'street'   => ['required'],
            'barangay' => ['required'],
            'city'     => ['required'],
            'province' => ['required'],
            'zip_code' => ['required']
        ]);

        //it will then be extracted to store to each of their table
        $employerAttributes = array_merge($request->only([
            'name',
            'industry',
            'website',
            'email',
            'phonenumber',
            'description',
            'type',
            'number_of_employees',
            'website'
        ]));
        $employerAddress = Arr::only($validated, [
            'street',
            'barangay',
            'city',
            'province',
            'zip_code',
        ]);

        auth()->guard('employer')->user()->update($employerAttributes);
        auth()->guard('employer')->user()->employer_address()->update($employerAddress);

        session()->flash('message', 'Account info updated successfully!');
        session()->flash('status', 'Info');
        return redirect('/employer/account');
    }

    //------------------------------//------------------------------
    public function edit_password()
    {
        return view('auth-employer.account.edit-password');
    }

    //------------------------------//------------------------------
    public function update_password(Request $request)
    {

        $employer = auth()->guard('employer')->user();

        //this will validated all input at once
        $validated = $request->validate([
            'password' => ['required', 'confirmed', Password::min(5)->letters()->numbers()],
        ]);
        $employer->update($validated);

        session()->flash('message', 'Updated password successfully!');
        session()->flash('status', 'Info');
        return redirect('/employer/account');
    }


    //-----------------------------------------------------------------------------
    //-----------------------------------------------------------------------------
    //JOB LISTING
    public function job_index()
    {
        $employer = auth('employer')->user();
        $jobs = $employer->jobs()->latest()->paginate(5);
        return view('auth-employer.jobs.index', compact('jobs'));
    }

    //------------------------------//------------------------------
    public function job_create()
    {
        return view('auth-employer.jobs.create');
    }

    //------------------------------//------------------------------
    public function job_show(Job $job)
    {

        //authorize() will look for the default guard(web) which is the default user instead of the employer
        //requires Gate::forUser to access the employer
        Gate::forUser(auth()->guard('employer')->user())->authorize('show', $job);

        return view('auth-employer.jobs.show', ['job' => $job]);
    }

    //------------------------------//------------------------------
    public function job_store(Request $request)
    {

        $validated = $request->validate([
            'title'    => ['required'],
            'salary'   => ['required'],
            'location' => ['required'],
            'employment_type' => ['required', Rule::in(['Part Time', 'Full Time'])],
            'urgent_hiring' => ['required', Rule::in(['0', '1'])],
            'description' => ['required'],
        ]);

        $employer = auth()->guard('employer')->user();
        $employer->jobs()->create($validated);

        session()->flash('message', 'New job has been posted!');
        session()->flash('status', 'Success');
        return redirect('/employer/jobs');
    }

    //------------------------------//------------------------------
    public function job_edit(Job $job)
    {
        Gate::forUser(auth()->guard('employer')->user())->authorize('edit', $job);
        return view('auth-employer.jobs.edit', ['job' => $job]);
    }

    //------------------------------//------------------------------
    public function job_update(Request $request, Job $job)
    {
        $validated = $request->validate([
            'title'    => ['required'],
            'salary'   => ['required'],
            'location' => ['required'],
            'employment_type' => ['required', Rule::in(['Part Time', 'Full Time'])],
            'urgent_hiring' => ['required', Rule::in(['0', '1'])],
            'description' => ['required'],
        ]);

        Gate::forUser(auth()->guard('employer')->user())->authorize('edit', $job);
        $job->update($validated);

        session()->flash('message', 'A job has been updated!');
        session()->flash('status', 'Info');
        return redirect('/employer/jobs');
    }

    //------------------------------//------------------------------
    public function job_destroy(Job $job)
    {
        $job->delete();

        session()->flash('message', 'A job has been deleted!');
        session()->flash('status', 'Danger');
        return redirect('/employer/jobs');
    }
    //-----------------------------------------------------------------------------
    //-----------------------------------------------------------------------------
}
