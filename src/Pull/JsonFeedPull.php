<?php

namespace ExternalFeedParser\Pull;

use ExternalFeedParser\Contracts\PullProcessor;
use Illuminate\Support\Collection;

class JsonFeedPull implements PullProcessor
{
    use HasPendingRequest;

    public function __construct(
        protected string  $url,
        protected ?string $listingKey = null,
        array             $args = [],
    ) {
        $this->args = collect($args);
    }


    public function pull(): Collection
    {
        $response = $this->preparePendingRequest()->get($this->url);

        $data = $response->json($this->listingKey, []);

        return collect($data);
    }
}
