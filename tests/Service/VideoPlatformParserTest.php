<?php

namespace App\Tests\Service;

use App\Service\VideoPlatformParser;
use PHPUnit\Framework\TestCase;

class VideoPlatformParserTest extends TestCase
{
    /**
     * @dataProvider getUrlToParseTests
     */
    public function testParsing($url, $site, $videoId)
    {
        $parser = new VideoPlatformParser;

        if ($site) {
            $this->assertTrue($parser->parseUrl($url));
        } else {
            $this->assertFalse($parser->parseUrl($url));
        }

        $this->assertEquals($site, $parser->getWebsite());
        $this->assertEquals($videoId, $parser->getVideoId());
        $this->assertIsArray($parser->getResults());

        return $parser;
    }

    public function getUrlToParseTests(): array
    {
        return [
            'classic YT' => ['https://www.youtube.com/watch?v=3C87B6dtARE', 'youtube', '3C87B6dtARE'],
            'REST style YT' => ['http://www.youtube.com/v/-aJoNYM4JV0?version=3&autohide=1', 'youtube', '-aJoNYM4JV0'],
            'with list YT' => ['https://www.youtube.com/watch?v=YyknBTm_YyM&list=PLVa18NUFqCi_pXCWOBBXZDRZt-uG0o0eR&index=2&t=0s', 'youtube', 'YyknBTm_YyM'],
            'embed style YT' => ['https://www.youtube.com/embed/NTbNCezCJNM', 'youtube', 'NTbNCezCJNM'],
            'shortened YT' => ['https://youtu.be/7yh9i0PAjck?t=6', 'youtube', '7yh9i0PAjck'],
            'classic DM' => ['https://www.dailymotion.com/video/x1arjab', 'dailymotion', 'x1arjab'],
            'classic VM' => ['https://vimeo.com/30856494', 'vimeo', '30856494'],
            'bad url' => ['https://github.com/', null, null],
            'bad string' => ['sohdgdfgdg', null, null],
            'empty' => ['', null, null],
            'null' => [null,null,null],
            'without http YT' => ['www.youtube.com/watch?v=VCTOpdlZJ8U', 'youtube', 'VCTOpdlZJ8U'],
            'without http & www YT' => ['youtube.com/watch?v=9OasxD_oP8M', 'youtube', '9OasxD_oP8M'],
            'time before id YT' => ['https://www.youtube.com/watch?time_continue=1314&v=mbXhQkKg7HE&feature=emb_title', 'youtube', 'mbXhQkKg7HE'],
        ];
    }
}