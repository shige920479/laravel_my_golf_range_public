<?php
namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WeatherService
{
  public static function getWeatherForDate(string $searchDate)
  {
    $date = Carbon::parse($searchDate)->format('Y-m-d');

    $cacheKey = "weather_{$date}";

    return Cache::remember($cacheKey, now()->addHours(3), function () use ($date) {
      return self::fetchAndFilter($date);
    });
  }

  protected static function fetchAndFilter(string $date)
  {
    $apiKey = env('OW_API_KEY');
    $cityId = 1859740; //川越市
    $apiUrl = "https://api.openweathermap.org/data/2.5/forecast";

    $response = Http::get($apiUrl, [
      'id' => $cityId,
      'appid' => $apiKey,
      'lang' => 'ja',
      'units' => 'metric'
    ]);

    if ($response->failed()) {
      return null;
    }

    $json = $response->json();

    if (! isset($json['list'])) {
      return null;
    }

    return collect($json['list'])
      ->filter(function ($item) use ($date) {
        $dt = Carbon::parse($item['dt']);
        return $dt->format('Y-m-d') === $date &&
              in_array($dt->format('H'), ['09', '12', '15', '18', '21']);
      })
      ->values()
      ->toArray();
  }
}