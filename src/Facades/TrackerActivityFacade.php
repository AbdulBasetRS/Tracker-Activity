<?php

namespace Abdulbaset\TrackerActivity\Facades;

use Illuminate\Support\Facades\Facade;

class TrackerActivityFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tracker-activity';
    }
}
