<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class ProductFilter extends Component
{
    use WithPagination;

    public string $search = '';
    public string $selectedCategory = '';
    public string $selectedBrand = '';
    public string $sortBy = 'newest';
    public int $minPrice = 0;
    public int $maxPrice = 0;
    public bool $onSaleOnly = false;
    public bool $inStockOnly = false;

    protected $queryString = [
        'search'           => ['except' => ''],
        'selectedCategory' => ['except' => '', 'as' => 'category'],
        'selectedBrand'    => ['except' => '', 'as' => 'brand'],
        'sortBy'           => ['except' => 'newest', 'as' => 'sort'],
        'minPrice'         => ['except' => 0],
        'maxPrice'         => ['except' => 0],
    ];

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingSelectedCategory(): void { $this->resetPage(); }
    public function updatingSelectedBrand(): void { $this->resetPage(); }
    public function updatingSortBy(): void { $this->resetPage(); }

    public function clearFilters(): void
    {
        $this->reset(['search', 'selectedCategory', 'selectedBrand', 'sortBy', 'minPrice', 'maxPrice', 'onSaleOnly', 'inStockOnly']);
        $this->sortBy = 'newest';
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::where('active', true)->with(['category']);

        if ($this->search) {
            $s = $this->search;
            $query->where(function ($q) use ($s) {
                $q->where('name_fa', 'like', "%$s%")
                    ->orWhere('name_en', 'like', "%$s%")
                    ->orWhere('brand', 'like', "%$s%");
            });
        }

        if ($this->selectedCategory) {
            $cat = Category::where('slug', $this->selectedCategory)->first();
            if ($cat) $query->where('category_id', $cat->id);
        }

        if ($this->selectedBrand) {
            $query->where('brand', $this->selectedBrand);
        }

        if ($this->minPrice > 0) {
            $query->where('price', '>=', $this->minPrice);
        }
        if ($this->maxPrice > 0) {
            $query->where('price', '<=', $this->maxPrice);
        }

        if ($this->onSaleOnly) {
            $query->whereNotNull('sale_price');
        }

        if ($this->inStockOnly) {
            $query->where('stock', '>', 0);
        }

        switch ($this->sortBy) {
            case 'price_asc':  $query->orderByRaw('COALESCE(sale_price, price) ASC'); break;
            case 'price_desc': $query->orderByRaw('COALESCE(sale_price, price) DESC'); break;
            case 'popular':    $query->orderBy('views', 'desc'); break;
            default:           $query->orderBy('created_at', 'desc'); break;
        }

        $products  = $query->paginate(12);
        $categories = Category::where('active', true)->orderBy('sort_order')->get();
        $brands     = Product::where('active', true)->whereNotNull('brand')->distinct()->pluck('brand');
        $paymentEnabled  = \App\Models\Setting::get('payment_enabled', '1');
        $whatsappNumber  = \App\Models\Setting::get('whatsapp_number', '989123456789');

        return view('livewire.product-filter', compact('products', 'categories', 'brands', 'paymentEnabled', 'whatsappNumber'));
    }
}