<?php

namespace App\Http\Controllers;

use App\Models\BusinessCard;
use App\Models\BusinessCardTrade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessCardTradeController extends Controller
{
    // 申請一覧（送信・受信両方）
    public function index()
    {
        $user = Auth::user();
        $sentTrades = BusinessCardTrade::where('sender_id', $user->id)->with('receiver', 'card')->latest()->get();
        $receivedTrades = BusinessCardTrade::where('receiver_id', $user->id)->with('sender', 'card')->latest()->get();
        return view('trades.index', compact('sentTrades', 'receivedTrades'));
    }

    // トレード申請
    public function tradeRequest(Request $request)
    {
        $request->validate([
            'card_id' => 'required|exists:business_cards,id',
            'receiver_id' => 'required|exists:users,id|different:' . Auth::id(),
        ]);

        // 自分のカードのみ申請可能
        $card = BusinessCard::where('id', $request->card_id)->where('user_id', Auth::id())->firstOrFail();

        // 重複申請防止
        $exists = BusinessCardTrade::where('sender_id', Auth::id())
            ->where('receiver_id', $request->receiver_id)
            ->where('card_id', $card->id)
            ->where('status', 'pending')
            ->exists();

        if ($exists) {
            dd("こんちゃす");
            return redirect()->route('trades.index')->with('error','すでに申請中です');;
        }

        BusinessCardTrade::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'card_id' => $card->id,
            'status' => 'pending',
        ]);

        return redirect()->route('trades.index')->with('success','承認しました');
    }

    // 承認
    public function accept($id)
    {
        $trade = BusinessCardTrade::where('id', $id)
            ->where('receiver_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        $trade->status = 'accepted';
        $trade->save();

        // 必要ならここで通知やカードの複製など処理

        return redirect()->route('trades.index')->with('success','交換を承認しました');
    }

    // 拒否
    public function reject($id)
    {
        $trade = BusinessCardTrade::where('id', $id)
            ->where('receiver_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        $trade->status = 'rejected';
        $trade->save();

        // 必要ならここで通知など処理

        return redirect()->route('trades.index')->with('info','交換を拒否しました');
    }
}