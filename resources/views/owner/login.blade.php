<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Golf Range</title>
    @vite(['resources/css/app.css'])
  </head>
  <body>
    <section id="owner-login-wrapper">
       <div><img src="{{ asset('images/logo.png') }}" alt=""></div>
      <div id="manager-title">管理者ログイン</div>
      <form action="{{ route('owner.login') }}" method="post">
        @csrf
        <div class="login-box">
          <h3>Sign Up</h3>
          <ul>
            <div class="input">
              <label for="email">メールアドレス</label>
              <input type="email" name="email" id="email" value="{{ old('email') }}"/>
              <x-input-error :messages="$errors->get('email')" />
            </div>
            <div class="input">
              <label for="password">パスワード</label>
              <input type="password" name="password" id="password"/>
              <x-input-error :messages="$errors->get('password')" />
            </div>
            <button type="submit">Login</button>
          </ul>
        </div>
      </form>
    </section>
  </body>
</html>