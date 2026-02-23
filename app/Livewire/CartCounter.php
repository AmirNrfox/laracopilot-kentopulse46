<?php

namespace App\Livewire;

use Livewire\Component;

class CartCounter extends Component
{
    public int $count = 0;

    public function mount(): void
    {
        $this->count = count(session('cart', []));
    }

    protected $listeners = ['cartUpdated' => 'updateCount'];

    public function updateCount(int $count): void
    {
        $this->count = $count;
    }

    public function render()
    {
        return view('livewire.cart-counter');
    }
}