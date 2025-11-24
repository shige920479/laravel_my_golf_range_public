<x-owner-layout>
  <div class="edit-wrapper">
    <p class="setting-title">レンタルクラブ料金変更</p>
    <form action="{{ route('owner.settings.setNewRentalFee', ['redirect' => 'settings']) }}" method="post">
      @csrf
      <ul class="edit-input">
        <li>
          <label for="">時間料金</label>
          <span><x-input-error :messages="$errors->get('rental_fee')" /></span>
          <input type="number" name="rental_fee" value="{{ old('rental_fee', $rentalFee->rental_fee) }}">
        </li>
        <li>
          <label for="">料金改定日</label>
          <span><x-input-error :messages="$errors->get('effective_date')" /></span>
          <input type="date" name="effective_date" value="{{ old('effective_date', $rentalFee->effective_date) }}">
        </li>
        <li>
          <button type="submit" class="form-btn">登録する</button>
        </li>
      </ul>
    </form>
  </div>
</x-owner-layout>