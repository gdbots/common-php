<?php

namespace Gdbots\Common;

/**
 * Represents a GeoJson Point value.
 * @link http://geojson.org/geojson-spec.html#point
 *
 * @deprecated Use "Gdbots\Pbj\WellKnown\GeoPoint" from "gdbots/pbj" 1.1.x or later instead.
 */
class GeoPoint implements FromArray, ToArray, \JsonSerializable
{
    /** @var float */
    private $latitude;

    /** @var float */
    private $longitude;

    /**
     * @param float $lat
     * @param float $lon
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($lat, $lon)
    {
        @trigger_error(sprintf('"%s" is deprecated.  Use "Gdbots\Pbj\WellKnown\GeoPoint" from "gdbots/pbj" 1.1.x or later instead.', __CLASS__), E_USER_DEPRECATED);

        $this->latitude = (float) $lat;
        $this->longitude = (float) $lon;

        if ($this->latitude > 90.0 || $this->latitude < -90.0) {
            throw new \InvalidArgumentException('Latitude must be within range [-90.0, 90.0]');
        }

        if ($this->longitude > 180.0 || $this->longitude < -180.0) {
            throw new \InvalidArgumentException('Longitude must be within range [-180.0, 180.0]');
        }
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * {@inheritdoc}
     */
    public static function fromArray(array $data = [])
    {
        if (isset($data['coordinates'])) {
            return new self($data['coordinates'][1], $data['coordinates'][0]);
        }
        throw new \InvalidArgumentException('Payload must be a GeoJson "Point" type.');
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return ['type' => 'Point', 'coordinates' => [$this->longitude, $this->latitude]];
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @param string $string A string with format lat,long
     * @return self
     */
    public static function fromString($string)
    {
        list($lat, $long) = explode(',', $string);
        return new self($lat, $long);
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->latitude . ',' . $this->longitude;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}
