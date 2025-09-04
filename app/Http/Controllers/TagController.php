<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{

    public function __invoke(Tag $tag)
    {

        $jobs = $tag->jobs()->with(['tags', 'employer'])->paginate(5);

        //job for this tag
        return view('results', ['jobs' => $jobs]);
    }
}
