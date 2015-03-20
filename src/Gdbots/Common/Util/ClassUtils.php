<?php

namespace Gdbots\Common\Util;

final class ClassUtils
{
    /**
     * Keeps a static reference of all requests for a classes traits.
     * The array key is the fully qualified class name and a flag for
     * whether or not to do a deep scan (inherited classes) and autoload.
     *
     * @var array
     */
    private static $classTraits = [];

    /**
     * Private constructor. This class is not meant to be instantiated.
     */
    private function __construct() {}

    /**
     * Returns an array of all the traits that a class is using.  This
     * includes all of the extended classes and traits by default.
     *
     * Stores the traits as ['MyTrait' => 1, 'MyOtherTrait' => 2]
     * for optimal checking on the usesTrait method.
     *
     * @param string|object $class
     * @param bool $deep
     * @param bool $autoload
     * @return array
     */
    private static function loadTraits($class, $deep = true, $autoload = true)
    {
        $cachKey = is_object($class) ? get_class($class) : (string) $class;
        $cachKey .= $deep ? ':deep' : '';
        $cachKey .= $autoload ? ':autoload' : '';

        if (isset(self::$classTraits[$cachKey])) {
            return self::$classTraits[$cachKey];
        }

        $traits = class_uses($class, $autoload);

        if (false === $deep) {
            self::$classTraits[$cachKey] = array_flip($traits);
            return $traits;
        }

        foreach (class_parents($class) as $parent) {
            $traits = array_merge(class_uses($parent, $autoload), $traits);
        }

        foreach ($traits as $trait) {
            $traits = array_merge(class_uses($trait, $autoload), $traits);
        }

        self::$classTraits[$cachKey] = array_flip(array_unique($traits));
        return self::$classTraits[$cachKey];
    }

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
        return array_keys(self::loadTraits($class, $deep, $autoload));
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
        return isset(self::loadTraits($class)[$trait]);
    }

    /**
     * Returns the class name of an object, without the namespace
     *
     * @param object|string $objectOrString
     * @return string
     */
    public static function getShortName($objectOrString)
    {
        $parts = explode('\\', is_object($objectOrString) ? get_class($objectOrString) : $objectOrString);
        return end($parts);
    }

    /**
     * Returns an array of CONSTANT_NAME => value for a given class
     *
     * @param string $className
     * @return array
     */
    public static function getConstants($className)
    {
        return (new \ReflectionClass($className))->getConstants();
    }
}