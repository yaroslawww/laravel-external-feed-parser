<?php

namespace ExternalFeedParser\Contracts;

use ExternalFeedParser\Entity\ExternalEntity;

interface Converter
{
    public function convert($data): ?ExternalEntity;
}
