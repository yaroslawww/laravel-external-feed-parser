<?php

namespace ExternalFeedParser\Tests;

use ExternalFeedParser\Facades\FeedParser;
use Illuminate\Support\Str;
use InvalidArgumentException;

class FeedParseManagerTest extends TestCase
{
    /** @test */
    public function expect_exception_if_wrong_name()
    {
        $name = 'foo';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Feed parser provider [{$name}] is not defined.");

        FeedParser::provider($name);
    }

    /** @test */
    public function expect_exception_if_wrong_provider_class()
    {
        $class = Str::class;

        app()['config']->set('external-feed-parser.provider_class', $class);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Feed provider has wrong class [{$class}].");

        FeedParser::provider('xml_foo');
    }

    /** @test */
    public function expect_exception_if_wrong_pull_class()
    {
        $class = Str::class;

        app()['config']->set('external-feed-parser.jobs-feeds.xml_foo.pull.class', $class);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Pull processor has wrong class [{$class}].");

        FeedParser::provider('xml_foo');
    }

    /** @test */
    public function expect_exception_if_wrong_convert_class()
    {
        $class = Str::class;

        app()['config']->set('external-feed-parser.jobs-feeds.xml_foo.convert.class', $class);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Converter has wrong class [{$class}].");

        FeedParser::provider('xml_foo');
    }
}
