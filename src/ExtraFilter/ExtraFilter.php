<?php
namespace Anax\ExtraFilter;

class ExtraFilter
{
    /**
     * Helper, Markdown formatting converting to HTML.
     *
     * @param string text The text to be converted.
     * @SuppressWarnings(PHPMD.StaticAccess)
     * @return string the formatted text.
     */
    public function markdown($text)
    {
        $text = \Michelf\MarkdownExtra::defaultTransform($text);
        return $text;
    }
}
