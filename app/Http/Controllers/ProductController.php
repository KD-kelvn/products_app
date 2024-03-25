<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        
        $products = Product::withAvgRating()->get();

        $products->each(function ($product) use ($userId) {
            $product->ratings = $product->userRatings->avg('rating');
            $product->user_rating = $product->userRatings->where('user_id', $userId)->first()->rating ?? null;

            $product->userRatings->each(function ($rating) {
                $rating->time_passed = now()->diffInMinutes($rating->rating_datetime);
                $rating->active_time = $rating->time_passed > 30 ? "active" : "inactive";
                unset(   $rating->user_id,
                    $rating->product_id,
                    $rating->rating_datetime,
                    $rating->created_at,
                    $rating->updated_at,
                    $rating->deleted_at,
                    $rating->rating
                );

                

            });

           
          
        });

        return response()->json($products);
    }


}
