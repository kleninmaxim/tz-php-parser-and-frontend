<?php

namespace Src\Outputs;

use Src\Outputs\Interfaces\ParserTagOutputInterface;

class ConsoleOutput implements ParserTagOutputInterface
{
    /**
     * Output into console as echo
     * @param array $tags array of unique tags and their counts
     * @return void
     */
    public function output(array $tags): void
    {
        foreach ($tags as $tag => $count) {
            echo $tag . ': ' . $count . PHP_EOL;
        }
    }
}