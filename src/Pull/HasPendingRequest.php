<?php

namespace ExternalFeedParser\Pull;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

trait HasPendingRequest
{
    protected Collection $args;

    protected function preparePendingRequest(): PendingRequest
    {
        $pendingRequest = Http::timeout((int) $this->args->get('timeout', 20));
        if (
            ($headers = $this->args->get('headers'))
            && is_array($headers)
        ) {
            $pendingRequest->withHeaders($headers);
        }

        return $pendingRequest;
    }
}
