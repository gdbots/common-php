<?php
/**
 * Copied from original author and moved to this namespace, also implemented \JsonSerializable
 *
 * @link http://github.com/myclabs/php-enum
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
*/

namespace Tdn\Common;

abstract class AbstractEnum implements \JsonSerializable
{
    /**
     * Enum value
     * @var mixed
     */
    protected $value;

    /**
     * Store existing constants in a static cache per object.
     * @var array
     */
    private static $cache = array();

    /**
     * Creates a new value of some type
     * @param mixed $value
     * @throws \UnexpectedValueException if incompatible type is given.
     */
    public function __construct($value)
    {
        $possibleValues = self::toArray();
        if (!in_array($value, $possibleValues)) {
            throw new \UnexpectedValueException("Value '$value' is not part of the enum " . get_called_class());
        }
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->value;
    }

    /**
     * @return mixed
     */
    public function jsonSerialize()
    {
        return $this->value;
    }

    /**
     * Returns all possible values as an array
     * @return array Constant name in key, constant value in value
     */
    public static function toArray()
    {
        $calledClass = get_called_class();
        if (!isset(self::$cache[$calledClass])) {
            $reflection = new \ReflectionClass($calledClass);
            self::$cache[$calledClass] = $reflection->getConstants();
        }
        return self::$cache[$calledClass];
    }

    /**
     * Returns a value when called statically like so: MyEnum::SOME_VALUE() given SOME_VALUE is a class constant
     * @param string $name
     * @param array  $arguments
     * @return static
     * @throws \BadMethodCallException
     */
    public static function __callStatic($name, $arguments)
    {
        if (defined("static::$name")) {
            return new static(constant("static::$name"));
        }
        throw new \BadMethodCallException("No static method or enum constant '$name' in class " . get_called_class());
    }
}
