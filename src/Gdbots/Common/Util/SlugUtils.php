<?php

namespace Gdbots\Common\Util;

final class SlugUtils
{
    const VALID_SLUG_PATTERN = '/^[a-z0-9-]+$/';
    const VALID_DATED_SLUG_PATTERN = '/^([a-z0-9-]|[a-z0-9-][a-z0-9-\/]*[a-z0-9-])$/';

    /**
     * Private constructor. This class is not meant to be instantiated.
     */
    private function __construct() {}

    /**
     * Creates a slug from the text given.
     *
     * @param string $string
     * @param bool $allowSlashes
     * @return string
     */
    public static function create($string, $allowSlashes = false)
    {
        $slug = '';
        $string = html_entity_decode($string, ENT_QUOTES);

        $string = preg_replace("/https*:\/\//", '', $string);
        for ($i = 0; $i <= strlen($string); $i++) {
            $c = ord(substr($string, $i, 1));
            if ($c < 128) {
                $slug .= chr($c);
            }

            if (($c >= 224 && $c <= 229) || ($c >= 192 && $c <= 198) || ($c >= 281 && $c <= 286)) {
                $slug .= 'a';
            } else if (($c >= 232 && $c <= 235) || ($c >= 200 && $c <= 203)) {
                $slug .= 'e';
            } else if (($c >= 236 && $c <= 239) || ($c >= 204 && $c <= 207)) {
                $slug .= 'i';
            } else if (($c >= 242 && $c <= 248) || ($c >= 210 && $c <= 216)) {
                $slug .= 'o';
            } else if (($c >= 249 && $c <= 252) || ($c >= 217 && $c <= 220)) {
                $slug .= 'u';
            } else if ($c == 253 || $c == 255 || $c == 221 || $c == 376) {
                $slug .= 'y';
            } else if ($c == 230 || $c == 198) {
                $slug .= 'ae';
            } else if ($c == 338 || $c == 339) {
                $slug .= 'oe';
            } else if ($c == 199 || $c == 231 || $c == 162) {
                $slug .= 'c';
            } else if ($c == 209 || $c == 241) {
                $slug .= 'n';
            } else if ($c == 352 || $c == 353) {
                $slug .= 's';
            } else if ($c == 208 || $c == 240) {
                $slug .= 'eth';
            } else if ($c == 223) {
                $slug .= 'sz';
            } else if (($c >= 8219 && $c <= 8223) || $c == 8242 || $c == 8243 || $c == 8216 || $c == 8217 || $c == 168 || $c == 180 || $c == 729 || $c == 733) {
                //all the strange curly single and double quotes
                // Ignore them
            } else if ($c == 188) {
                $slug .= '-one-quarter-';
            } else if ($c == 189) {
                $slug .= '-one-half-';
            } else if ($c == 190) {
                $slug .= '-three-quarters-';
            } else if ($c == 178) {
                $slug .= '-squared-';
            } else if ($c == 179) {
                $slug .= '-cubed-';
            } else if ($c > 127) {
                $slug .= '-';
            }
        }

        $find = array(
            "'",
            "\"",
            "\\",
            "&",
            "%",
            "@",
        );

        $repl = array(
            '',
            '',
            '',
            '-and-',
            '-percent-',
            '-at-',
        );

        $slug = str_replace($find, $repl, $slug);

        if (!$allowSlashes) {
            $slug = preg_replace("/[^a-zA-Z0-9\-]+/i", '-', $slug);
        } else {
            $slug = preg_replace("/[^a-zA-Z0-9\-\/]+/i", '-', $slug);
        }

        // replace more than one dash in a row
        $slug = preg_replace("/\-+/i", '-', $slug);

        if ($allowSlashes) {
            $slug = str_replace(array('-/', '/-'), '/', $slug);
            // replace more than one slash in a row
            $slug = preg_replace("/\/+/i", '/', $slug);
        }

        // remove leading and trailing dash and slash
        $slug = trim($slug, '/-');
        $slug = strtolower($slug);

        return $slug;
    }

    /**
     * Adds the date in the format YYYY/mm/dd to the slug.
     *
     * @param string $slug
     * @param \DateTime $date
     * @return string
     */
    public static function addDate($slug, \DateTime $date)
    {
        return $date->format('Y/m/d/') . self::removeDate($slug);
    }

    /**
     * Removes the date in the format YYYY/mm/dd from the slug if it is found.
     *
     * @param string $slug
     * @return string
     */
    public static function removeDate($slug)
    {
        $slug = trim($slug, '/');
        while (preg_match('/^\d{4}\/\d{2}\/\d{2}\/?(\S+)?/', $slug, $m)) {
            $slug = trim(isset($m[1]) ? $m[1] : '', '/');
        }
        return $slug;
    }

    /**
     * Detemines if the slug contains a date in the format YYYY/mm/dd
     *
     * @param string $slug
     * @return int
     */
    public static function containsDate($slug)
    {
        return preg_match('/^\d{4}\/\d{2}\/\d{2}\/?(\S+)?/', $slug);
    }

    /**
     * Translates, as best as possible, a slug back into a human readable format.
     *
     * @param string $slug
     * @return string
     */
    public static function humanize($slug)
    {
        $str = str_replace('-', ' ', $slug);
        $words = explode(' ', $str);
        $words = array_map('ucfirst', $words);
        return implode(' ', $words);
    }

    /**
     * @param string $string
     * @param bool $allowSlashes
     * @return bool
     */
    public static function isValid($string, $allowSlashes = false)
    {
        $match = $allowSlashes ? self::VALID_DATED_SLUG_PATTERN : self::VALID_SLUG_PATTERN;
        return preg_match($match, $string) > 0;
    }

    /**
     * @param string $string
     * @param bool $allowSlashes
     * @return string
     */
    public static function createFromCamel($string, $allowSlashes = false)
    {
        $string = trim(preg_replace('/(([A-Z]|[0-9])[^A-Z])/', ' $1', $string));
        return self::create($string, $allowSlashes);
    }
}
