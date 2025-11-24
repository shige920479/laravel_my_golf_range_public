<x-owner-layout>
<div class="edit-wrapper">
  <p class="setting-title">ドライビングレンジ料金変更</p>
  <form action="{{ route('owner.settings.setNewRangeFee', ['redirect' => 'settings']) }}" method="post">
    @csrf
    <ul class="edit-input">
      <li>
        <label for="">レンジチャージ<small>（円/H）</small></label>
        <span><x-input-error :messages="$errors->get('entrance_fee')" /></span>
        <input type="number" name="entrance_fee" value="{{ old('entrance_fee', $rangeFee->entrance_fee) }}">
      </li>
      <li>
        <label for="">平日料金<small>（円/H）</small></label>
        <span><x-input-error :messages="$errors->get('weekday_fee')" /></span>
        <input type="number" name="weekday_fee" value="{{ old('weekday_fee', $rangeFee->weekday_fee) }}">    
      </li>
      <li>
        <label for="">休日料金<small>（円/H）</small></label>
        <span><x-input-error :messages="$errors->get('holiday_fee')" /></span>
        <input type="number" name="holiday_fee" value="{{ old('holiday_fee', $rangeFee->holiday_fee) }}">    
      </li>
      <li>
        <label for="">料金改定日</label>
        <span><x-input-error :messages="$errors->get('effective_date')" /></span>
        <input type="date" name="effective_date" value="{{ old('effective_date', $rangeFee->effective_date) }}">
      </li>
      <li>
        <button type="submit" class="form-btn">登録する</button>
      </li>
    </ul>
  </form>
</div>
</x-owner-layout>