@php
  $route = request()->route()->getName();
  $params = match ($route) {
    'user.mypage.complete' => ['h1' => '変更登録完了', 'h2' => '予約変更完了', 'msg' => 'ご予約内容を変更しました'],
    'user.mypage.cancel.complete' => ['h1' => 'キャンセル完了', 'h2' => '予約取消', 'msg' => 'ご予約をキャンセルしました、またのご来場をお待ちしております'],
    default => null
  }
@endphp

<x-layout>
   <x-reserve-back h1Title="{{$params['h1']}}" h2Title="{{$params['h2']}}" message="{{$params['msg']}}">
    <div id="complete">
      <img src="{{ asset('images/check-white.png') }}" alt="" />
    </div>
    <div class="complete-msg">
      <a href="{{ route('user.mypage.index') }}" class="complete-msg">予約確認・変更へ戻る</a>
    </div>
  </x-reserve-back>
</x-layout>