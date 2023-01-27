<?php

namespace Src\Getters;

interface HtmlInterface
{
    public function get(string $url): string;
}