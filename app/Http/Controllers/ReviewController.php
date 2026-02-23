<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $fa = app()->getLocale() === 'fa';
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'required|string|min:10|max:1000',
            'name'       => 'required|string|max:100',
        ], [
            'comment.min' => $fa ? 'نظر باید حداقل ۱۰ کاراکتر باشد' : 'Review must be at least 10 characters',
            'rating.min'  => $fa ? 'لطفاً امتیاز بدهید' : 'Please give a rating',
        ]);

        Review::create([
            'product_id' => $request->product_id,
            'user_id'    => Auth::id(),
            'name'       => $request->name,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
            'approved'   => false,
        ]);

        return back()->with('success', $fa
            ? '✅ نظر شما ثبت شد و پس از تأیید نمایش داده می‌شود'
            : '✅ Your review has been submitted and will appear after approval');
    }
}