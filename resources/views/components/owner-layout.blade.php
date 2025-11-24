<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>owner-site</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']);
  </head>
  <body>
    <header id="owner-header">
      <div><img src="{{ asset('images/logo_white.png')}}" alt=""></div>
      <div>
        <form action="{{ route('owner.logout') }}" method="post">
          @csrf
          <button type="button" id="owner-logout">ログアウト</button>
        </form>
        <p>管理者ページ</p>
      </div>
    </header>
    <div id="side-menu">
      <h2>メニュー</h2>
      <nav>
        <ul>
          <li><a href="{{ route('owner.settings') }}">設定確認画面</a></li>
          <li><a href="{{ route('owner.initForm') }}">初期設定</a></li>
        </ul>
      </nav>
    </div>
    <main>
      <div id="owner-container">
        <div id="owner-wrapper">
          {{ $slot }}
        </div>
      </div>
    </main>
    <script>
      'use strict'
      const logoutBtn = document.getElementById('owner-logout');
      logoutBtn.addEventListener('click', e => {
        e.preventDefault();
        if(confirm('ログアウトしますか？')) {
          e.target.closest('form').submit();
        } else {
          return false;
        }
      })
    </script>
  </body>
</html>