<?php

namespace App\Livewire\Employers;

use App\Models\Employer;
use Livewire\Component;
use Livewire\WithPagination;

class Search extends Component
{

    use WithPagination;

    public $q = '';

    public function mount()
    {
        $this->q = request('q', ''); // grab ?q=... from URL
    }

    public function render()
    {
        $employers = Employer::query()
            ->when(
                $this->q,
                fn($query) =>
                $query->where('name', 'LIKE', "%{$this->q}%")
            )
            ->paginate(10);

        return view('livewire.employers.search', [
            'employers' => $employers,
        ]);
    }
}
