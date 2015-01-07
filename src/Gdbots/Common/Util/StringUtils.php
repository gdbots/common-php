<?php

namespace Gdbots\Common\Util;

class StringUtils
{
    // todo: memoize inflectors

    /**
     * Returns true if the provided string starts with a letter.
     *
     * @param string $str
     * @return string
     */
    public static function startsWithLetter($str)
    {
        return preg_match('/^[a-zA-Z]/', $str);
    }

    /**
     * Converts a camelCase string to slug-i-fied style.
     *
     * @param string $camelCase
     * @return string
     */
    public static function toSlugFromCamelCase($camelCase)
    {
        return trim(strtolower(preg_replace('/([A-Z])/', '-$1', $camelCase)), '-');
    }

    /**
     * Converts a slug-i-fied string to camelCase style.
     *
     * @param string $slug
     * @return string
     */
    public static function toCamelCaseFromSlug($slug)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $slug)));
    }

    /**
     * Converts a camelCase string to snake_case style.
     *
     * @param string $camelCase
     * @return string
     */
    public static function toSnakeCaseFromCamelCase($camelCase)
    {
        return trim(strtolower(preg_replace('/([A-Z])/', '_$1', $camelCase)), '_');
    }

    /**
     * Converts a snake_case string to camelCase style.
     *
     * @param string $snakeCase
     * @return string
     */
    public static function toCamelCaseFromSnakeCase($snakeCase)
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $snakeCase)));
    }

    /**
     * @param $var
     * @return string
     */
    public static function varToString($var)
    {
        if (is_object($var)) {
            return sprintf('Object(%s)', get_class($var));
        }

        if (is_array($var)) {
            $a = array();
            foreach ($var as $k => $v) {
                $a[] = sprintf('%s => %s', $k, self::varToString($v));
            }

            return sprintf("Array(%s)", implode(', ', $a));
        }

        if (is_resource($var)) {
            return sprintf('Resource(%s)', get_resource_type($var));
        }

        if (null === $var) {
            return 'null';
        }

        if (false === $var) {
            return 'false';
        }

        if (true === $var) {
            return 'true';
        }

        return (string)$var;
    }
}
