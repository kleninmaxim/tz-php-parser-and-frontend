<?php

namespace Src;

use Src\Getters\HtmlInterface;
use Src\Outputs\Interfaces\ParserTagOutputInterface;

class Parser
{
    /**
     * @var string html content
     */
    protected string $html;

    /**
     * @var array save data that was parsed
     */
    protected array $data = [];

    /**
     * Const to use as key in data class property
     */
    const TAGS = 'tags';

    /**
     * @param string $url example: 'https://a3f.ru/'
     * @param HtmlInterface $getter_content Class how to get html data
     */
    public function __construct(protected string $url, HtmlInterface $getter_content)
    {
        $this->html = $this->getHtmlContent($getter_content);
    }

    /**
     * Get url that parse
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Get Html Content By url
     * @return string
     */
    public function getContent(): string
    {
        return $this->html;
    }

    /**
     * Get data by name that was parsed
     * @param string $name name of data you want to get
     * @return array
     */
    public function getData(string $name): array
    {
        return $this->data[$name] ?? [];
    }

    /**
     * Get all data that was parsed
     * @return array
     */
    public function getAllData(): array
    {
        return $this->data;
    }

    /**
     * Tag parsed
     * @param ParserTagOutputInterface $formatter how output tags that we get
     * @return void
     */
    public function parseTags(ParserTagOutputInterface $formatter): void
    {
        $this->parse(self::TAGS, 'getAllTags');

        $formatter->output($this->data[self::TAGS]);
    }

    /**
     * Parse and save result to $data array
     * @param string $name Key to save in $data array
     * @param string $method Method of this class that will handle html
     * @param array $args Arguments of $method function as an array
     * @return void
     */
    protected function parse(string $name, string $method, array $args = []): void
    {
        $this->save(
            $name,
            $this->$method(...$args)
        );
    }

    /**
     * Get Html Content as a string
     * @param HtmlInterface $getter_content Getter Class how to get html
     * @return string
     */
    protected function getHtmlContent(HtmlInterface $getter_content): string
    {
        return $getter_content->get($this->url);
    }

    /**
     * Save $data result to a class property data array by $name key
     * @param string $name Key how to save
     * @param mixed $data Data result
     * @return void
     */
    protected function save(string $name, mixed $data): void
    {
        $this->data[$name] = $data;
    }

    /**
     * Method to process html for getting unique tags and their count
     * @return array
     */
    protected function getAllTags(): array
    {
        preg_match_all('/<(\w+)/', $this->html, $matches);

        return array_count_values($matches[1]);
    }
}