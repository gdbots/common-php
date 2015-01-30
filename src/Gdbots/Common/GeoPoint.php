<?php

namespace Gdbots\Common;

/**
 * Represents a GeoJson Point value.
 * @link http://geojson.org/geojson-spec.html#point
 */
final class GeoPoint implements FromArray, ToArray, \JsonSerializable
{
    /** @var float */
    private $longitude;

    /** @var float */
    private $latitude;

    /**
     * @param float $lon
     * @param float $lat
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($lon, $lat)
    {
        $this->longitude = (float) $lon;
        $this->latitude = (float) $lat;

        if ($this->longitude > 180.0 || $this->longitude < -180.0) {
            throw new \InvalidArgumentException('Longitude must be within range [-180.0, 180.0]');
        }

        if ($this->latitude > 90.0 || $this->latitude < -90.0) {
            throw new \InvalidArgumentException('Latitude must be within range [-90.0, 90.0]');
        }
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * {@inheritdoc}
     */
    public static function fromArray(array $data = [])
    {
        if (isset($data['coordinates'])) {
            return new self($data['coordinates'][0], $data['coordinates'][1]);
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
}
