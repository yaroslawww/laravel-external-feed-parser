<?php

namespace ExternalFeedParser\Pull;

use ExternalFeedParser\Contracts\PullProcessor;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Mtownsend\XmlToArray\XmlToArray;

class XmlFeedPull implements PullProcessor
{
    public function __construct(
        protected string  $url,
        protected ?string $listingKey = null,
    ) {
    }


    public function pull(): Collection
    {
        $response = Http::get($this->url);

        $array = XmlToArray::convert($response->body());

        $data = $this->listingKey ? Arr::get($array, $this->listingKey, []) : $array;

        return collect($data);
    }
}
