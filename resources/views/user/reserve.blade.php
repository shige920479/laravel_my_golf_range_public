<x-layout>
  <x-reserve-back h1Title="ご予約" h2Title="" message="">
    <div id="reserve-input">
      <p class="area-title">予約入力エリア</p>
      <form action="{{ route('user.reserve.store') }}" method="post">
        @csrf
        <div id="input-area">
          <div id="range">
            <p class="select-title">ドライビングレンジ選択</p>
            <select name="driving_range_id">
              <option value="">選択してください</option>
              @foreach ($ranges as $range)
                <option value="{{ $range->id }}" @if ((int)old('driving_range_id', session('reservation.driving_range_id')) === $range->id) selected @endif >
                  {{ $range->name }}
                </option>
              @endforeach
            </select>
            <x-input-error :messages="$errors->get('driving_range_id')" type="reserve" />
          </div>
          <div id="number">
            <p class="select-title">ご利用人数</p>
            <select name="number">
              <option value="">選択してください</option>
              <option value="1" @if((int)old('number', session('reservation.number')) === 1) selected @endif>1名様</option>
              <option value="2" @if((int)old('number', session('reservation.number')) === 2) selected @endif>2名様</option>
            </select>
            <x-input-error :messages="$errors->get('number')" type="reserve" />
          </div>
          <div id="reserve-date">
            <p class="select-title">ご利用日時</p>
            <p>ご利用日</p>
            <select name="reserve_date">
              <option value="">選択してください</option>
              @for ($i = 0; $i < \Constant::MAX_RESERVE_DATE; $i++)
                <option value="{{ $refDate->copy()->addDay($i)->format('Y-m-d') }}"
                  @if (old('reserve_date', session('reservation.reserve_date')) === $refDate->copy()->addDay($i)->format('Y-m-d')) selected @endif >
                  {{ $refDate->copy()->addDay($i)->isoFormat('MM月DD日(ddd)') }}
                </option>
              @endfor
            </select>
            <x-input-error :messages="$errors->get('reserve_date')" type="reserve" />
            <div id="time-flex">
              <div>
                <p>ご利用開始時間</p>
                <select name="start_time" id="start-time">
                  <option value="">選択してください</option>
                  @for ($time = $openTime->copy(); $time < $closeTime; $time->addminutes(30))
                    <option value="{{ $time->format('H:i:s') }}" @if(old('start_time', session('reservation.start_time')) === $time->format('H:i:s')) selected @endif>
                      {{ $time->format('H:i') }}
                    </option>
                  @endfor
                </select>
              </div>
              <div>
                <p>ご利用終了時間</p>
                <select name="end_time" id="end-time">
                  <option value="">選択してください</option>
                  @for ($time = $openTime->copy()->addminutes(30); $time <= $closeTime; $time->addminutes(30))
                    <option value="{{ $time->format('H:i:s') }}" @if(old('end_time', session('reservation.end_time')) === $time->format('H:i:s')) selected @endif>
                      {{ $time->format('H:i') }}
                    </option>
                  @endfor
                </select>
              </div>
            </div>
            <x-input-error :messages="$errors->get('start_time')" type="reserve" />
            <x-input-error :messages="$errors->get('end_time')" type="reserve"/>
          </div>
          <div id="option">
            <p class="select-title">レンタルオプション</p>
              <input type="checkbox" name="rental" class="check-box" value="1" @if(old('rental', session('reservation.rental'))) checked @endif id="rental"/>
              <label for="rental">利用する</label>
            <ul>
              <li>
                <p>クラブ</p>
                <select id="club-select" name="rental_id">
                  <option value="">選択してください</option>
                    @foreach($rentals as $rental): ?>
                      <option data-model="{{ $rental->model }}" class="club" value="{{ $rental->id }}"
                        @if ((int)old('rental_id', session('reservation.rental_id')) === $rental->id) selected @endif>
                        {{ $rental->brand }}
                      </option>
                    @endforeach
                </select>
              </li>
              <li>
                <p>モデル</p>
                <p id="model-display"></p>
              </li>
            </ul>
            <x-input-error :messages="$errors->get('rental_id')" type="reserve"/>
          </div>
          <div id="shower-room">
            <p class="select-title">シャワールーム利用</p>
            <div>
              <input type="checkbox" name="shower" class="check-box" value="1"
               @if ((old('shower', session('reservation.shower')))) checked @endif id="shower"/>
              <label for="shower">利用する</label>
            </div>
            <div>
              <p>ご利用開始時間（ご利用時間25分）</p>
              <select name="shower_time" id="shower-time">
                <option value="">選択してください</option>
                @for ($time = $openTime->copy(); $time < $closeTime; $time->addMinutes(30))
                  <option value="{{ $time->format('H:i:s') }}"  @if(old('shower_time', session('reservation.shower_time')) === $time->format('H:i:s')) selected @endif>
                    {{ $time->format('H:i') . '～' . $time->copy()->addMinute(25)->format('H:i') }}
                  </option>
                @endfor
              </select>
              <label for="shower-time"></label>
            </div>
            <x-input-error :messages="$errors->get('shower_time')" type="reserve" />
          </div>
          <div>
            <button type="submit" class="form-btn">予約する</button>
          </div>
        </div>
        <input type="hidden" name="search_date" value="{{ $searchDate }}">
      </form>
    </div>
    <div id="reserve-info">
      <p class="area-title">情報確認エリア</p>
      <div id="information-area">
        <div class="date-weather-flex">
          <x-search-date :refDate="$refDate" :searchDate="$searchDate" />
          <x-weather :weatherInfo="$weatherInfo" />
        </div>
        <x-timetable :allData="$allData" :openTime="$openTime" :closeTime="$closeTime"
         :searchDate="$searchDate"/>
      </div>
     </div>
  </x-reserve-back>
</x-layout>