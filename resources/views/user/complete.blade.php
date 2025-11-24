<x-layout>
  <x-reserve-back h1Title="新規予約完了" h2Title="予約完了" message="ご予約有難うございます">
  <div id="complete">
    <img src="{{ asset('images/check-white.png') }}" alt="" />
  </div>
  <div class="complete-msg">
    <a href="{{ route('user.reserve.create') }}" class="complete-msg">予約・マイページへ戻る</a>
  </div>
  </x-reserve-back>
</x-layout>