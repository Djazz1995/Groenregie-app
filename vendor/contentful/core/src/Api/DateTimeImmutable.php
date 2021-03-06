<?php

/**
 * This file is part of the contentful/contentful-core package.
 *
 * @copyright 2015-2018 Contentful GmbH
 * @license   MIT
 */

namespace Contentful\Core\Api;

/**
 * DateTimeImmutable class.
 *
 * This class is used for easier conversion to a timestamp that works with Contentful.
 */
class DateTimeImmutable extends \DateTimeImmutable implements \JsonSerializable
{
    /**
     * Formats the string for an easier interoperability with Contentful.
     *
     * @return string
     */
    public function formatForJson()
    {
        $date = $this->setTimezone(new \DateTimeZone('Etc/UTC'));
        $result = $date->format('Y-m-d\TH:i:s');
        $milliseconds = \floor($date->format('u') / 1000);

        if ($milliseconds > 0) {
            $result .= '.'.\str_pad((string) $milliseconds, 3, '0', STR_PAD_LEFT);
        }

        return $result.'Z';
    }

    /**
     * Returns a string representation of the current object.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->formatForJson();
    }

    /**
     * Returns a JSON representation of the current object.
     *
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->formatForJson();
    }
}
