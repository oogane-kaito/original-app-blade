@extends('layouts.app')

@section('content')
<h2>受け取った申請</h2>
@foreach($receivedTrades as $trade)
    <div>
        {{ $trade->sender->name }} さんから
        カード「{{ $trade->card->name }}」の交換申請
        [状態: {{ $trade->status }}]
        @if($trade->status === 'pending')
            <form action="{{ route('trades.accept', $trade) }}" method="POST" style="display:inline">
                @csrf
                <button type="submit">承認</button>
            </form>
            <form action="{{ route('trades.reject', $trade) }}" method="POST" style="display:inline">
                @csrf
                <button type="submit">拒否</button>
            </form>
        @endif
    </div>
@endforeach

<h2>送った申請</h2>
@foreach($sentTrades as $trade)
    <div>
        {{ $trade->receiver->name }} さんに申請した
        カード「{{ $trade->card->name }}」
        [状態: {{ $trade->status }}]
    </div>
@endforeach
@endsection