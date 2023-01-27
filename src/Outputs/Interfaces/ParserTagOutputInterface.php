<?php

namespace Src\Outputs\Interfaces;

interface ParserTagOutputInterface
{
    public function output(array $tags): void;
}