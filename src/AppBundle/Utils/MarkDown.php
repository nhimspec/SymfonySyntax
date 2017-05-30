<?php

namespace AppBundle\Utils;
/**
 * Class MarkDown
 * Use to render twig HTML content blog
 *
 * @package AppBundle\Utils
 */
class MarkDown
{
    private $parser;

    public function __construct()
    {
        $this->parser = new \Parsedown();
    }

    public function toHtml($text)
    {
        $html = $this->parser->text($text);

        return $html;
    }
}