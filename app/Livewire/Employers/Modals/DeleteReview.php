<?php

namespace App\Livewire\Employers\Modals;

use App\Models\Review;
use Livewire\Component;

class DeleteReview extends Component
{

    public $review_id;

    public function delete()
    {
        $review = Review::find($this->review_id);

        if ($review) {
            $review->delete();
        }

        $this->dispatch('close-delete-review-modal');
        $this->dispatch('reloadReviews');
        $this->dispatch('notify', message: 'Review has been deleted successfully.', status: 'Danger');
    }

    public function render()
    {
        return view('livewire.employers.modals.delete-review');
    }
}
