<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessCard;
use Illuminate\Support\Facades\Auth;

class EditorController extends Controller
{
 public function index()
 {  

        $businessCard = BusinessCard::where('user_id', Auth::id())->first();
        
        if (!$businessCard) {
            $businessCard = BusinessCard::create([
                'user_id' => Auth::id(),
                'name' => '',
                'title' => '',
                'bio' => '',
                'avatar' => '/placeholder.svg?height=120&width=120',
                'theme' => 'nature',
                'backgroundColor' => '#f0fdf4',
                'textColor' => '#1f2937',
                'accentColor' => '#22c55e',
                'phone' => '',
                'email' => '',
                'links' => [
                    // 初期値としての空のリンクを定義
                    ['id' => '', 'title' => '', 'url' => '', 'icon' => 'website', 'delete' => false]
                ],
                'visibility' => false
            ]);
        }

        return view('editor.index', compact('businessCard'));
 }

 public function show($id)
    {
        $businessCard = BusinessCard::findOrFail($id);
        // dd($businessCard->visibility);
        // dd(Auth::check());
        // Check if the card is public or belongs to the authenticated user
        if (!$businessCard->visibility ) {

            
            abort(404, 'この名刺は公開されていません。');
            
        }else{
            return view('cards.show', compact('businessCard'));
        }

        
    }

}
