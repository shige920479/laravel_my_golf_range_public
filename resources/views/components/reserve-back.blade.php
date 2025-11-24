@php

  $routeName = request()->route()->getName();

  if(Str::startsWith($routeName, 'user.reserve.')) {
    $imagePath = asset('/images/red_ball.jpg');
  } elseif(Str::startsWith($routeName, 'user.mypage.')) {
    $imagePath = asset('/images/login_back.jpg');
  } elseif($routeName === 'showPrice') {
    $imagePath = asset('images/golf_chair.jpg');
  }
  
  if($routeName === 'user.reserve.create' || $routeName === 'user.mypage.edit') {
    $reserveFlex = true;
  } else {
    $reserveFlex = false;
  }
  
$isClass = Str::afterLast($routeName, '.') === 'complete' ? true : false;

@endphp

<section class="site-visual reserve">
  <img src="{{ $imagePath }}" alt="" />
  <h1 class="site-title">{{ $h1Title }}</h1>
</section>
<section class="wrapper">
  @if($reserveFlex) 
    <div id="reserve-flex">
      {{ $slot }} 
    </div>
  @else
    <h2 class="form-title">{{ $h2Title }}</h2>
    <p @if ($isClass) id="complete-msg" @endif>{{ $message }}</p>
    {{ $slot }}
  @endif
</section>
