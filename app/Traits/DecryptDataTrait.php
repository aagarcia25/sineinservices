<?php

namespace App\Traits;

use Illuminate\Contracts\Encryption\DecryptException;

trait DecryptDataTrait
{

    public function decryptData($encryptedData)
    {
        try {
            $decryptedData = base64_decode($encryptedData);
            $this->logInfo($decryptedData, __METHOD__, __LINE__);
            return $decryptedData;
        } catch (DecryptException $e) {
            $this->logInfo($e, __METHOD__, __LINE__);
            throw new \Exception('Error al desencriptar los datos', 500);
        }
    }

    public function encryptData($encryptedData)
    {
        try {
            $decryptedData = base64_encode($encryptedData);
            return $decryptedData;
        } catch (DecryptException $e) {
            $this->logInfo($e, __METHOD__, __LINE__);
            throw new \Exception('Error al desencriptar los datos', 500);
        }
    }
}
