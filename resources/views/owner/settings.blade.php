<x-owner-layout>
  <section id="pricing-sec">
  <div class="setting-title">
    <p>ドライビングレンジ料金設定
    @if(session('success-rangeFee')) 
      <span class="success">{{ session('success-rangeFee') }}<span>
    @endif
    </p>
    <a href="{{ route('owner.settings.rangeFeeForm') }}">登録</a>
  </div>
  <table class="form-table setting">
    <thead>
      <tr>
        <th colspan="5">&nbsp;</th>
        <th colspan="2" class="ta-c">現行料金</th>
        <th colspan="2" class="ta-c">改定予定
          <span>@if (count($rangeFee) > 1) {{ $rangeFee[0]->effective_date }} @endif</span>
        </th>
      </tr>
      <tr>
        <th colspan="4">&nbsp;</th>
        <th class="ta-c">単位</th>
        <th class="ta-c">平日料金</th>
        <th class="ta-c">休日料金</th>
        <th class="ta-c">平日料金</th>
        <th class="ta-c">休日料金</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td rowspan="2" colspan="2">ドライビングレンジ</td>
        <td colspan="2">レンジチャージ</td>
        <td class="ta-c">円/人</td>
        <td class="ta-c">@if(count($rangeFee) > 1) {{ $rangeFee[1]->entrance_fee }}円 @elseif(count($rangeFee) === 1) {{ $rangeFee[0]->entrance_fee }}円 @else 設定なし @endif</td>
        <td class="ta-c">@if(count($rangeFee) > 1) {{ $rangeFee[1]->entrance_fee }}円 @elseif(count($rangeFee) === 1) {{ $rangeFee[0]->entrance_fee }}円 @else 設定なし @endif</td>
        <td class="ta-c">@if(count($rangeFee) > 1) {{ $rangeFee[0]->entrance_fee }}円 @else 設定なし @endif</td>
        <td class="ta-c">@if(count($rangeFee) > 1) {{ $rangeFee[0]->entrance_fee }}円 @else 設定なし @endif</td>
      </tr>
      <tr>
        <td colspan="2">時間料金</td>
        <td class="ta-c">円/人</td>
        <td class="ta-c">@if(count($rangeFee) > 1) {{ $rangeFee[1]->weekday_fee }}円 @elseif(count($rangeFee) === 0) {{ $rangeFee[0]->weekday_fee }} @else 設定なし @endif</td>
        <td class="ta-c">@if(count($rangeFee) > 1) {{ $rangeFee[1]->holiday_fee }}円 @elseif(count($rangeFee) === 0) {{ $rangeFee[0]->weekday_fee }} @else 設定なし @endif</td>
        <td class="ta-c">@if(count($rangeFee) > 1) {{ $rangeFee[0]->weekday_fee }}円 @else 設定なし @endif</td>
        <td class="ta-c">@if(count($rangeFee) > 1) {{ $rangeFee[0]->holiday_fee }}円 @else 設定なし @endif</td>
      </tr>
    </tbody>
  </table>
</section>
<section id="rental-sec">
  <p class="setting-title">オプション料金設定
    @if(session('success-optionFee')) 
      <span class="success">{{ session('success-optionFee') }}<span>
    @endif
  </p>
  <table class="form-table setting">
    <thead>
      <tr>
        <th colspan="5">&nbsp;</th>
        <th colspan="2" class="ta-c">現行料金</th>
        <th colspan="2" class="ta-c">改定予定
          <span>@if (count($rentalFee) > 1) {{ $rentalFee[0]->effective_date }} @endif</span>
        </th>
      </tr>
      <tr>
        <th colspan="1">メーカー</th>
        <th colspan="4">モデル</th>
        <th colspan="2" class="ta-c">料金/H</th>
        <th colspan="2" class="ta-c">料金/H</th>
      </tr>
    </thead>
    <tbody>
      @foreach($rentalClubs as $index => $club)
        <tr>
          <td colspan="1">{{ $club->brand }}</td>
          <td colspan="4">{{ $club->model}}</td>
          <td colspan="2" class="ta-c">@if(count($rentalFee) > 1) {{ $rentalFee[1]->rental_fee }}円 @elseif(count($rentalFee) === 1) {{ $rentalFee[0]->rental_fee }} @else 設定なし @endif</td>
          <td colspan="1" class="ta-c">@if(count($rentalFee) > 1) {{ $rentalFee[0]->rental_fee }}円 @else 設定なし @endif</td>
          @if($index === 0)
            <td colspan="1" rowspan="2" class="ta-c"><a href="{{ route('owner.settings.rentalFeeForm') }}">登録</a></td>
          @endif
        </tr>
      @endforeach
      <tr>
        <td colspan="5">シャワー利用</td>
        <td colspan="2" class="ta-c">@if(count($showerFee) > 1) {{ $showerFee[1]->shower_fee }}円 @elseif(count($showerFee) === 0) {{ $showerFee[0]->shower_fee }} @else 設定なし @endif</td>
        <td colspan="1" class="ta-c">@if(count($showerFee) > 1) {{ $showerFee[0]->shower_fee }}円 @else 設定なし @endif</td>
        <td colspan="1" class="ta-c"><a href="{{ route('owner.settings.showerFeeForm') }}">登録</a></td>
      </tr>
    </tbody>
  </table>
