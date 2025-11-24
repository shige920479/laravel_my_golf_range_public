<div id="ranage-info">
  <p class="select-title">ドライビングレンジ</p>
  <table class="range-table">
    <tbody>
      <tr>
        <th class="range-num" colspan="6">Range1</th>
        <td colspan="22">&nbsp;</td> 
      </tr>
      <tr class="time">
        @for ($time = $openTime->copy(); $time < $closeTime; $time->addHours(1))
          <td colspan="2"><?= $time->format('H:i');?></td>
        @endfor
      </tr>
      <tr class="time-zone">
        @for ($time = $openTime->copy(); $time < $closeTime; $time->addMinutes(30))
            @if($allData['driving_ranges_1'][0]->mainte_date === $searchDate)
              <td class="reserve-col">&nbsp;</td>
            @else
              @php
                $isReserveOwn = $allData['driving_ranges_1']->filter(fn($reserve) =>
                $reserve->start_time <= $time->format('H:i:s') && $time->format('H:i:s') < $reserve->end_time && $reserve->user_id === Auth::id());
                $isReserve = $allData['driving_ranges_1']->filter(fn($reserve) =>
                $reserve->start_time <= $time->format('H:i:s') && $time->format('H:i:s') < $reserve->end_time && $reserve->user_id !== Auth::id());
              @endphp
              @if(! $isReserveOwn->isEmpty())
                 <td class="reserve-col-own">&nbsp;</td>
              @elseif(! $isReserve->isEmpty())
                <td class="reserve-col">&nbsp;</td>
              @else
                <td>&nbsp;</td>
              @endif
            @endif
        @endfor
      </tr>
    </tbody>
  </table>
  <table class="range-table">
    <tbody>
      <tr>
        <th class="range-num" colspan="6">Range2</th>
        <td colspan="22">&nbsp;</td> 
      </tr>
      <tr class="time">
        @for ($time = $openTime->copy(); $time < $closeTime; $time->addHours(1))
          <td colspan="2"><?= $time->format('H:i');?></td>
        @endfor
      </tr>
      <tr class="time-zone">
        @for ($time = $openTime->copy(); $time < $closeTime; $time->addMinutes(30))
            @if($allData['driving_ranges_2'][0]->mainte_date === $searchDate)
              <td class="reserve-col">&nbsp;</td>
            @else
              @php
                $isReserveOwn = $allData['driving_ranges_2']->filter(fn($reserve) =>
                $reserve->start_time <= $time->format('H:i:s') && $time->format('H:i:s') < $reserve->end_time && $reserve->user_id === Auth::id());
                $isReserve = $allData['driving_ranges_2']->filter(fn($reserve) =>
                $reserve->start_time <= $time->format('H:i:s') && $time->format('H:i:s') < $reserve->end_time && $reserve->user_id !== Auth::id());
              @endphp
              @if(! $isReserveOwn->isEmpty())
                 <td class="reserve-col-own">&nbsp;</td>
              @elseif(! $isReserve->isEmpty())
                <td class="reserve-col">&nbsp;</td>
              @else
                <td>&nbsp;</td>
              @endif
            @endif
        @endfor
      </tr>
    </tbody>
  </table>
  <table class="range-table">
    <tbody>
      <tr>
        <th class="range-num" colspan="6">Range3</th>
        <td colspan="22">&nbsp;</td> 
      </tr>
      <tr class="time">
        @for ($time = $openTime->copy(); $time < $closeTime; $time->addHours(1))
          <td colspan="2"><?= $time->format('H:i');?></td>
        @endfor
      </tr>
      <tr class="time-zone">
        @for ($time = $openTime->copy(); $time < $closeTime; $time->addMinutes(30))
            @if($allData['driving_ranges_3'][0]->mainte_date === $searchDate)
              <td class="reserve-col">&nbsp;</td>
            @else
              @php
                $isReserveOwn = $allData['driving_ranges_3']->filter(fn($reserve) =>
                $reserve->start_time <= $time->format('H:i:s') && $time->format('H:i:s') < $reserve->end_time && $reserve->user_id === Auth::id());
                $isReserve = $allData['driving_ranges_3']->filter(fn($reserve) =>
                $reserve->start_time <= $time->format('H:i:s') && $time->format('H:i:s') < $reserve->end_time && $reserve->user_id !== Auth::id());
              @endphp
              @if(! $isReserveOwn->isEmpty())
                 <td class="reserve-col-own">&nbsp;</td>
              @elseif(! $isReserve->isEmpty())
                <td class="reserve-col">&nbsp;</td>
              @else
                <td>&nbsp;</td>
              @endif
            @endif
        @endfor
      </tr>
    </tbody>
  </table>
