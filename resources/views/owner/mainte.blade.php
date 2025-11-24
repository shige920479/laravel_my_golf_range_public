@php
  $type = request()->route()->parameter('type');
  if($type === 'drivingRange') $mainte_date = $drivingRange->mainte_date;
  if($type === 'rental') $mainte_date = $rental->mainte_date;
  if($type === 'shower') $mainte_date = $shower->mainte_date;
@endphp

<x-owner-layout>
<div class="edit-wrapper">
  <p class="setting-title">メンテナンス日登録</p>
  
  @if($type === 'drivingRange')
    <p>ドライビングレンジ</p>
    <div>
      <p>レンジ名</p>
      <p>{{ $drivingRange->name }}</p>
    </div>
  
  @elseif($type === 'rental')
    <p>クラブレンタル</p>
    <div>
      <p>ブランド</p>
      <p>{{ $rental->brand }}</p>
    </div>
    <div>
      <p>モデル</p>
      <p>{{ $rental->model }}</p>
    </div>

  @elseif($type === 'shower')
    <p>シャワールーム</p>
  @endif

  <form action="{{ route('owner.settings.setNewMainte', ['type' => $type, 'id' => $id]) }}" method="post">
    @csrf
    <ul class="edit-input">
      <li>
      <label for="prev-mainte"><?php ?></label>
      <div id="prev-mainte">
        <span>前回メンテナンス日</span>
        {{ $mainte_date ?? '設定なし' }}
      </div>
      </li>
      <li>
        <label for="mainte-date">予定日登録</label>
        <span><x-input-error :messages="$errors->get('mainte_date')" /></span>
        <input id="mainte-date" type="date" name="mainte_date" placeholder="日付を選択"
        value="{{ old('mainte_date') }}">
      </li>
    </ul>
    <button type="submit" class="form-btn">登録する</button>
  </form>
</div>


</x-owner-layout>