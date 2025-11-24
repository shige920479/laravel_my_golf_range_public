
<div class="site-visual">
  <img src="{{ asset('images/scotland.jpg') }}" alt="" />
  <h1 class="site-title">{{ $h1Title }}</h1>
</div>
<div class="wrapper">
  <ul class="step-bar">
    <li class="item @if ($step === "1") is-current  @endif">STEP.1 仮登録</li>
    <li class="item @if ($step === "2") is-current  @endif">STEP.2 本登録</li>
    <li class="item @if ($step === "3") is-current  @endif">STEP.3 完了</li>
  </ul>
  <h2 class="form-title">{{ $h2Title }}</h2>
  <p @if ($step === "3") class="complete-msg" @endif>{{ $message }}
    @if (session('message'))
      <span class='error-msg'>{{ session('message') ?? '' }}</span></p>
    @endif
    {{ $slot }}
</div>

