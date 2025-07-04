<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>デジタル名刺サイト</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
    </head>

    <body class="bg-gradient-to-br from-orange-50 via-green-50 to-white">

        
        @include('commons.navbar')
        <div class="container mx-auto min-h-screen bg-gradient-to-br from-orange-50 via-green-50 to-white">
            {{-- ナビゲーションバー --}}
            
            {{-- エラーメッセージ --}}
            @include('commons.error_messages')

            @yield('content')
        </div>

        @stack("scripts")

    </body>
</html>