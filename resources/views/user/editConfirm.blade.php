<x-layout>
  <x-reserve-back h1Title="予約変更内容のご確認" h2Title="変更内容"
    message="下記の内容にて変更登録します。宜しければ登録ボタンをクリックしてください">
    <form action="{{ route('user.mypage.send', ['id' => $id]) }}" method="post">
      @csrf

      <table class="form-table reserve-confirm">
        <tbody>
          <tr>
            <th>ご利用日時</th>
            <td>{{ \Carbon\Carbon::parse($reservation['reserve_date'])->isoFormat('MM月DD日(ddd)') }}</td>
          </tr>
          <tr>
            <th>レンジ名</th>
            <td>{{ $rangeName }}<x-input-error :messages="$errors->get('start_time')" /></td>
            
          </tr>
          <tr>
            <th>ご利用時間</th>
            <td>{{ substr($reservation['start_time'],0,5) }} ～ {{ substr($reservation['end_time'],0,5) }}</td>
          </tr>
          <tr>
            <th>オプションのご利用</th>
            <td>
              @if (! empty($reservation['rental']))
                {{ $rental }}
                <x-input-error :messages="$errors->get('start_time')" />
              @else
                利用しない
              @endif
            </td>
          </tr>
          <tr>
            <th>シャワー室のご利用</th>
            <td>
              @if (! empty($reservation['shower']))
              {{ substr($reservation['shower_time'],0,5) }}
              <x-input-error :messages="$errors->get('start_time')" />
              @else
                利用しない
              @endif
            </td>
          </tr>
          <tr>
            <th>ご利用料金</th>
            <td>
              <div class="table">
                <div class="table-row">
                  <div class="table-cell">入場料金</div>
                  <div class="table-cell">{{ $reservation['number'] }}名様</div>
                  <div class="table-cell fee" data-fee="{{ session('reservation.entrance_fee') }}">{{ number_format(session('reservation.entrance_fee')) }}円</div>
                </div>
                <div class="table-row">
                  <div class="table-cell">レンジ使用料金</div>
                  <div class="table-cell">{{ \Carbon\Carbon::parse($reservation['start_time'])->floatDiffInHours($reservation['end_time']) }}時間</div>
                  <div class="table-cell fee" data-fee="{{ session('reservation.range_fee') }}">{{ number_format(session('reservation.range_fee')) }}円</div>
                </div>
                @if (! is_null($rental) && ! is_null($reservation['rental_id']))
                <div class="table-row">
                  <div class="table-cell">レンタルクラブ料金</div>
                  <div class="table-cell">{{ \Carbon\Carbon::parse($reservation['start_time'])->floatDiffInHours($reservation['end_time']) }}時間</div>
                  <div class="table-cell fee" data-fee="{{ session('reservation.rental_fee') }}">{{ number_format(session('reservation.rental_fee')) }}円</div>
                </div>                  
                @endif
                @if (! is_null($reservation['shower_time']))
                <div class="table-row">
                  <div class="table-cell">シャワー利用料金</div>
                  <div class="table-cell">&nbsp;</div>
                  <div class="table-cell fee" data-fee="{{ session('reservation.shower_fee') }}">{{ number_format(session('reservation.shower_fee')) }}円</div>
                </div>          
                @endif
                <div class="table-row">
                  <div class="table-cell">ご利用料金合計</div>
                  <div class="table-cell">&nbsp;</div>
                  <div class="table-cell" id="total-fee"></div>
                </div>
              </div>
          </tr>
        </tbody>
      </table>
      <div id="btn-flex">
        <a href="{{ route('user.mypage.edit', [
        'id' => $id, 'search_date' => session('reservation.search_date')]) }}">入力内容を訂正する</a>
        <button type="submit" class="form-btn reserve">登録する</button>
      </div>
    </form>
    
  </x-reserve-back>
</x-layout>