<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Http\Requests\UpdateJobRequest;
use App\Models\Application;
use App\Models\Employer;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class JobController extends Controller
{

    public function home()
    {
        $jobs = Job::with(['tags', 'employer'])
            ->where('urgent_hiring', 0)
            ->latest()
            ->take(5) // top 5 employers
            ->get();
        // ->paginate(10);

        $urgent_hiring_jobs = Job::with(['tags', 'employer'])
            ->where('urgent_hiring', 1)
            ->latest()
            ->get();

        // get employers with total jobs posted
        $employers = Employer::withCount('jobs')
            ->orderByDesc('jobs_count')
            ->take(5) // top 5 employers
            ->get();

        return view('home', [
            'jobs' => $jobs,
            'urgent_hiring_jobs' => $urgent_hiring_jobs,
            'tags' => Tag::all(),
            'employers' => $employers
        ]);
    }

    public function index()
    {
        $jobs = Job::with(['tags', 'employer'])->latest()->paginate(15);

        return view('jobs.index', [
            'jobs' => $jobs,
            'tags' => Tag::all()
        ]);
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title'    => ['required'],
            'salary'   => ['required'],
            'location' => ['required'],
            'employment_type' => ['required', Rule::in(['Part Time', 'Full Time'])],
            'urgent_hiring' => ['required', Rule::in(['0', '1'])]
        ]);

        // $attributes['urgent_hiring'] = $request->has('urgent_hiring'); //checkbox

        Auth::user()->employer->jobs()->create($attributes);

        // $job = Auth::user()->employer->jobs()->create(Arr::except($attributes, 'tags'));

        // if ($attributes['tags'] ?? false) {
        //     foreach (explode(',', $attributes['tags']) as $tag) {
        //         $job->tag($tag);
        //     }
        // }

        session()->flash('message', 'New job has been posted!');
        session()->flash('status', 'Success');
        return redirect('/');
    }

    public function show(Job $job)
    {

        $hasApplied = Application::where('user_id', auth()->id())
            ->where('job_id', $job->id)
            ->exists();

        return view('jobs.show', compact('job', 'hasApplied'));
    }
}
