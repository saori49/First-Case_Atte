<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
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
      @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif

      @if(session('login_error'))
        <div class="alert alert-danger">
          {{session('login_error')}}
        </div>
      @endif

      @if(session('logout'))
        <div class="alert alert-success">
          {{session('logout')}}
        </div>
      @endif
      <h2 class="login-logo">ログイン</h2>
      <form class="login" action="/login" method="post">
      @csrf
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
        <button type="submit">ログイン</button>
      </form>
      
      <p class="unregistered">アカウントをお持ちでない方はこちらから</p>
      <a href="{{ route('register') }}" class="registration-button">会員登録</a>
    </div>
  </main>
  <footer class="footer">
    <p>Atte,inc.</p>
  </footer>
</body>
</html>