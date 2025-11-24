<x-layout>
  <x-reserve-back h1Title="ご利用料金" h2Title="料金表" message="">
          <table class="price-table">
        <thead>
          <tr>
            <th>&nbsp;</th><th>&nbsp;</th><th class="txt-center">平日</th><th class="txt-center">土日</th>
          </tr>
        </thead>
        <tbody>
            <tr>
              <td rowspan="2">ドライビングレンジ</td>
              <td>入場料金（1人あたり）</td>
              <td class="txt-center" colspan="2">
                @if(count($rangeFee) > 1)
                  <p>{{ $rangeFee[1]->entrance_fee }}円</p>
                  <span class='e-date'>※ {{ date('n/d', strtotime($rangeFee[0]->effective_date)) . " ～ " . $rangeFee[0]->entrance_fee }}円</span>
                @else
                  <p>{{ $rangeFee[0]->entrance_fee }}円</p>
                @endif
              </td>
            </tr>
            <tr>
              <td>レンジ利用料金（/H）</td>
              <td class="txt-center">
                @if(count($rangeFee) > 1)
                  <p>{{ $rangeFee[1]->weekday_fee }}円</p>
                  <span class='e-date'>※ {{ date('n/d', strtotime($rangeFee[0]->effective_date)) . " ～ " . $rangeFee[0]->weekday_fee }}円</span>
                @else
                  <p>{{ $rangeFee[0]->weekday_fee }}円</p>
                @endif
              </td>
              <td class="txt-center">
                @if(count($rangeFee) > 1)
                  <p>{{ $rangeFee[1]->holiday_fee }}円</p>
                  <span class='e-date'>※ {{ date('n/d', strtotime($rangeFee[0]->effective_date)) . " ～ " . $rangeFee[0]->holiday_fee }}円</span>
                @else
                  <p>{{ $rangeFee[0]->holiday_fee }}円</p>
                @endif
              </td>
            </tr>
            <tr>
              <td>レンタルクラブ</td>
              <td>クラブ利用料金（/H）</td>
              <td class="txt-center" colspan="2">
                @if(count($rentalFee) > 1)
                  <p>{{ $rentalFee[1]->rental_fee }}円</p>
                  <span class='e-date'>※ {{ date('n/d', strtotime($rentalFee[0]->effective_date)) . " ～ " . $rentalFee[0]->rental_fee }}円</span>
                @else
                  <p>{{ $rentalFee[0]->rental_fee }}円</p>
                @endif
              </td>
            </tr>
            <tr>
              <td>シャワー</td>
              <td>25分/回</td>
              <td class="txt-center" colspan="2">
                @if(count($showerFee) > 1)
                  <p>{{ $showerFee[1]->shower_fee }}円</p>
                  <span class='e-date'>※ {{ date('n/d', strtotime($showerFee[0]->effective_date)) . " ～ " . $showerFee[0]->shower_fee }}円</span>
                @else
                  <p>{{ $showerFee[0]->shower_fee }}円</p>
                @endif
              </td>
            </tr>
        </tbody>
      </table>
  </x-reserve-back>
</x-layout>