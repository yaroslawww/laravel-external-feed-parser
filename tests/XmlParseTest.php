<?php

namespace ExternalFeedParser\Tests;

use ExternalFeedParser\Entity\ExternalEntity;
use ExternalFeedParser\Facades\FeedParser;
use Illuminate\Support\Facades\Http;

class XmlParseTest extends TestCase
{
    /** @test */
    public function xml_parse()
    {
        Http::fakeSequence()
            ->push(
                <<<XML
<?xml version="1.0" encoding="utf-8"?>
<source>
    <publisher>example</publisher>
    <lastUpdate>Fri, 14 Jan 2022 01:09:20 GMT</lastUpdate>
    <baz>
        <qux>
            <id>31</id>
            <title><![CDATA[Example, test31]]></title>
        </qux>
        <qux>
            <id>35</id>
            <title><![CDATA[Example, test35]]></title>
        </qux>
    </baz>
</source>
XML,
                200
            );

        $collection = FeedParser::provider('xml_foo')->parse();

        $this->assertCount(2, $collection);

        $entity = $collection->get(0);
        $this->assertInstanceOf(ExternalEntity::class, $entity);
        $this->assertEquals(31, $entity->get('id'));
        $this->assertEquals('Example, test31', $entity->get('title'));
        $this->assertCount(2, $entity->get());
        $this->assertIsArray($entity->get());
        $this->assertArrayHasKey('id', $entity->get());
        $this->assertArrayHasKey('title', $entity->get());

        $entity = $collection->get(1);
        $this->assertInstanceOf(ExternalEntity::class, $entity);
        $this->assertEquals(35, $entity->get('id'));
        $this->assertEquals('Example, test35', $entity->get('title'));
    }
}
