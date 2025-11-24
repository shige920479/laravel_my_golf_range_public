<x-layout>
  <x-register-back h1Title="会員登録" h2Title="入力フォーム" message="※アドレス等間違いのない様にお願い致します" step="2">
    <form action="{{ route('user.registration.store', ['token' => $urlToken]) }}" method="post">
      @csrf
      <table class="form-table">
        <tbody>
          <tr>
            <th><label for="lastname">お名前<span>必須</span></label></th>
            <td>
              <label for="lastname">性  </label>
              <input type="text" name="lastname" id="lastname" value="{{ old('lastname', session('registration_data.lastname')) }}"/>
              <label for="firstname">名  </label>
              <input type="text" name="firstname" id="firstname" value="{{ old('firstname', session('registration_data.firstname')) }}" />
              <div style="margin-top: 5px">
                <x-input-error :messages="$errors->get('lastname')" />
                <x-input-error :messages="$errors->get('firstname')" />
              </div>
            </td>
          </tr>
          <tr>
            <th><label for="lastnamekana">フリガナ<span>必須</span></label></th>
            <td>
              <label for="lastnamekana">セイ</label>
              <input type="text" name="lastnamekana" id="lastnamekana" value="{{ old('lastnamekana', session('registration_data.lastnamekana')) }}"/>
              <label for="firstnamekana">メイ</label>
              <input type="text" name="firstnamekana" id="firstnamekana" value="{{ old('firstnamekana', session('registration_data.firstnamekana')) }}"/>
              <div style="margin-top: 5px">
                <x-input-error :messages="$errors->get('lastnamekana')" />
                <x-input-error :messages="$errors->get('firstnamekana')" />
              </div>
            </td>
          </tr>
          <tr>
            <th><label>メールアドレス</label></th>
            <td>
              {{ $userEmail }}
              <x-input-error :messages="$errors->get('email')" />
            </td>
    
          </tr>
          <tr>
            <th><label for="phone">電話番号<span>必須</span></label></th>
            <td>
              <input type="text" name="phone" id="phone" value="{{ old('phone', session('registration_data.phone')) }}"/>
              <x-input-error :messages="$errors->get('phone')" />
            </td>
          </tr>
          <tr>
            <th><label for="gender">性別</label></th>
            <td>
              <input type="radio" name="gender" value="0" @if (old('gender') === "0" || session('registration_data.gender') === "0") checked @endif />男性
              <input type="radio" name="gender" value="1" @if (old('gender') === "1" || session('registration_data.gender') === "1") checked @endif />女性
              <input type="radio" name="gender" value="2" @if (old('gender') === "2" || session('registration_data.gender') === "2") checked @endif />その他
              <x-input-error :messages="$errors->get('gender')" />
            </td>
          </tr>
          <tr>
            <th><label for="password">パスワード<span>必須</span></label></th>
            <td>
              <input type="password" name="password" id="password" />
              <x-input-error :messages="$errors->get('password')" />
            </td>
          </tr>
          <tr>
            <th><label for="password_confirmation">パスワード（再入力）<span>必須</span></label></th>
            <td><input type="password" name="password_confirmation" id="password_confirmation" /></td>
          </tr>
          <tr>
            <th><label for="consent">同意事項<span>必須</span></label></th>
            <td><input type="checkbox" name="consent" id="consent" />同意する</td>
          </tr>
        </tbody>
      </table>
      <input type="hidden" name="email" value="{{ $userEmail }}">
      <button type="submit" id="regist-btn" class="form-btn">登録する</button>
    </form>
  </x-register-back>
</x-layout>