</section>
<section id="mainte-sec">
  <p class="setting-title">メンテナンス日設定
    @if(session('success-mainte')) 
      <span class="success">{{ session('success-mainte') }}<span>
    @endif
  </p>
  <table class="form-table setting">
    <thead>
      <tr>
        <th colspan="7">&nbsp;</th>
        <th colspan="1" class="ta-c">設定日</th>
        <th colspan="1" class="ta-c">登録リンク</th>
      </tr>
    </thead>
    <tbody>
      @foreach($maintes as $index => $mainte)
        @if($mainte->category === 'drivingRange')
          @if($index === 0)
            <tr>
              <td rowspan="3" colspan="2">ドライビングレンジ</td>
              <td colspan="5">{{ $mainte->name }}</td>
              <td colspan="1" class="ta-c">{{ $mainte->mainte_date ?? "予定なし" }}</td>
              <td colspan="1" class="ta-c">
                <a href="{{ route('owner.settings.MainteForm',['type' => 'drivingRange', 'id' => $mainte->id]) }}">登録</a>
              </td>
            </tr>
          @else
            <tr>
              <td colspan="5">{{ $mainte->name }}</td>
              <td colspan="1" class="ta-c">{{ $mainte->mainte_date ?? "予定なし" }}</td>
              <td colspan="1" class="ta-c"><a href="{{ route('owner.settings.MainteForm',['type' => $mainte->category, 'id' => $mainte->id]) }}">登録</a></td>
            </tr>
          @endif
        @elseif($mainte->category === 'rental')
          @if($index === 3)
            <tr>
              <td rowspan="2" colspan="2">レンタルクラブ</td>
              <td colspan="1">{{ $mainte->brand }}</td>
              <td colspan="4">{{ $mainte->model }}</td>
              <td colspan="1" class="ta-c">{{ $mainte->mainte_date ?? "予定なし" }}</td>
              <td colspan="1" class="ta-c"><a href="{{ route('owner.settings.MainteForm',['type' => $mainte->category, 'id' => $mainte->id]) }}">登録</a></td>
            </tr>
          @else
              <td colspan="1">{{ $mainte->brand }}</td>
              <td colspan="4">{{ $mainte->model }}</td>
              <td colspan="1" class="ta-c">{{ $mainte->mainte_date ?? "予定なし" }}</td>
              <td colspan="1" class="ta-c"><a href="{{ route('owner.settings.MainteForm',['type' => $mainte->category, 'id' => $mainte->id]) }}">登録</a></td>
          @endif
        @elseif($mainte->category === 'shower')
          <tr>
          <td colspan="7">シャワールーム</td>
          <td colspan="1" class="ta-c">{{ $mainte->mainte_date ?? "予定なし" }}</td>
          <td colspan="1" class="ta-c"><a href="{{ route('owner.settings.MainteForm',['type' => $mainte->category, 'id' => $mainte->id]) }}">登録</a></td>
          </tr>
        @endif
      @endforeach
    </tbody>
  </table>
</section>
</x-owner-layout>