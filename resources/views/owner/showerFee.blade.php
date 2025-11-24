<x-owner-layout>
  <div class="edit-wrapper">
    <p class="setting-title">シャワー料金変更</p>
    <form action="{{ route('owner.settings.setNewShowerFee', ['redirect' => 'settings']) }}" method="post">
      @csrf
      <ul class="edit-input">
        <li>
          <label for="">時間料金</label>
          <span><x-input-error :messages="$errors->get('shower_fee')" /></span>
          <input type="number" name="shower_fee" value="{{ old('shower_fee', $showerFee->shower_fee) }}">
        </li>
        <li>
          <label for="">料金改定日</label>
          <span><x-input-error :messages="$errors->get('effective_date')" /></span>
          <input type="date" name="effective_date" value="{{ old('effective_date', $showerFee->effective_date) }}">
        </li>
        <li>
          <button type="submit" class="form-btn">登録する</button>
        </li>
      </ul>
    </form>
  </div>
</x-owner-layout>