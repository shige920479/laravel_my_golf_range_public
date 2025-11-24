@if(Auth::guard('users')->check() && session('reservation'))
  <form id="session-form" action="{{ route('user.clearSession')}}" method="post">
    @csrf
    <input type="hidden" name="route" id="route-input">
    <ul>
      <li class="nav-items"><button type="button" class="has-session" data-route="home">トップページ</button></li>
      <li class="nav-items"><button type="button" class="has-session" data-route="showPrice">ご利用料金</button></li>
      <li class="nav-items"><button type="button" class="has-session" data-route="user.reserve.create">予約・マイページ</button></li>
      <li class="nav-items"><button type="button" class="has-session" data-route="user.mypage.index">予約確認・変更</button></li>
    </ul>
  </form>
@elseif (Auth::guard('users')->check())
  <ul>
    <li class="nav-items"><a href="{{ route('home') }}">トップページ</a></li>
    <li class="nav-items"><a href="{{ route('showPrice') }}">ご利用料金</a></li>
    <li class="nav-items"><a href="{{ route('user.loginForm')}}">予約・マイページ</a></li>
    <li class="nav-items"><a href="{{ route('user.mypage.index')}}">予約確認・変更</a></li>
  </ul>
@elseif (session('registration_data'))
  <form id="session-form" action="{{ route('user.clearSession')}}" method="post">
    @csrf
    <input type="hidden" name="route" id="route-input">
    <ul>
      <li class="nav-items"><button type="button" class="has-session" data-route="home">トップページ</button></li>
      <li class="nav-items"><button type="button" class="has-session" data-route="showPrice">ご利用料金</button></li>
      <li class="nav-items"><button type="button" class="has-session" data-route="user.temporary.create">会員登録</button></li>
      <li class="nav-items"><button type="button" class="has-session" data-route="user.loginForm">予約・マイページ</button></li>
      <li class="nav-items"><a href="#">アクセス</a></li>
    </ul>
  </form>
@else
  <ul>
    <li class="nav-items"><a href="{{ route('home') }}">トップページ</a></li>
    <li class="nav-items"><a href="{{ route('showPrice') }}">ご利用料金</a></li>
    <li class="nav-items"><a href="{{ route('user.temporary.create') }}">会員登録</a></li>
    <li class="nav-items"><a href="{{ route('user.loginForm')}}">予約・マイページ</a></li>
    <li class="nav-items"><a href="#">アクセス</a></li>
  </ul>
@endif

