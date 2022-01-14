<?php

namespace ExternalFeedParser\Entity;

use Illuminate\Support\Arr;

/**
 * DTO class between package and app
 */
class ExternalEntity
{
    public function __construct(
        protected array $data = []
    ) {
    }

    public function get(string|null $key = null, mixed $default = null): mixed
    {
        if (is_null($key)) {
            return $this->data;
        }

        return Arr::get($this->data, $key, $default);
    }
}
