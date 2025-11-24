@php
  $routeName = request()->route()->getName();
  if(Str::startsWith($routeName, 'user.reserve.')) {
    $route = 'reserve';
  } elseif(Str::startsWith($routeName, 'user.mypage.')) {
    $route = 'edit';
  }

@endphp

<div class="search-date">
  <p class="select-title">空き状況確認</p>
  @if ($route === 'reserve')
    <form action="{{ route('user.reserve.create') }}" method="get">
  @elseif ($route === 'edit')
    <form action="{{ route('user.mypage.edit', ['id' => $id ]) }}" method="get">
  @endif
    <select name="search_date">
      <option value="{{ $refDate->format('Y-m-d') }}">
        {{ $refDate->copy()->isoFormat('MM月DD日(ddd)') }}
      </option>
      @for ($i = 1; $i < \Constant::MAX_RESERVE_DATE; $i++)
        <option value="{{ $refDate->copy()->addDay($i)->format('Y-m-d') }}"
          @if ($searchDate !== null && $refDate->copy()->addDay($i)->format('Y-m-d') === $searchDate) selected @endif >
          {{ $refDate->copy()->addDay($i)->isoFormat('MM月DD日(ddd)') }}
        </option>
      @endfor
    </select>
    <button type="submit" class="form-btn">検索</button> 
  </form>
</div>