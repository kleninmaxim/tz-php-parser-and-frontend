<?php

use Src\Getters\FileGetContent;
use Src\Outputs\ConsoleOutput;
use Src\Parser;

require __DIR__ . '/vendor/autoload.php';

// Create class parser
$parser = new Parser(
    'https://a3f.ru/',
    new FileGetContent()
);

// Parse Tags
$parser->parseTags(
    new ConsoleOutput()
);

$url = $parser->getUrl(); // get url that was parsed
$content = $parser->getContent(); // get html content by url
$tags = $parser->getData($parser::TAGS); // get parsed tags from html
$all_data = $parser->getAllData(); // get all data was parse from html
