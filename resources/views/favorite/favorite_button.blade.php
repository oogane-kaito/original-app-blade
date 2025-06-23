@if (Auth::check())
    @if (Auth::user()->id !== $micropost->user_id)
        @if (Auth::user()->favorites()->where('microposts_id', $micropost->id)->exists())
            {{-- お気に入り解除ボタン --}}
            <form method="POST" action="{{ route('favorites.unfavorite', $micropost->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-error btn-sm normal-case" 
                    onclick="return confirm('お気に入りを解除しますか？')">お気に入り解除</button>
            </form>
        @else
            {{-- お気に入り追加ボタン --}}
            <form method="POST" action="{{ route('favorites.favorite', $micropost->id) }}">
                @csrf
                <button type="submit" class="btn btn-primary btn-sm normal-case">お気に入り追加</button>
            </form>
        @endif
    @endif
@endif