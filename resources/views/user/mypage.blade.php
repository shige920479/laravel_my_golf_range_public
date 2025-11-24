<x-layout>
  <x-reserve-back h1Title="予約内容のご確認" h2Title="予約確認・変更・キャンセル" message="">
    <x-input-error :messages="$errors->get('cancelled')" type="reserve"/>
    <table id="reserve-list">
      <thead>
        <tr><th>予約ID</th><th>予約日</th><th>レンジ予約</th><th>レンタルクラブ</th><th>シャワー利用</th><th>変更・キャンセル</th></tr>
      </thead>
      <tbody>
        @if (! $reserved->isEmpty())
          @foreach ($reserved as $reserve)
            <tr>
              <td>{{ $reserve->id}}</td>
              <td>{{ \Carbon\Carbon::parse($reserve->reserve_date)->isoFormat('M月D日(ddd)') }}</td>
              <td>
                <div>
                  <p>{{ $reserve->drivingRange->name }}</p>
                  <p>{{ substr($reserve->start_time,0,5) }} ー {{ substr($reserve->end_time,0,5) }}</p>
                </div>
              </td>
              <td>
                @if (! is_null($reserve->reserveRental))
                  <div>
                    <p>{{ $reserve->reserveRental->rental->brand }}</p>
                    <p>{{ $reserve->reserveRental->rental->model }}</p>
                  </div>
                @else
                  利用しない
                @endif
              </td>
              <td>
                @if(! is_null($reserve->reserveShower))
                  {{ substr($reserve->reserveShower->shower_time,0,5) }}
                @else
                  利用しない
                @endif
              </td>
              <td>
                @if ($reserve->reserve_date === \Carbon\Carbon::today()->format('Y-m-d') &&
                  (\Carbon\Carbon::parse($reserve->start_time)->diffInMinutes(\Carbon\Carbon::now())) < \Constant::CHANGEABLE_TIME)
                  ご利用中
                @else
                  <form action="{{ route('user.mypage.edit', ['id' => $reserve->id] ) }}" method="get">
                    <button class="form-btn">変更する</button>
                    <input type="hidden" name="search_date" value="{{ $reserve->reserve_date }}">
                  </form>
                  <form action="{{ route('user.mypage.cancel.confirm', ['id' => $reserve->id]) }}" method="get">
                    <button type="submit" class="form-btn cancel">キャンセル</button>
                  </form>
                @endif
              </td>
            </tr>
          @endforeach
        @else
          <tr>
            <td colspan="6">変更可能なご予約はございません</td>
          </tr>
        @endif
      </tbody>
    </table>
  </x-reserve-back>
</x-layout>