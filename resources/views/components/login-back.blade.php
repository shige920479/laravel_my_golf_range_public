<div class="site-visual">
  <img src="{{ asset('/images/login_back.jpg') }}" alt="" />
  <h1 class="site-title">{{ $h1Title }}</h1>
</div>
<div class="wrapper">
  <h2 class="form-title">{{ $h2Title }}</h2>
  <p>{{ $message }}</p>
  {{ $slot }}
</div>