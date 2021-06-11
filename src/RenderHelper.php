<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax;

class RenderHelper
{
    /**
     * @param string $text
     *        original text
     *        tabs are used as indents
     *        "\n" is used as line break
     *        can contain comments, empty line and trailing spaces
     * @param string $indent [optional]
     *        indent instead tabs
     * @param bool $clear [optional]
     *        removes empty lines and comment lines
     * @param bool $rtrim [optional]
     *        removes trailing spaces and ends the text with one empty line
     * @param string $nl [optional]
     *        the line break symbol
     * @return string
     *         formatted original text
     */
    public static function format(
        string $text,
        string $indent = '    ',
        bool $clear = false,
        bool $rtrim = true,
        string $nl = "\n",
    ): string {
        $lines = [];
        foreach (explode("\n", $text) as $line) {
            if ($rtrim) {
                $line = rtrim($line);
            }
            if ($clear) {
                if ($line === '') {
                    continue;
                }
                if (preg_match('/^\t*#/s', $line)) {
                    continue;
                }
            }
            $lines[] = str_replace("\t", $indent, $line);
        }
        $result = implode($nl, $lines);
        if ($rtrim) {
            $result = rtrim($result) . $nl;
        }
        return $result;
    }

    /**
     * Move text one indent to the right
     *
     * @param string $text
     * @param string $indent
     * @return string
     */
    public static function indent(string $text, string $indent = "\t"): string
    {
        return $indent . str_replace("\n", "\n$indent", $text);
    }

    /**
     * Render a items list
     *
     * @param array $items
     *        an item can be of any type that can be cast to a string
     *        items separated by line break
     *        if an scalar item converts to empty line it takes one line, an object item takes no line
     * @return string
     */
    public static function render(array $items): string
    {
        $lines = [];
        foreach ($items as $item) {
            $line = (string)$item;
            if (($line !== '') || (!is_object($item))) {
                $lines[] = $line;
            }
        }
        return implode("\n", $lines);
    }

    public static function escapeParam($param): string
    {
        return addcslashes((string)$param, ' "');
    }
}
