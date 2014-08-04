<?php

namespace Gdbots\Common\Util;

class ClassUtils
{
    /**
     * Keeps a static reference of all requests for a classes traits.
     * They array key is the fully qualified class name and a flag for
     * whether or not to do a deep scan (inherited classes) and autoload.
     *
     * @var array
     */
    private static $classTraits = array();

    /**
     * Returns an array of all the traits that a class is using.  This
     * includes all of the extended classes and traits by default.
     *
     * @param string|object $class
     * @param bool $deep
     * @param bool $autoload
     * @return array
     */
    public static function getTraits($class, $deep = true, $autoload = true)
    {
        $cachKey = is_object($class) ? get_class($class) : (string) $class;
        $cachKey .= $deep ? ':deep' : '';
        $cachKey .= $autoload ? ':autoload' : '';

        if (isset(self::$classTraits[$cachKey])) {
            return self::$classTraits[$cachKey];
        }

        $traits = class_uses($class, $autoload);

        if (false === $deep) {
            self::$classTraits[$cachKey] = $traits;
            return $traits;
        }

        foreach (class_parents($class) as $parent) {
            $traits = array_merge(class_uses($parent, $autoload), $traits);
        }

        foreach ($traits as $trait) {
            $traits = array_merge(class_uses($trait, $autoload), $traits);
        }

        self::$classTraits[$cachKey] = array_unique($traits);
        return self::$classTraits[$cachKey];
    }

    /**
     * Returns true if a class uses a given trait.
     *
     * @param string|object $class
     * @param string $trait full qualified class name
     * @return bool
     */
    public static function usesTrait($class, $trait)
    {
        return in_array($trait, self::getTraits($class));
    }
}