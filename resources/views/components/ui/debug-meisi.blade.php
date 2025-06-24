     @if(config('app.debug'))
            <div class="container mx-auto px-4 py-2">
                <details class="bg-gray-100 p-4 rounded">
                    <summary class="cursor-pointer font-bold">デバッグ情報</summary>
                    <div class="mt-2 space-y-2">
                        <p><strong>Errors:</strong> {{ $errors->count() }}</p>
                        <p><strong>Session Error:</strong> {{ session('error') }}</p>
                        <p><strong>Session Success:</strong> {{ session('success') }}</p>
                        <p><strong>Visibility Value:</strong> {{ json_encode($cardData['visibility']) }} ({{ gettype($cardData['visibility']) }})</p>
                        <p><strong>Old Input:</strong> {{ json_encode(old()) }}</p>
                        @if($errors->any())
                            <div class="bg-red-100 p-2 rounded">
                                <strong>All Errors:</strong>
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </details>
            </div>
        @endif