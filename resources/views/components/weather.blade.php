@if(!empty($weatherInfo))
  @foreach($weatherInfo as $data)
    <div class="weather-box">
      <div class="time sm"><?= Carbon\Carbon::parse($data['dt'])->format('H:i');?></div>
      <div class="icon"><img src="{{ asset('https://openweathermap.org/img/wn/' . $data['weather'][0]['icon'] . '@2x.png')}}" alt="" /></div>
      <div class="temp_max sm"><?= round($data['main']['temp']) . '℃';?></div>
    </div>
  @endforeach
@endif
