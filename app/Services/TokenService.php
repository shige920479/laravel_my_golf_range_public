<?php
namespace App\Services;

use App\Models\TempUser;
use Carbon\Carbon;

class TokenService
{
  public static function checkToken($token)
  {
      return TempUser::where('secret_key', $token)
      ->where('created_at', '>', Carbon::now()->subMinutes(60*24))
      ->first();
  }
}