<?php

namespace App\Http\Controllers;

use App\Http\Traits\AuthorizesActions;
use App\Http\Traits\AuthorizesOwnership;

abstract class Controller extends \Illuminate\Routing\Controller
{
    use AuthorizesActions;
    use AuthorizesOwnership;
}
