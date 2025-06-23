<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoritesController extends Controller
{
      // お気に入りを追加
    public function store($id)
    {
        

        $user = auth()->user();
        $user->favorites()->attach($id); // お気に入りを追加

        return back();
    }

    // お気に入りを削除
    public function destroy($id)
    {
        $user = auth()->user();
        
        if (!$user->favorites()->where('microposts_id', $id)->exists()) {
            return response()->json(['message' => 'Favorite not found.'], 404);
        }

        $user->favorites()->detach($id); // お気に入りを削除
        return back();
    }
}
