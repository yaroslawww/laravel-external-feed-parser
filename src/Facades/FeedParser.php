<?php

namespace ExternalFeedParser\Facades;

use Illuminate\Support\Facades\Facade;

class FeedParser extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'external-feed-parser';
    }
}
