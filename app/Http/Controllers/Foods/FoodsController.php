<?php

namespace App\Http\Controllers\Foods;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food\Food;
use App\Models\Food\Cart;
use Illuminate\Support\Facades\Auth;

class FoodsController extends Controller
{
    public function foodDetails($id) {

        $foodItem = Food::find($id);

        //verifying if the food item exists

        $cartVerify = Cart::where('food_id', $id)
        ->where('user_id', Auth::user()->id)->count();

        return view('foods.food-details', compact('foodItem', 'cartVerify'));

    }

    public function cart(Request $request, $id) {

        $cart = Cart::create([
            "user_id" => $request->user_id,
            "food_id" => $request->food_id, 
            "name" => $request->name, 
            "image" => $request->image, 
            "price" => $request->price, 
        ]);

        echo "Item Added to cart successfully";

        if($cart) {
            return redirect()->route('food.details', $id)->with(['success' => 'Item Added to cart successfully']);
        } else {
            return redirect()->route('food.details', $id)->with(['error' => 'Item not added to cart']);
        }
        
        // return view('foods.food-details', compact('foodItem'));

    }
}
