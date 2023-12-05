<?php

namespace App\Traits;

trait LoggableTrait
{
    public function logInfo($message, $metodo, $line)
    {
        info($message, [
            'method' =>  $metodo ,
            'line' => $line  ,
        ]);
    }
}