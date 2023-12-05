<?php

namespace App\Exceptions;

use App\Traits\DecryptDataTrait;
use Illuminate\Validation\ValidationException;

class ThrottleException extends ValidationException
{
 use DecryptDataTrait;

 /**
  * Convert the exception to a JSON response.
  *
  * @return \Illuminate\Http\JsonResponse
  */
 public function render()
 {
  return response()->json(
   $this->encryptData(json_encode(
    [
     'NUMCODE' => 0,
     'STRMESSAGE' => 'Se ha Bloqueado el acceso por 10 minutos',
     'RESPONSE' => '',
     'SUCCESS' => false,
    ])));

 }
}
