<?php

namespace App\Http\Controllers;

use App\Models\BusinessCard;
use App\Models\BusinessCardTrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class BusinessCardTradeController extends Controller
{
    // 申請一覧（送信・受信両方）
    public function index()
    {
        $user = Auth::user();
        
        // 送信したトレード申請の取得
        $sentTrades = BusinessCardTrade::where('sender_id', $user->id)
            ->with('receiver', 'card')
            ->latest()
            ->get();
        
        // 受信したトレード申請の取得
        $receivedTrades = BusinessCardTrade::where('receiver_id', $user->id)
            ->with('sender', 'card')
            ->latest()
            ->get();

        // 完了した交換を取得
        $completedTrades = BusinessCardTrade::where('status', 'accepted')->where(function($query) {
            $query->where('sender_id', auth()->id())
                ->orWhere('receiver_id', auth()->id());
        })->get();

        // 承認された取引のidのみを取得
        $acceptedTrades = BusinessCardTrade::where('receiver_id', auth()->id())
            ->where('status', 'accepted')
            ->pluck('sender_id'); // accepted の名刺IDを取得

        // 公開されている名刺を取得
        $businessCards = BusinessCard::whereIn('id', $acceptedTrades)
            ->where('visibility', true)
            ->get(); // visibilityがtrueの名刺を取得
       
        return view('trades.index', compact('sentTrades', 'receivedTrades','completedTrades','businessCards'));
    }

    // トレード申請
   public function tradeRequest(Request $request)
{
    try {
        // バリデーション
        $request->validate([
            'card_id' => 'required|exists:business_cards,id',
            'receiver_id' => 'required|exists:users,id|different:' . Auth::id(),
        ]);

         // すでに成立している取引を確認
    $existingTrade = BusinessCardTrade::where(function($query) use ($request) {
        $query->where('sender_id', auth()->id())
              ->where('receiver_id', $request->receiver_id );
    })->orWhere(function($query) use ($request ) {
        $query->where('sender_id', $request->receiver_id )
              ->where('receiver_id', auth()->id());
    })->first();

     if ($existingTrade) {
        return redirect()->back()->with('error', 'このユーザーとの間で既に取引が成立しています。');
    }


        // ユーザーが所有するカードを取得
        $card = BusinessCard::where('id', $request->card_id)
            ->where('user_id',$request->receiver_id )
            ->first();

       
        if (!$card) {
            return redirect()->back()->with('error', 'このカードは存在しないか、あなたの所有するカードではありません。');
        }

        // 重複申請のチェック
        $exists = BusinessCardTrade::where('sender_id', Auth::id())
            ->where('receiver_id', $request->receiver_id)
            ->where('card_id', $card->id)
            ->where('status', 'pending')
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'このカードの交換申請は既に送信されています。');
        }

        // トレード申請の作成
        BusinessCardTrade::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'card_id' => $card->id,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'カードの交換申請が送信されました。');

    } catch (Exception $e) {
        // エラーログに記録
        \Log::error('トレード申請中にエラーが発生しました: ' . $e->getMessage());

        // ユーザーにわかりやすいエラーメッセージを表示
        return redirect()->back()->with('error', '申し訳ありませんが、トレード申請の処理中にエラーが発生しました。再試行してください。');
    }
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

        return back()->with('success', '交換を承認しました！');
    } 


    // 拒否
    public function reject($id)
    {
        try {
            // トレード申請の取得
            $trade = BusinessCardTrade::where('id', $id)
                ->where('receiver_id', Auth::id())
                ->where('status', 'pending')
                ->firstOrFail();

            // ステータスの更新
            $trade->status = 'rejected';
            $trade->save();

            return redirect()->back()->with('info', '申請を拒否しました。');

        } catch (Exception $e) {
            // エラーログに記録
            \Log::error('トレード拒否中にエラーが発生しました: ' . $e->getMessage());

            // ユーザーにわかりやすいエラーメッセージを表示
            return redirect()->back()->with('error', '申し訳ありませんが、拒否処理中にエラーが発生しました。再試行してください。');
        }
    }
}