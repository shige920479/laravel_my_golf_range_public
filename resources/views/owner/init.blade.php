<x-owner-layout>
  <section class="init-setting">
    <form action="{{ route('owner.setDrivingRange') }}" method="post">
      @csrf
      <p class="setting-title">ドライビングレンジ登録</p>
      @if (session('success-drivingRange'))
        <span class="success">{{ session('success-drivingRange') }}</span>
      @endif
      <button type="submit" class="form-btn">設定登録</button>
      <table>
        <thead>
          <tr>
            <th><p>①</p></th><th><p>②</p></th><th><p>③</p></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><input type="text" name="name[]" value="{{ old('name.0') }}"></td>
            <td><input type="text" name="name[]" value="{{ old('name.1') }}"></td>
            <td><input type="text" name="name[]" value="{{ old('name.2') }}"></td>
          </tr>
          <tr>
            <td><x-input-error :messages="$errors->get('name.0')" /></td>
            <td><x-input-error :messages="$errors->get('name.1')" /></td>
            <td><x-input-error :messages="$errors->get('name.2')" /></td>
          </tr>
        </tbody>
      </table>
    </form>
  </section>
  <section class="init-setting">
    <form action="{{ route('owner.settings.setNewRangeFee', ['redirect' => 'init']) }}" method="post">
      @csrf
      <p class="setting-title">ドライビングレンジ料金登録</p>
      @if (session('success-rangeFee'))
        <span class="success">{{ session('success-rangeFee') }}</span>
      @endif
      <button type="submit" class="form-btn">設定登録</button>
      <table>
        <thead>
          <tr>
            <th><p>チャージ（円/人）</p></th>
            <th><p>平日料金（円/H）</p></th>
            <th><p>休日料金（円/H）</p></th>
            <th><p>適用開始日</p></th>
          </tr>
        </thead>
          <tbody>
            <tr>
              <td><input type="number" name="entrance_fee" value="{{ old('entrance_fee') }}"></td>
              <td><input type="number" name="weekday_fee" value="{{ old('weekday_fee') }}"></td>
              <td><input type="number" name="holiday_fee" value="{{ old('holiday_fee') }}"></td>
              <td><input type="date" name="effective_date" value="{{ old('effective_date') }}"></td>
            </tr>
            <tr>
                <td><x-input-error :messages="$errors->get('entrance_fee')" /></td>
                <td><x-input-error :messages="$errors->get('weekday_fee')" /></td>
                <td><x-input-error :messages="$errors->get('holiday_fee')" /></td>
                <td><x-input-error :messages="$errors->get('effective_date')" /></td>
              </tr>
          </tbody>
      </table>
    </form>
  </section>
 <section class="init-setting">
    <form action="{{ route('owner.setRental') }}" method="post">
      @csrf
      <p class="setting-title">レンタルクラブ登録</p>
      @if (session('success-rental'))
        <span class="success">{{ session('success-rental') }}</span>
      @endif
      <button type="submit" class="form-btn">設定登録</button>
      <table>
        <thead>
          <tr>
            <th><p>ブランド</p></th>
            <th colspan="2"><p>モデル</p></th>
          </tr>
        </thead>
          <tbody>
            <tr>
              <td><input type="text" name="brand[]" value="{{ old('brand.0') }}"></td>
              <td colspan="2"><input type="text" name="model[]" value="{{ old('model.0') }}"></td>
            </tr>
            <tr>
              <td><x-input-error :messages="$errors->get('brand.0')" /></td>
              <td colspan="2"><x-input-error :messages="$errors->get('model.0')" /></td>
            </tr>
            <tr>
              <td><input type="text" name="brand[]" value="{{ old('brand.1') }}"></td>
              <td colspan="2"><input type="text" name="model[]" value="{{ old('model.1') }}"></td>
            </tr>
            <tr>
              <td><x-input-error :messages="$errors->get('brand.1')" /></td>
              <td colspan="2"><x-input-error :messages="$errors->get('model.1')" /></td>
            </tr>
          </tbody>
      </table>
    </form>
  </section>
  <section class="init-setting">
    <form action="{{ route('owner.settings.setNewRentalFee', ['redirect' => 'init']) }}" method="post">
      @csrf
      <p class="setting-title">レンタルクラブ料金</p>
      @if (session('success-rentalFee'))
        <span class="success">{{ session('success-rentalFee') }}</span>
      @endif
      <button type="submit" class="form-btn">設定登録</button>
      <table>
        <thead>
          <tr>
            <th><p>レンタル料金（円/H）</p></th>
            <th><p>適用開始日</p></th>
          </tr>
        </thead>
          <tbody>
            <tr>
              <td><input type="text" name="rental_fee" value="{{ old('rental_fee') }}"></td>
              <td><input type="date" name="effective_date" value="{{ old('effective_date') }}"></td>
            </tr>
            <tr>
              <td><x-input-error :messages="$errors->get('rental_fee')" /></td>
              <td><x-input-error :messages="$errors->get('effective_date')" /></td>
            </tr>
          </tbody>
      </table>
    </form>
  </section>
  <section class="init-setting">
    <form action="{{ route('owner.settings.setNewShowerFee', ['redirect' => 'init']) }}" method="post">
      @csrf
      <p class="setting-title">シャワー料金登録</p>
      @if (session('success-showerFee'))
        <span class="success">{{ session('success-showerFee') }}</span>
      @endif
      <button type="submit" class="form-btn">設定登録</button>
      <table>
        <thead>
          <tr>
            <th><p>料金（円/回）</p></th>
            <th><p>適用開始日</p></th>
          </tr>
        </thead>
          <tbody>
            <tr>
              <td><input type="number" name="shower_fee" value="{{ old('shower_fee') }}"></td>
              <td><input type="date" name="effective_date" value="{{ old('effective_date') }}"></td>
            </tr>     
            <tr>
              <td><x-input-error :messages="$errors->get('shower_fee')" /></td>
              <td><x-input-error :messages="$errors->get('effective_date')" /></td>
            </tr>     
          </tbody>
      </table>
    </form>
  </section>
</x-owner-layout>