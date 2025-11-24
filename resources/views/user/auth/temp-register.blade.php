<x-layout>
  <x-register-back h1Title="会員登録" h2Title="入力フォーム" message="※アドレス等間違いのない様にお願い致します"
  step="1" >
    <form action="{{ route('user.temporary.store') }}" method="post">
      @csrf
      <table class="form-table">
        <tbody>
          <tr>
            <th>
              <label for="email">メールアドレス<span>必須</span></label>
            </th>
            <td>
              <input type="email" name="email" value="{{ old('email') }}"/>
              <x-input-error :messages="$errors->get('email')" />
            </td>
          </tr>
          <tr>
            <th>
              <label>メールアドレス（再入力）<span>必須</span></label>
            </th>
            <td>
              <input type="email" name="email_confirmation" value="{{ old('email_confirmation') }}"/>
            </td>
          </tr>
        </tbody>
      </table>
      <button type="submit" class="form-btn">送信する</button>
    </form>
  </x-register-back>
</x-layout>