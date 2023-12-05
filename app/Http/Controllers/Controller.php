<?php

namespace App\Http\Controllers;

use App\Traits\DecryptDataTrait;
use App\Traits\LoggableTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;
    use LoggableTrait;
    use DecryptDataTrait;
}
