<?php

namespace ExternalFeedParser\Tests;

use ExternalFeedParser\Converters\SimpleConverter;
use ExternalFeedParser\Entity\ExternalEntity;
use Illuminate\Support\Str;
use InvalidArgumentException;

class SimpleConverterTest extends TestCase
{
    /** @test */
    public function expect_exception_if_wrong_class()
    {
        $class = Str::class;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("External Entity has wrong class [{$class}].");

        new SimpleConverter($class);
    }

    /** @test */
    public function default_entity_if_no_specified()
    {
        $converter = new SimpleConverter();

        $this->assertInstanceOf(ExternalEntity::class, $converter->convert([]));
    }
}
