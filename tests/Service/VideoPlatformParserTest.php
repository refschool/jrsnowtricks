<?php

namespace App\Tests\Service;

use App\Service\VideoPlatformParser;
use PHPUnit\Framework\TestCase;

class VideoPlatformParserTest extends TestCase
{
    public function testParseUrl()
    {
        $parser = new VideoPlatformParser();

        $result = $parser->parseUrl('toto');

        $this->assertTrue($result);
    }
}