@props([
  'messages',
  'type' => '',
  ])

@if (isset($messages) && $type === "reserve")
  @foreach ($messages as $message)
    <small>{{ $message }}</small>
  @endforeach
@else
  @foreach ($messages as $message)
    <span class='error-msg'>{{ $message }}</span>
  @endforeach
@endif