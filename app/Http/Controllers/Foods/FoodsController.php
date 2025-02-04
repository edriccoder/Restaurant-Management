<?php

namespace App\Http\Controllers\Foods;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food\Food;
use App\Models\Food\Cart;
use App\Models\Food\Booking;
use App\Models\Food\checkout;
use App\Models\Food\bookingTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FoodsController extends Controller
{
    public function foodDetails($id) {

        $foodItem = Food::find($id);

        //verifying if the food item exists

        $cartVerify = Cart::where('food_id', $id)
        ->where('user_id', Auth::user()->id)->count();

        return view('foods.food-details', compact('foodItem', 'cartVerify'));

    }

    public function cart(Request $request, $id)
    {
        $cartVerify = Cart::where('food_id', $id)
            ->where('user_id', Auth::user()->id)->count();

        if ($cartVerify > 0) {
            return redirect()->route('food.details', $id)->with(['error' => 'Item already in cart']);
        }

        $cart = Cart::create([
            "user_id" => $request->user_id,
            "food_id" => $request->food_id,
            "name" => $request->name,
            "image" => $request->image,
            "price" => $request->price,
        ]);

        if ($cart) {
            return redirect()->route('food.details', $id)->with(['success' => 'Item Added to cart successfully']);
        } else {
            return redirect()->route('food.details', $id)->with(['error' => 'Item not added to cart']);
        }
    }

    public function displayCartItems() {

        if (Auth::check()) {
            // display cart items
            $cartItems = Cart::where('user_id', Auth::user()->id)->get();
        
            // display price
            $price = Cart::where('user_id', Auth::user()->id)->sum('price');
        
            return view('foods.cart', compact('cartItems', 'price'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function deleteCartItems($id) {

        // display cart items
        $deleteItem = Cart::where('user_id', Auth::user()->id)
        ->where('food_id', $id);

        $deleteItem->delete();

        if($deleteItem) {
            return redirect()->route('food.display.cart')->with(['delete' => 'Item deleted from cart successfully']);
        } else {
            return redirect()->route('food.display.cart')->with(['error' => 'Item not deleted to cart']);
        }

    }

    public function prepareCheckout(Request $request) {


        $value = $request->price;
        Session::put('price', $value);

        $newPrice = Session::get('price');

        if($newPrice > 0) {
            return redirect()->route('foods.checkout', compact('newPrice'));

        }

    }

    public function checkout(){

            if(Session::get('price') == 0) {
                abort(403, 'Unauthorized action.');
            } else {
                return view('foods.checkout');
            }


    }

    public function storeCheckout(Request $request) {

        $checkout = checkout::create([
            "name" => $request->name,
            "email" => $request->email, 
            "town" => $request->town, 
            "country" => $request->country, 
            "zipcode" => $request->zipcode, 
            "phonenumber" => $request->phonenumber, 
            "address" => $request->address, 
            "user_id" => Auth::user()->id,
            "price" => $request->price, 
        ]);  

        if ($checkout) {
            if(Session::get('price') == 0) {
                abort(403, 'Unauthorized action.');
            } else {
                return redirect()->route('foods.pay');
            }
        }

    }

    public function payWithPaypal() {

            if(Session::get('price') == 0) {
                abort(403, 'Unauthorized action.');
            } else {
                return view('foods.pay');
            }

    }

    public function success() {

        $deleteItem = Cart::where('user_id', Auth::user()->id);

        $deleteItem->delete();

        if(Session::get('price') == 0) {
            abort(403, 'Unauthorized action.');
        } else {
            Session::forget('price');
            return view('foods.success')->with(['success' => 'Your payment was successful']);
        }

    }

    public function bookingTables(Request $request) {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'date' => 'required|date',
            'num_people' => 'required',
            'spe_request' => 'required',
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'date.required' => 'Date is required',
            'num_people.required' => 'Number of people is required',
            'spe_request.required' => 'Special request is required',
        ]);

        $currentDate = date('m/d/Y H:i:s');

        if ($request->date == $currentDate || $request->date < $currentDate) {
            return redirect()->route('home')->with(['error' => 'Booking date must be greater than current date']);
        } else {

            $bookingTables = Booking::create([ 
                "user_id" => Auth::user()->id,
                "name" => $request->name,
                "email" => $request->email, 
                "date" => $request->date, 
                "num_people" => $request->num_people, 
                "spe_request" => $request->spe_request, 
                
            ]); 

            if ($bookingTables) {

                return redirect()->route('home')->with(['booked' => 'Booking was successful']);
            } else {
                return redirect()->route('home')->with(['error' => 'Booking was not successful']);
            }

        } 
    }

    public function menu(){
        $breakfastFoods = Food::select()->take(4)
        ->where('category', 'breakfast')->orderBy('id', 'desc')->get();

        $launchFoods = Food::select()->take(4)
        ->where('category', 'launch')->orderBy('id', 'desc')->get();

        $dinnerFoods = Food::select()->take(4)
        ->where('category', 'dinner')->orderBy('id', 'desc')->get();

        return view('foods.menu', compact('breakfastFoods', 'launchFoods', 'dinnerFoods'));
    }
}
