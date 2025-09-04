<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Job $job)
    {

        // Check if user already applied to this job
        $hasApplied = Application::where('user_id', auth()->user()->id)
            ->where('job_id', $job->id)
            ->exists();

        if ($hasApplied) {
            return redirect()
                ->route('jobs.show', $job->id);
        }

        return view('application.create', compact('job'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Job $job)
    {

        $user = auth()->user()->id;
        $job = $job->id;

        $validated = $request->validate([
            'resume' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:2048',],
            'cover_letter' => ['nullable', 'string', 'max:300'], // optional text
        ]);

        //store the file under storage/app/public/resume
        $path = $request->file('resume')->store('resume', 'public');

        Application::create([
            'job_id'     => $job,
            'user_id'    => $user,
            'status'     => 'Pending',
            'cover_letter'  => $validated['cover_letter'] ?? null,
            'resume' => $path,
        ]);

        session()->flash('message', 'Applied job successfully!');
        session()->flash('status', 'Success');
        return redirect('/jobs/' . $job);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
