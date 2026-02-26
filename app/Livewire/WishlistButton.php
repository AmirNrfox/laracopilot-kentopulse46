<?php

namespace App\Livewire;

use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WishlistButton extends Component
{
    public int $productId;
    public bool $inWishlist = false;

    public function mount(int $productId): void
    {
        $this->productId = $productId;
        $this->checkWishlist();
    }

    private function checkWishlist(): void
    {
        if (Auth::check()) {
            $this->inWishlist = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $this->productId)
                ->exists();
        } else {
            $this->inWishlist = Wishlist::where('session_id', session()->getId())
                ->where('product_id', $this->productId)
                ->exists();
        }
    }

    public function toggle(): void
    {
        if (Auth::check()) {
            $existing = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $this->productId)
                ->first();
            if ($existing) {
                $existing->delete();
                $this->inWishlist = false;
            } else {
                Wishlist::create(['user_id' => Auth::id(), 'product_id' => $this->productId]);
                $this->inWishlist = true;
            }
        } else {
            $sessionId = session()->getId();
            $existing = Wishlist::where('session_id', $sessionId)
                ->where('product_id', $this->productId)
                ->first();
            if ($existing) {
                $existing->delete();
                $this->inWishlist = false;
            } else {
                Wishlist::create(['session_id' => $sessionId, 'product_id' => $this->productId]);
                $this->inWishlist = true;
            }
        }
    }

    public function render()
    {
        return view('livewire.wishlist-button');
    }
}
