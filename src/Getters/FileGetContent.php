<?php

namespace Src\Getters;

class FileGetContent implements HtmlInterface
{
    /**
     * Return result by file get content function
     * @param string $url example: 'https://a3f.ru/'
     * @return string
     */
    public function get(string $url): string
    {
        return file_get_contents($url) ?: '';
    }
}