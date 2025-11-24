<x-layout>
  <x-reserve-back h1Title="キャンセル内容のご確認" h2Title="予約キャンセル内容"
    message="※下記の予約をキャンセルします。宜しければキャンセルボタンをクリックしてください">
      <table class="form-table cancel-confirm">
        <tbody>
          <tr>
            <th>ご利用日時</th>
            <td>{{ $reserved->reserve_date }}</td>
          </tr>
          <tr>
            <th>レンジ名</th>
            <td>{{ $reserved->drivingRange->name }}</td>
          </tr>
          <tr>
            <th>ご利用時間</th>
            <td>{{ substr($reserved->start_time,0,5) }}<small> ～ </small>{{ substr($reserved->end_time,0,5) }}</td>
          </tr>
          <tr>
            <th>オプションのご利用</th>
            <td>
              @if(! is_null($reserved->reserveRental))
                {{ $reserved->reserveRental->rental->brand . ' / ' . $reserved->reserveRental->rental->model }}
              @else
                利用しない
              @endif
            </td>
          </tr>
          <tr>
            <th>シャワー室のご利用</th>
            <td>
              @if(! is_null($reserved->reserveShower))
                <?= substr($reserved->reserveShower->shower_time,0,5); ?>
              @else
                利用しない
              @endif
            </td>
          </tr>
        </tbody>
      </table>
      <div id="btn-flex">
        <a href="{{ route('user.mypage.index') }}">訂正する</a>
        <form action="{{ route('user.mypage.cancel.exec', ['id' => $reserved->id]) }}" method="post">
          @csrf
          <button type="submit" class="form-btn reserve">キャンセルする</button>
        </form>
      </div>
  </x-reserve-back>
</x-layout>