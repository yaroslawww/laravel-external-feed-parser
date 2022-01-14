<?php

namespace ExternalFeedParser\Converters;

use ExternalFeedParser\Contracts\Converter;
use ExternalFeedParser\Entity\ExternalEntity;
use InvalidArgumentException;

class SimpleConverter implements Converter
{
    public function __construct(
        protected ?string $entityClass = null
    ) {
        if ($entityClass && !is_a($entityClass, ExternalEntity::class, true)) {
            throw new InvalidArgumentException("External Entity has wrong class [{$entityClass}].");
        }
    }

    public function convert($data): ?ExternalEntity
    {
        if ($this->entityClass) {
            return new $this->entityClass((array) $data);
        }

        return new ExternalEntity((array) $data);
    }
}
