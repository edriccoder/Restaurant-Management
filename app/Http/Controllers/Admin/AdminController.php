<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Food\Food;
use App\Models\Admin\Admin;
use App\Models\Food\Booking;
use App\Models\Food\checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File; 

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
            'password' => 'required|string|min:6',
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.unique' => 'Email is already taken',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters',
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

    public function allOrders(){
        $orders = checkout::select()->orderBy('id', 'desc')->get();

        return view('admin.allorders', compact('orders'));
    }

    public function editOrders($id){

        $order = checkout::find($id);
        return view('admin.editorders', compact('order'));

    }

    public function updateOrders(Request $request, $id){

        $order = checkout::find($id);
        $order->update(["status" => $request->status]);
        if ($order) {
            return redirect()->route('orders.all')->with(['success' => 'Order update successfully']);
        } else {
            return redirect()->route('orders.all')->with(['error' => 'Order update failed']);
        }

    }

    public function deleteOrders(Request $request, $id){

        $order = checkout::find($id);
        $order->delete();
        if ($order) {
            return redirect()->route('orders.all')->with(['success' => 'Order delete successfully']);
        } else {
            return redirect()->route('orders.all')->with(['error' => 'Order delete failed']);
        }

    }

    public function allBookings(){

        $bookings = Booking::select()->orderBy('id', 'desc')->get();

        return view('admin.allBookings', compact('bookings'));

    }

    public function editBookings($id){
        $booking = Booking::find($id);
        return view('admin.editbooking', compact('booking'));
    }

    public function updateBookings(Request $request, $id){
        $booking = Booking::find($id);
        $booking->update(["status" => $request->status]);
        if ($booking) {
            return redirect()->route('bookings.all')->with(['success' => 'Booking update successfully']);
        } else {
            return redirect()->route('bookings.all')->with(['error' => 'Booking update failed']);
        }

    }

    public function deleteBookings(Request $request, $id){

        $booking = Booking::find($id);
        $booking->delete();
        if ($booking) {
            return redirect()->route('bookings.all')->with(['success' => 'Booking delete successfully']);
        } else {
            return redirect()->route('bookings.all')->with(['error' => 'Booking delete failed']);
        }

    }

    public function allFoods(){
        $foods = Food::select()->orderBy('id', 'desc')->get();

        return view('admin.allfoods', compact('foods'));
    }

    public function createFoods(){

        return view('admin.createfood');

    }

    public function storeFoods(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category' => 'required|string',
        ], [
            'name.required' => 'Name is required',
            'price.required' => 'Price is required',
            'description.required' => 'Description is required',
            'image.required' => 'Image is required',
            'image.image' => 'The file must be an image.',
            'category.required' => 'Category is required',
        ]);
    
        // Handle Image Upload
        $destinationPath = 'assets/img/';
        $myimage = $request->image->getClientOriginalName();
        $request->image->move(public_path($destinationPath), $myimage);
    
        // Store Food Data
        $food = Food::create([
            "name" => $request->name,
            "price" => $request->price,
            "image" => $myimage,
            "description" => $request->description,
            "category" => $request->category,
        ]);
    
        if ($food) {
            return redirect()->route('foods.all')->with(['success' => 'Food added successfully']);
        } else {
            return redirect()->route('foods.all')->with(['error' => 'Food not added successfully']);
        }
    }

    public function deletefoods($id){

        $food = Food::find($id);
        

        if(File::exists(public_path('assets/img/' . $food->image))){
            File::delete(public_path('assets/img/' . $food->image));
        }else{
            //dd('File does not exists.');
        }

        $food->delete();
        
        if ($food) {
            return redirect()->route('foods.all')->with(['success' => 'Food delete successfully']);
        } else {
            return redirect()->route('foods.all')->with(['error' => 'Food delete failed']);
        }

    }
    

}
