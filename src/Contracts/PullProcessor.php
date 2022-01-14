<?php

namespace ExternalFeedParser\Contracts;

use Illuminate\Support\Collection;

interface PullProcessor
{
    public function pull(): Collection;
}
