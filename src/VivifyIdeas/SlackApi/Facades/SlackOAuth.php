<?php

namespace VivifyIdeas\SlackApi\Facades;

use Illuminate\Support\Facades\Facade;

class SlackOAuth extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'slack.oauth';
    }
}
