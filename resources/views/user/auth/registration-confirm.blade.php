<x-layout>
  <x-register-back h1Title="会員登録" h2Title="入力フォーム"
  message="※下記の内容にて登録します。宜しければ登録ボタンをクリックしてください" step="2">

  <form action="{{ route('user.registration.send', ['token' => $urlToken]) }}" method="post">
    @csrf
    <table class="form-table">
      <tbody>
        <tr>
          <th><label for="lastname">お名前</label></th>
          <td>{{ $data['lastname'] . ' ' . $data['firstname'] }} 様</td>
        </tr>
        <tr>
          <th><label for="lastnamekana">フリガナ</label></th>
          <td>{{ $data['lastnamekana'] . ' ' . $data['firstnamekana'] }} サマ</td>
        </tr>
        <tr>
          <th><label>メールアドレス</label></th>
          <td>{{ $data['email'] }}</td>
        </tr>
        <tr>
          <th><label for="phone">電話番号</label></th>
          <td>{{ $data['phone'] }}</td>
        </tr>
        <tr>
          <th><label for="gender">性別</label></th>
          <td>
            @if ($data['gender'] === 0)
              男性
            @elseif ($data['gender'] === 1)
              女性
            @else
              その他
            @endif
          </td>
        </tr>
        <tr>
          <th><label for="password">パスワード</label></th>
          <td>{{ substr_replace($data['password'], '*****', -5) }}</td>
        </tr>
        <tr>
          <th><label for="consent">同意事項</label></th>
          <td>同意する</td>
        </tr>
      </tbody>
    </table>
    <div class="btn-flex">
      <a class="form-btn back-btn" href="{{ route('user.registration.create', ['token' => $urlToken]) }}">修正する</a>
      <button type="submit" class="form-btn">登録する</button>
    </div>
  </form>
  </x-register-back>
</x-layout>