<x-layout>
  <x-login-back h1Title="会員専用 ログインページ" h2Title="予約・ログイン" 
    message="アドレス等間違いのない様にお願い致します">

    <form action="{{ route('user.login') }}" method="post">
      @csrf
      <table class="form-table">
        <tbody>
          <tr>
            <th>
              <label for="email">メールアドレス<span>必須</span></label>
            </th>
            <td>
              <input type="email" name="email" value="{{ old('email') }}">
              <x-input-error :messages="$errors->get('email')" />
            </td>
          </tr>
          <tr>
            <th>
              <label>パスワード<span>必須</span></label>
            </th>
            <td>
              <input type="password" name="password"/>
              <x-input-error :messages="$errors->get('password')" />
            </td>
          </tr>
        </tbody>
      </table>
      <button type="submit" class="form-btn">送信する</button>
    </form>

  </x-login-back>
</x-layout>