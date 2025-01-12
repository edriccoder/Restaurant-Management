<?php

namespace App\Http\Controllers\Foods;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food\Food;
use App\Models\Food\Cart;
use App\Models\Food\checkout;
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
        return view('foods.checkout');
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

        echo "Go to Paypal to make payment";    
       
        // return view('foods.food-details', compact('foodItem'));

    }
}
