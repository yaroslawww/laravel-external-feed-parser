<?php

namespace ExternalFeedParser\Providers;

use ExternalFeedParser\Contracts\Converter;
use ExternalFeedParser\Contracts\Provider;
use ExternalFeedParser\Contracts\PullProcessor;
use ExternalFeedParser\Entity\ExternalEntitiesCollection;

class FeedProvider implements Provider
{
    public function __construct(
        protected PullProcessor $pullProcessor,
        protected Converter     $converter,
    ) {
    }

    public function parse(): ExternalEntitiesCollection
    {
        $collection = ExternalEntitiesCollection::make();

        $this->pullProcessor->pull()
                            ->each(function ($item) use ($collection) {
                                $externalEntity = $this->converter->convert($item);
                                if ($externalEntity) {
                                    $collection->add($externalEntity);
                                }
                            });

        return $collection;
    }
}
