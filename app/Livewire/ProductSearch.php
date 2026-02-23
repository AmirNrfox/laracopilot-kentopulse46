<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductSearch extends Component
{
    public string $query = '';
    public array $results = [];
    public bool $showResults = false;

    public function updatedQuery(): void
    {
        if (strlen($this->query) < 2) {
            $this->results = [];
            $this->showResults = false;
            return;
        }

        $q = $this->query;
        $this->results = Product::where('active', true)
            ->where(function ($query) use ($q) {
                $query->where('name_fa', 'like', "%$q%")
                    ->orWhere('name_en', 'like', "%$q%")
                    ->orWhere('brand', 'like', "%$q%");
            })
            ->with('category')
            ->take(6)
            ->get()
            ->map(fn($p) => [
                'id'     => $p->id,
                'name'   => app()->getLocale() === 'fa' ? $p->name_fa : $p->name_en,
                'brand'  => $p->brand,
                'price'  => number_format($p->final_price),
                'image'  => $p->image_url,
                'slug'   => $p->slug,
            ])->toArray();

        $this->showResults = true;
    }

    public function closeResults(): void
    {
        $this->showResults = false;
    }

    public function render()
    {
        return view('livewire.product-search');
    }
}