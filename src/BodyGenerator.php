<?php

namespace Http\Client\Utils;

use Http\Client\Exception;
use Psr\Http\Message\StreamInterface;

/**
 * Generates string content and headers for any content
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
interface BodyGenerator
{
    /**
     * Returns a set of headers which is needed to correctly send the body
     *
     * Content-Length is calculated automatically if possible
     *
     * @return array
     */
    public function getHeaders();

    /**
     * Convert data to a format which can be used to create a proper PSR-7 Stream
     *
     * @return string|StreamInterface
     */
    public function getContent();
}
