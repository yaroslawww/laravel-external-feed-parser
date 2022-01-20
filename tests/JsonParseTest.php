<?php

namespace ExternalFeedParser\Tests;

use ExternalFeedParser\Entity\ExternalEntity;
use ExternalFeedParser\Facades\FeedParser;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

class JsonParseTest extends TestCase
{
    /** @test */
    public function json_parse()
    {
        Http::fake(function (Request $request) {
            $this->assertEquals('FOO-BAR', $request->header('AuthKey')[0]);

            return Http::response([
                'publisher'  => 'example',
                'lastUpdate' => 'Fri, 14 Jan 2022 01:09:20 GMT',
                'baz'        => [
                    'qux' => [
                        [
                            'id'    => 31,
                            'title' => 'Example, test31',
                        ],
                        [
                            'id'    => 35,
                            'title' => 'Example, test35',
                        ],
                    ],
                ],
            ], 200);
        });

        $collection = FeedParser::provider('json_foo')->parse();

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
