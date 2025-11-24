<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Golf Range</title>
    <link rel="shortcut icon" href="{{ asset('images/golfball.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body>
    <header id="header" class="wrapper">
      <div id="header-left">
        <h1 id="logo">
          <a href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="ロゴ" />
          </a>
        </h1>
        <nav id="nav-menu">
          <x-navigation />
        </nav>
      </div>
      <div id="header-right">
          <div>
            <a id="contact" href="#">
              <img src="{{ asset('images/mail_icon.png') }}" alt="">
              <span>お問合せ</span>
            </a>
          </div>
          <div>
            @if (Auth::guard('users')->check())
              <form id="submit-form" action="{{ route('user.logout') }}" method="post">
                @csrf
                <button type="button" id="logout" class="auth-btn">ログアウト</button>
              </form>
            @else
              <a href="{{ route('user.loginForm') }}" class="auth-btn">会員ページへ</a>
            @endif
          </div>
      </div>
    </header>
      <main>
        {{ $slot }}
      </main>

    <script src="{{ asset('js/main.js') }}"></script>
  </body>
</html>