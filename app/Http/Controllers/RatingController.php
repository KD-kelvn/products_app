<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RatingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $ratings = $user->userRatings()->get();

        return response()->json($ratings);
    }
public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'rating' => [
            'required',
            'numeric',
            'between:1,5',
            Rule::unique('user_ratings')->where(function ($query) use ($request) {
                return $query->where('user_id', $request->user()->id)
                             ->where('product_id', $request->product_id);
            })
        ]
    ], [
        'rating.unique' => 'You have already rated this product'
    ]);

    $data = [
        'product_id' => $request->product_id,
        'rating' => $request->rating,
        'rating_datetime' => now()
    ];

    $user = $request->user();
    $user->userRatings()->create($data);

    return response()->json(['message' => 'Rating saved successfully']);
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|numeric|between:1,5'
        ]);

        $user = $request->user();
        $user->userRatings()->where('product_id', $id)->update([
            'rating' => $request->rating,
            'rating_datetime' => now()
        ]);

        return response()->json(['message' => 'Rating updated successfully']);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $user->userRatings()->where('product_id', $id)->delete();

        return response()->json(['message' => 'Rating deleted successfully']);
    }
}
