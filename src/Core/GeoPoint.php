<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Core;

use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/geo-point.html
 */
final class GeoPoint
{
    protected $options = [];

    /**
     * ..
     *
     * @var float
     */
    protected $latitude;

    /**
     * ..
     *
     * @var float
     */
    protected $longitude;

    protected $geohash;

    /**
     * How to compute the distance.
     *
     * @param string $distanceType
     *
     * @throws \InvalidArgumentException
     *
     * @return $this
     */
    public function distanceType(string $distanceType): self
    {
        $distanceTypeLower = strtolower($distanceType);

        $validOperators = ['arc', 'plan'];

        if (! in_array($distanceTypeLower, $validOperators, true)) {
            throw new InvalidArgumentException("The [{$distanceType}] distance type is invalid.");
        }

        $this->options['distance_type'] = $distanceTypeLower;

        return $this;
    }

    public function geoHash(string $geohash): self
    {
        $this->geohash = $geohash;

        return $this;
    }

    public function latitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function longitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * The unit to use when computing sort values.
     *
     * @param string $unit
     *
     * @return $this
     */
    public function unit(string $unit): self
    {
        $this->options['unit'] = $unit;

        return $this;
    }

    /**
     * Returns the DSL Geo Point as an array.
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function toArray(): array
    {
        // if (! isset($this->options['lat'])) {
        //     throw new InvalidArgumentException('The latitude needs to be set!');
        // }

        // if (! isset($this->options['lon'])) {
        //     throw new InvalidArgumentException('The longitude needs to be set!');
        // }

        return $this->options;
    }

    /**
     * Returns the query in JSON format.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
