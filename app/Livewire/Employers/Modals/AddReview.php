<?php

namespace App\Livewire\Employers\Modals;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddReview extends Component
{

    public $user_id;
    public $employer_id;
    public $comment = '';
    public $rating = 0;

    public function add()
    {
        $this->validate([
            'user_id' => '',
            'employer_id' => '',
            'comment' => 'nullable|string|max:1000',
            'rating' => 'nullable|integer|min:0|max:5',
        ]);

        // Save the review
        Review::create([
            'user_id' => $this->user_id,
            'employer_id' => $this->employer_id,
            'comment' => $this->comment,
            'rating' => $this->rating,
        ]);

        $this->dispatch('close-add-review-modal');
        $this->dispatch('reloadReviews');
        $this->dispatch('notify', message: 'Review has been added successfully.', status: 'Warning');
    }

    public function mount()
    {
        $this->user_id = auth()->guard('web')->user()->id;
    }

    public function render()
    {
        return view('livewire.employers.modals.add-review');
    }
}
