<?php

namespace App\Livewire;

use App\Models\Review;
use Livewire\Component;
use Livewire\WithPagination;

class AdminReviews extends Component
{
    use WithPagination;

    public string $filter = 'pending';

    public function approve(int $id): void
    {
        Review::findOrFail($id)->update(['approved' => true]);
    }

    public function reject(int $id): void
    {
        Review::findOrFail($id)->delete();
    }

    public function render()
    {
        $reviews = Review::with(['product', 'user'])
            ->when($this->filter === 'pending', fn($q) => $q->where('approved', false))
            ->when($this->filter === 'approved', fn($q) => $q->where('approved', true))
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('livewire.admin-reviews', compact('reviews'))
            ->layout('layouts.admin');
    }
}
