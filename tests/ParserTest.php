<?php

namespace Tests;

use Src\Getters\FileGetContent;
use Src\Outputs\ConsoleOutput;
use Src\Parser;
use PHPUnit\Framework\TestCase as TestCaseAlias;

class ParserTest extends TestCaseAlias
{

    /**
     * @test
     * @dataProvider provideHtml
     */
    public function it_can_parse($html, $expected)
    {
        $url = 'https://example.com';

        $getter = $this->createMock(FileGetContent::class);
        $getter->expects($this->once())->method('get')->with($url)->willReturn($html);

        $formatter = $this->createMock(ConsoleOutput::class);
        $formatter->expects($this->once())->method('output');

        $parser = new Parser($url, $getter);
        $parser->parseTags($formatter);

        $this->assertEquals($url, $parser->getUrl());
        $this->assertEquals($html, $parser->getContent());
        $this->assertEquals($expected, $parser->getData($parser::TAGS));
        $this->assertEquals([$parser::TAGS => $expected], $parser->getAllData());
    }

    public function provideHtml(): array
    {
        return [
            [
                '<html><head><title>Title</title></head><body><div><div><a href="#">link</a><p class="test">Here p tag</p></div> <div><i>Cursive</i><em>Some another tag</em></div> </div>   <script>import Html from \'../Html.js\'</script> </body></html>',
                [
                    'html' => 1,
                    'head' => 1,
                    'title' => 1,
                    'body' => 1,
                    'div' => 3,
                    'a' => 1,
                    'p' => 1,
                    'i' => 1,
                    'em' => 1,
                    'script' => 1
                ]
            ]
        ];
    }
}
