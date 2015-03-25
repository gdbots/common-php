<?php

namespace Gdbots\Common\Util;

/**
 * HashtagUtils has methods for converting text to a hashtag
 * and finding/validating hash tags.
 *
 * Current version does NOT support international hashtags.
 *
 * #hashtags how do they work?  magnets?
 *
 * #############
 * #### Rule below doesn't seem to be a rule anymore.  twitter does allow for hashtags
 * #### with leading numbers.  #2cellos or #50cent or #2014lol
 * #### - result must start with a letter (leading numbers are automatically removed) #####
 * #############
 *
 * - result must have at least one letter
 * - result cannot start with an underscore (leading _ automatically removed)
 * - all special chars and accent chars removed
 *      Beyoncé Knowles becomes BeyonceKnowles (makes it url friendly)
 * - result cannot be greater than 139 characters
 *
 * @see http://twitter.pbworks.com/w/page/1779812/Hashtags
 *
 */
final class HashtagUtils
{
    /**
     * Private constructor. This class is not meant to be instantiated.
     */
    private function __construct() {}

    /**
     * Converts special chars to more url friendly versions.
     *
     * @param $str
     * @return string
     */
    public static function normalize($str)
    {
        $str = strtr($str, array('ő' => 'o', 'ű' => 'u', 'Ő' => 'O', 'Ű' => 'U'));
        $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖŐØÙÚÛÜŰÝÞßàáâãäåæçèéêëìíîïðñòóôõöőøùúûűüýýþÿŔŕ';
        $b = 'AAAAAAACEEEEIIIIDNOOOOOOOUUUUUYbsaaaaaaaceeeeiiiidnooooooouuuuuyybyRr';
        $str = utf8_decode($str);
        $str = str_replace('?', '', $str);
        $str = strtr($str, utf8_decode($a), $b);
        return utf8_encode($str);
    }

    /**
     * Converts a string into a hash tag.  Hashtag result may be null if it
     * cannot be converted.
     *
     * @param string $str
     * @param bool $camelize
     * @return string|null
     */
    public static function create($str, $camelize = true)
    {
        // remove special chars (accents, etc.)
        $str = trim(self::normalize($str));
        $str = ltrim($str, '#_ ');

        // handle some punctuation and convertable chars
        $find = array("'", "?", "#", "/", "\"", "\\", "&amp;", "&", "%", "@");
        $repl = array('', '', '', '', '', '', ' And ', ' And ', ' Percent ', ' At ');
        $str = str_replace($find, $repl, $str);

        // replace everything else and split up the words
        if ($camelize) {
            $str = strtolower(preg_replace('/([A-Z])/', ':$1', $str));
            $str = str_replace(' ', '', ucwords(str_replace(':', ' ', $str)));
        } else {
            $str = str_replace(' ', '', str_replace(':', ' ', $str));
        }

        $str = ltrim($str, '_');
        $hashtag = '';
        $foundLetter = false;
        $len = strlen($str);
        if ($len > 139) {
            return null;
        }

        for ($i = 0; $i < $len; $i++) {
            $char = $str[$i];
            $hashtag .= $char;

            if (!$foundLetter && !is_numeric($char)) {
                $foundLetter = true;
            }
        }

        if (!$foundLetter) {
            return null;
        }

        return empty($hashtag) ? null : $hashtag;
    }

    /**
     * Extracts all of the valid hashtags from a string.  multi-line strings
     * will work with this method.
     *
     * @param string $str
     * @return array
     */
    public static function extract($str)
    {
        preg_match_all("/(^|[\n ])#([a-z0-9_-]*)/ise", $str, $matches);

        if (!is_array($matches) || !count($matches)) {
            return array();
        }

        $hashtags = array();
        foreach ($matches[0] as $match) {
            $match = ltrim(trim($match), '#_ ');
            if (self::isValid($match)) {
                $hashtags[strtolower($match)] = $match;
            }
        }

        return array_values($hashtags);
    }

    /**
     * Returns true if the provided hashtag conforms to the rules.
     *
     * @param string $hashtag
     * @return boolean
     */
    public static function isValid($hashtag)
    {
        $hashtag = ltrim($hashtag, '#');
        if (empty($hashtag)) {
            return false;
        }

        $test = preg_replace('/[^a-zA-Z0-9_]/', '', $hashtag);
        if ($test !== $hashtag) {
            return false;
        }

        if ('_' === $hashtag[0]) {
            return false;
        }

        $len = strlen($hashtag);
        if ($len > 139) {
            return false;
        }

        for ($i = 0; $i < $len; $i++) {
            if (!is_numeric($hashtag[$i])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Converts a hashtag into a more human readable version.
     * This isn't perfect as #MCHammer would become "M C Hammer".
     * It's good nuff.
     *
     * @param string $hashtag
     * @return string
     */
    public static function humanize($hashtag)
    {
        $hashtag = ltrim($hashtag, '#');
        $hashtag = strtolower(preg_replace('/([A-Z])/', ':$1', $hashtag));
        return ucwords(str_replace(':', ' ', $hashtag));
    }
}