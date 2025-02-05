<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food\Booking;
use App\Models\Food\checkout;
use App\Models\Food\Review;
use Auth;

class UsersController extends Controller
{
    public function getBookings() {
        $allBookings = Booking::where('user_id', Auth::user()->id)->get();
        return view('users.bookings', compact('allBookings'));
    }

    public function getOrders() {
        $allOrders = checkout::where('user_id', Auth::user()->id)->get();
        return view('users.orders', compact('allOrders'));
    }   

    public function viewReview() {
        return view('users.wirtereview');
    }

    public function submitReview(Request $request) {

        $request->validate([
            'name' => 'required|string|max:255',
            'review' => 'required',
        ], [
            'name.required' => 'Name is required',
            'review.required' => 'Review is required',
        ]);

        $submitReview = Review::create([
            'name' => $request->name,
            'review' => $request->review
        ]);

        if ($submitReview) {
            return redirect()->route('users.review.create')->with('success', 'Review submitted successfully');
        } else {
            return redirect()->route('users.review.create')->with('error', 'Review not submitted');
        }

    }
}
