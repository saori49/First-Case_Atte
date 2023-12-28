<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
  <link rel="stylesheet" href="{{ asset('css/register.css') }}">
  <title>login</title>
</head>
<body>
  <header class="header">
    <div class="header-inner">
      <div class="header-left">
        <h1>Atte</h1>
      </div>
    </div>
  </header>
  <main class="main">
    <div class="main-container">
      <h2 class="login-logo">会員登録</h2>
      <form class="register" action="{{ route('register') }}" method="post">
      @csrf
        <input type="text" name="name" value="{{ old('name') }}" placeholder="名前">
        <div class="error">
        @error('name')
        {{$message}}
        @enderror
        </div>

        <input type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレス">
        <div class="error">
        @error('email')
        {{$message}}
        @enderror
        </div>

        <input type="password" name="password" placeholder="パスワード">
        <div class="error">
        @error('password')
        {{$message}}
        @enderror
        </div>

        <input type="password" name="password_confirmation" placeholder="パスワード確認">
        <div class="error">
        @error('password')
        {{$message}}
        @enderror
        </div>

        <button type="submit" action="">会員登録</button>
      </form>
      <p class="unregistered">アカウントをお持ちの方はこちらから</p>
      <a href="{{ route('showLoginForm') }}" class="login-button">ログイン</a>
    </div>
  </main>
  <footer class="footer">
    <p>Atte,inc.</p>
  </footer>
</body>
</html>