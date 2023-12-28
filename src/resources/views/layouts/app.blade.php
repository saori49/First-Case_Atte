<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
    <title>Atte</title>
</head>

<body>
    <header class="header">
    <div class="header-inner">
        <div class="header-left">
            <h1>Atte</h1>
    </div>

    @if (Auth::check())
    <div class="header-right">
        <a href="{{ route('index') }}" >ホーム</a>
        <a href="{{ route('showAttendance') }}" >日付一覧</a>
        <form class="logout" action="/logout" method="post">
        @csrf
            <button type="submit">ログアウト</button>
        </form>
    </div>
    @endif
    </div>
</header>
<main class="main">
    @yield('content')
</main>
<footer class="footer">
    <p>Atte,inc.</p>
</footer>
</body>
</html>