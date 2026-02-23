<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class AdminStockAlert extends Component
{
    public int $threshold = 5;

    public function render()
    {
        $lowStockProducts = Product::where('stock', '<=', $this->threshold)
            ->where('active', true)
            ->orderBy('stock')
            ->get();

        return view('livewire.admin-stock-alert', compact('lowStockProducts'));
    }
}