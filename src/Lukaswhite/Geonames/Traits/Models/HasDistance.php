<?php namespace Lukaswhite\Geonames\Traits\Models;

/**
 * Trait HasDistance
 *
 * @package Lukaswhite\Geonames\Traits\Models
 */
trait HasDistance
{
    /**
     * The distance (km)
     *
     * @var float
     */
    private $distance;

    /**
     * Get the distance (km)
     *
     * @return float
     */
    public function getDistance(): float
    {
        return $this->distance;
    }

    /**
     * Set the distance
     *
     * @param float $distance
     * @return $this
     */
    public function setDistance( float $distance )
    {
        $this->distance = $distance;
        return $this;
    }

}