</div>
<div id="option-info">
  <p class="select-title">レンタルクラブ / シャワールーム</p>
  <table class="range-table">
    <tbody>
      <tr>
        <th class="range-num" colspan="6">レンタルクラブ1</th>
        <td colspan="22">{{ $allData['rentals_1'][0]->facility_name }}</td>
      </tr>
      <tr class="time">
        @for ($time = $openTime->copy(); $time < $closeTime; $time->addHours(1))
          <td colspan="2"><?= $time->format('H:i');?></td>
        @endfor
      </tr>
      <tr class="time-zone">
        @for ($time = $openTime->copy(); $time < $closeTime; $time->addMinutes(30))
            @if($allData['rentals_1'][0]->mainte_date === $searchDate)
              <td class="reserve-col">&nbsp;</td>
            @else
              @php
                $isReserveOwn = $allData['rentals_1']->filter(fn($reserve) =>
                $reserve->start_time <= $time->format('H:i:s') && $time->format('H:i:s') < $reserve->end_time && $reserve->user_id === Auth::id());
                $isReserve = $allData['rentals_1']->filter(fn($reserve) =>
                $reserve->start_time <= $time->format('H:i:s') && $time->format('H:i:s') < $reserve->end_time && $reserve->user_id !== Auth::id());
              @endphp
              @if(! $isReserveOwn->isEmpty())
                  <td class="reserve-col-own">&nbsp;</td>
              @elseif(! $isReserve->isEmpty())
                <td class="reserve-col">&nbsp;</td>
              @else
                <td>&nbsp;</td>
              @endif
            @endif
        @endfor
      </tr>
    </tbody>
  </table>
  <table class="range-table">
    <tbody>
      <tr>
        <th class="range-num" colspan="6">レンタルクラブ2</th>
        <td colspan="22">{{ $allData['rentals_2'][0]->facility_name }}</td>
      </tr>
      <tr class="time">
        @for ($time = $openTime->copy(); $time < $closeTime; $time->addHours(1))
          <td colspan="2"><?= $time->format('H:i');?></td>
        @endfor
      </tr>
      <tr class="time-zone">
        @for ($time = $openTime->copy(); $time < $closeTime; $time->addMinutes(30))
            @if($allData['rentals_2'][0]->mainte_date === $searchDate)
              <td class="reserve-col">&nbsp;</td>
            @else
              @php
                $isReserveOwn = $allData['rentals_2']->filter(fn($reserve) =>
                $reserve->start_time <= $time->format('H:i:s') && $time->format('H:i:s') < $reserve->end_time && $reserve->user_id === Auth::id());
                $isReserve = $allData['rentals_2']->filter(fn($reserve) =>
                $reserve->start_time <= $time->format('H:i:s') && $time->format('H:i:s') < $reserve->end_time && $reserve->user_id !== Auth::id());
              @endphp
              @if(! $isReserveOwn->isEmpty())
                  <td class="reserve-col-own">&nbsp;</td>
              @elseif(! $isReserve->isEmpty())
                <td class="reserve-col">&nbsp;</td>
              @else
                <td>&nbsp;</td>
              @endif
            @endif
        @endfor
      </tr>
    </tbody>
  </table>
  <table class="range-table">
    <tbody>
      <tr>
        <th class="range-num" colspan="6">{{ $allData['showers_1'][0]->facility_name }}</th>
        <td colspan="22"></td>
      </tr>
      <tr class="time">
        @for ($time = $openTime->copy(); $time < $closeTime; $time->addHours(1))
          <td colspan="2"><?= $time->format('H:i');?></td>
        @endfor
      </tr>
      <tr class="time-zone">
        @for ($time = $openTime->copy(); $time < $closeTime; $time->addMinutes(30))
            @if($allData['showers_1'][0]->mainte_date === $searchDate)
              <td class="reserve-col">&nbsp;</td>
            @else
              @php
                $isReserveOwn = $allData['showers_1']->filter(fn($reserve) =>
                $reserve->start_time === $time->format('H:i:s') && $reserve->user_id === Auth::id());
                $isReserve = $allData['showers_1']->filter(fn($reserve) =>
                $reserve->start_time === $time->format('H:i:s') && $reserve->user_id !== Auth::id());
              @endphp
              @if(! $isReserveOwn->isEmpty())
                  <td class="reserve-col-own">&nbsp;</td>
              @elseif(! $isReserve->isEmpty())
                <td class="reserve-col">&nbsp;</td>
              @else
                <td>&nbsp;</td>
              @endif
            @endif
        @endfor
      </tr>
    </tbody>
  </table>
</div>