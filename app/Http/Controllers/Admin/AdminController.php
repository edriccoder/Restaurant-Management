<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Food\Food;
use App\Models\Admin\Admin;
use App\Models\Food\Booking;
use App\Models\Food\checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function viewLogin() {
        return view('admin.login');
    }

    public function checkLogin(Request $request){


        $remember_me = $request->has('remember_me') ? true : false;

        if (auth()->guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {

            return redirect() -> route('admin.dashboard');
        }
        return redirect()->back()->with(['error' => 'error logging in']);

    }

    public function index() {

        //foodsc count
        $foodCount = Food::select()->count();
        $adminCount = Admin::select()->count();
        $bookingCount= Booking::select()->count();
        $orderCount = checkout::select()->count();

        return view('admin.index', compact('foodCount', 'adminCount','bookingCount','orderCount'));
    }

    public function allAdmins() {

        $admins = Admin::select()->orderBy('id', 'desc')->get();

        return view('admin.alladmins', compact('admins'));

    }

    public function createAdmins() {

        return view('admin.createadmin');

    }

    public function storeAdmins(Request $request) {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|password',
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',
        ]);

        $admin = Admin::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

        if ($admin) {
            return redirect()->route('admin.create')->with(['success' => 'Admin added successfully']);
        } else {
            return redirect()->route('admin.create')->with(['error' => 'Admin not added successfully']);
        }

    }
}
