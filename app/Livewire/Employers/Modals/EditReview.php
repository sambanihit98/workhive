<?php

namespace App\Livewire\Employers\Modals;

use App\Models\Review;
use Livewire\Component;

class EditReview extends Component
{

    public $review_id;
    public $user_id, $employer_id, $comment, $rating;

    public function mount($review_id)
    {

        $review = Review::findOrFail($review_id);

        $this->review_id   = $review_id;
        $this->user_id     = $review->user_id;
        $this->employer_id = $review->employer_id;
        $this->rating      = $review->rating;
        $this->comment     = $review->comment;
    }

    public function update()
    {
        $this->validate([
            'user_id' => '',
            'employer_id' => '',
            'comment' => 'nullable|string|max:1000',
            'rating' => 'nullable|integer|min:0|max:5',
        ]);

        //find the record then update it
        $review = Review::findOrFail($this->review_id);

        // Save the review
        $review->update([
            'user_id' => $this->user_id,
            'employer_id' => $this->employer_id,
            'comment' => $this->comment,
            'rating' => $this->rating,
        ]);

        $this->dispatch('close-edit-review-modal');
        $this->dispatch('reloadReviews');
        $this->dispatch('notify', message: 'Review has been updated successfully.', status: 'Info');
    }

    public function render()
    {
        return view('livewire.employers.modals.edit-review');
    }
}
