<?php

namespace ExternalFeedParser\Pull;

use ExternalFeedParser\Contracts\PullProcessor;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Mtownsend\XmlToArray\XmlToArray;

class XmlFeedPull implements PullProcessor
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

        $array = XmlToArray::convert($response->body());

        $data = $this->listingKey ? Arr::get($array, $this->listingKey, []) : $array;

        return collect($data);
    }
}
