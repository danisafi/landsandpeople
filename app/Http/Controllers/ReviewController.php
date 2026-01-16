<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;


class ReviewController extends Controller
{
    // Store review
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        Review::create($request->all());

        return redirect()->back()->with('success', 'Thank you for your review!');
    }
}
