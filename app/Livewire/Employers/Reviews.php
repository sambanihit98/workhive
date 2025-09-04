<?php

namespace App\Livewire\Employers;

use App\Models\Employer;
use Livewire\Component;
use Livewire\WithPagination;

class Reviews extends Component
{
    use WithPagination; //required if you use $resetPage
    protected $listeners = ['reloadReviews']; //simplier way

    public Employer $employer;

    public function mount(Employer $employer)
    {
        $this->employer = $employer;
    }

    public function reloadReviews()
    {
        $this->resetPage(); //requires WithPagination to work
    }

    public function render()
    {
        $paginatedReviews = $this->employer
            ->reviews()
            ->with('user')
            ->latest()
            ->paginate(20);

        // Overall stats (all reviews)
        $allReviews = $this->employer->reviews(); // full query
        $overallRating = $allReviews->avg('rating'); // average of all reviews
        $totalReviews = $allReviews->count(); // total number of reviews

        return view('livewire.employers.reviews', [
            'reviews' => $paginatedReviews,
            'overallRating' => $overallRating,
            'totalReviews' => $totalReviews,
        ]);
    }
}
