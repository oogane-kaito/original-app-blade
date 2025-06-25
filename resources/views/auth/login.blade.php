@extends('layouts.app')

@section('content')
<div class="mt-10">
    <div class="prose mx-auto text-center mb-8 mt-8">
        <h2>ログイン</h2>
    </div>

    <div class="flex justify-center items-center">
        <form method="POST" action="{{ route('login') }}" class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
            @csrf

            <div class="form-control my-4">
                <label for="email" class="label">
                    <span class="label-text">メールアドレス</span>
                </label>
                <input type="email" name="email" class="input input-bordered w-full" required>
            </div>

            <div class="form-control my-4">
                <label for="password" class="label">
                    <span class="label-text">パスワード</span>
                </label>
                <div class="relative">
                    <input type="password" name="password" id="password" class="input input-bordered w-full" required>
                    <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3" onclick="togglePasswordVisibility('password')">
                        <span id="password-eye" class="material-icons">表示</span>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn transition duration-300 ease-in-out bg-orange-500 hover:bg-green-500 text-white font-semibold py-2 px-4 rounded-lg w-full">
                ログイン
            </button>

            {{-- ユーザー登録ページへのリンク --}}
            <p class="mt-2 text-center">新規ユーザーですか？ <a class="link link-hover text-info" href="{{ route('register') }}">今すぐ登録！</a></p>
        </form>
    </div>
</div>
    <script>
        function togglePasswordVisibility(id) {
            const passwordInput = document.getElementById(id);
            const eyeIcon = document.getElementById(id === 'password' ? 'password-eye' : 'confirmation-eye');
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.textContent = "非表示"; // アイコンを変更
            } else {
                passwordInput.type = "password";
                eyeIcon.textContent = "表示"; // アイコンを変更
            }
        }
    </script>

@endsection