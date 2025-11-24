@props(['messages'])

@if ($messages)
  @foreach ($messages as $message)
    <small>{{ $message }}</small>
  @endforeach
@endif