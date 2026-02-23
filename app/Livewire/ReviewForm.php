<?php

namespace App\Livewire;

use App\Models\Review;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ReviewForm extends Component
{
    public int $productId;
    public string $name = '';
    public int $rating = 0;
    public string $comment = '';
    public bool $submitted = false;
    public string $message = '';

    public function mount(int $productId): void
    {
        $this->productId = $productId;
        if (Auth::check()) {
            $this->name = Auth::user()->name;
        }
    }

    protected function rules(): array
    {
        return [
            'name'    => 'required|string|max:100',
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ];
    }

    protected function messages(): array
    {
        $fa = app()->getLocale() === 'fa';
        return [
            'name.required'    => $fa ? 'نام الزامی است' : 'Name is required',
            'rating.required'  => $fa ? 'امتیاز الزامی است' : 'Rating is required',
            'rating.min'       => $fa ? 'لطفاً امتیاز بدهید' : 'Please select a rating',
            'comment.required' => $fa ? 'نظر الزامی است' : 'Review is required',
            'comment.min'      => $fa ? 'نظر باید حداقل ۱۰ کاراکتر باشد' : 'Review must be at least 10 characters',
        ];
    }

    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }

    public function submit(): void
    {
        $this->validate();

        Review::create([
            'product_id' => $this->productId,
            'user_id'    => Auth::id(),
            'name'       => $this->name,
            'rating'     => $this->rating,
            'comment'    => $this->comment,
            'approved'   => false,
        ]);

        $this->submitted = true;
        $this->message = app()->getLocale() === 'fa'
            ? '✅ نظر شما با موفقیت ثبت شد و پس از تأیید نمایش داده می‌شود.'
            : '✅ Your review has been submitted and will be visible after approval.';

        $this->reset(['rating', 'comment']);
    }

    public function render()
    {
        return view('livewire.review-form');
    }
}