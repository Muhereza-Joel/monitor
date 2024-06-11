<?php

namespace core;

class HtmlTruncator
{
    public static function truncateHtml($text, $maxLength)
    {
        $printedLength = 0;
        $position = 0;
        $tags = [];

        $result = '';

        while ($printedLength < $maxLength && preg_match('{</?([a-z]+)[^>]*>|[^<]+}i', $text, $match, PREG_OFFSET_CAPTURE, $position)) {
            list($part, $partPosition) = $match[0];

            if ($part[0] === '<') {
                if ($part[1] === '/') {
                    array_pop($tags);
                } else {
                    $tag = strtok($part, " \t\n\r\0\x0B>");
                    array_push($tags, $tag);
                }
                $result .= $part;
            } else {
                if ($printedLength + strlen($part) > $maxLength) {
                    $result .= substr($part, 0, $maxLength - $printedLength);
                    break;
                }
                $result .= $part;
                $printedLength += strlen($part);
            }

            $position = $partPosition + strlen($part);
        }

        while ($tags) {
            $result .= sprintf('</%s>', array_pop($tags));
        }

        return $result;
    }
}
