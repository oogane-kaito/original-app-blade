@extends('layouts.app')

@section('content')
    <div class="min-h-screen">
        <div class="container mx-auto px-4 py-8">
            <h2 class="text-2xl font-bold mb-6">名刺交換管理画面</h2>

            <x-ui.tabs defaultValue="received">
                <x-ui.tabs-list class="grid w-full grid-cols-4 bg-white rounded-2xl p-1 shadow-sm">
                    <x-ui.tabs-trigger value="traded" class="flex items-center gap-2 rounded-xl" type="button">
                        交換した名刺一覧
                    </x-ui.tabs-trigger>
                    <x-ui.tabs-trigger value="received" class="flex items-center gap-2 rounded-xl" type="button">
                        申請受信履歴
                    </x-ui.tabs-trigger>
                    <x-ui.tabs-trigger value="sent" class="flex items-center gap-2 rounded-xl" type="button">
                        申請送信履歴
                    </x-ui.tabs-trigger>
                    <x-ui.tabs-trigger value="complete" class="flex items-center gap-2 rounded-xl" type="button">
                        交換完了履歴
                    </x-ui.tabs-trigger>
                </x-ui.tabs-list>

                <!-- 名刺リンク集タブ -->
                <x-ui.tabs-content value="traded" class="space-y-4">
                    <h3 class="text-lg font-bold mb-4">名刺リンク集</h3>
                    @foreach($businessCards as $card)
                        <div class="p-4 bg-white rounded-lg shadow-md flex justify-between items-center">
                            <div>
                                <strong>{{ $card->name }}</strong> 
                                <span class="text-gray-500">({{ $card->title }})</span>
                                <div class="mt-2">
                                    <a href="{{ url('cards/' . $card->id) }}" class="text-blue-500 hover:underline" target="_blank">
                                        名刺の詳細を表示
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </x-ui.tabs-content>

                <!-- 送った申請タブ -->
                <x-ui.tabs-content value="sent" class="space-y-4">
                    @foreach($sentTrades as $trade)
                        <div class="p-4 bg-white rounded-lg shadow-md">
                            {{ $trade->receiver->name }} さんに申請を送信した
                            カード「{{ $trade->card->name }}」
                            [状態: <span class="{{ $trade->status === 'pending' ? 'text-yellow-600' : 'text-green-600' }}">{{ $trade->status }}</span>]
                        </div>
                    @endforeach
                </x-ui.tabs-content>


                <!-- 受け取った申請タブ -->
                <x-ui.tabs-content value="received" class="space-y-4">
                    @foreach($receivedTrades as $trade)
                        <div class="p-4 bg-white rounded-lg shadow-md flex justify-between items-center">
                            <div>
                                <strong>{{ $trade->sender->name }}</strong> さんから交換申請が来ました！
                                [状態: <span class="{{ $trade->status === 'pending' ? 'text-yellow-600' : 'text-green-600' }}">{{ $trade->status }}</span>]
                            </div>
                            @if($trade->status === 'pending')
                                <div class="space-x-2">
                                    <form action="{{ route('trades.accept', $trade) }}" method="POST" style="display:inline">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                                            承認
                                        </button>
                                    </form>
                                    <form action="{{ route('trades.reject', $trade) }}" method="POST" style="display:inline">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                                            拒否
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </x-ui.tabs-content>

                <!-- 送った申請タブ -->
                <x-ui.tabs-content value="sent" class="space-y-4">
                    @foreach($sentTrades as $trade)
                        <div class="p-4 bg-white rounded-lg shadow-md">
                            {{ $trade->receiver->name }} さんに申請を送信した
                            カード「{{ $trade->card->name }}」
                            [状態: <span class="{{ $trade->status === 'pending' ? 'text-yellow-600' : 'text-green-600' }}">{{ $trade->status }}</span>]
                        </div>
                    @endforeach
                </x-ui.tabs-content>

                <!-- 送った申請タブ -->
                <x-ui.tabs-content value="complete" class="space-y-4">
                    @foreach($completedTrades as $trade)
                        <div class="p-4 bg-white rounded-lg shadow-md flex justify-between items-center">
                            <div>
                                交換成立: 
                                <strong>{{ $trade->sender->name }}</strong> さんと 
                                <strong>{{ $trade->receiver->name }}</strong> さんの間で
                                カード「{{ $trade->card->name }}」の交換が成立しました。
                            </div>
                        </div>
                    @endforeach
                </x-ui.tabs-content>
            </x-ui.tabs>
        </div>
    </div>
@endsection