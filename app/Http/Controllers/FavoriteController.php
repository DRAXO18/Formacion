<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function toggleFavorite(Request $request)
    {
        $favorite = Favorite::where('user_id', auth()->id())
            ->where('view_name', $request->view_name)
            ->where('view_params', $request->view_params)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['status' => 'removed']);
        } else {
            Favorite::create([
                'user_id' => auth()->id(),
                'view_name' => $request->view_name,
                'view_params' => $request->view_params,
            ]);
            return response()->json(['status' => 'added']);
        }
    }

    public function getFavorites()
    {
        $favorites = Favorite::where('user_id', auth()->id())->get();
        return view('partials.favorites_modal', compact('favorites'));
    }
}
