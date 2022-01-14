<?php

namespace ExternalFeedParser\Contracts;

use ExternalFeedParser\Entity\ExternalEntitiesCollection;

interface Provider
{
    public function parse(): ExternalEntitiesCollection;
}
