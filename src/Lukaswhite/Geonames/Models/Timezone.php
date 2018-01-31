<?php namespace Lukaswhite\Geonames\Models;

use Lukaswhite\Geonames\Traits\Geo\HasCoordinates;
use Lukaswhite\Geonames\Contracts\HasCoordinates as HasCoordinatesContract;

/**
 * Class Timezone
 *
 * Represents, as the name implies, a timezone.
 *
 * @package Lukaswhite\Geonames\Models
 */
class Timezone implements HasCoordinatesContract
{
    use HasCoordinates;

    /**
     * The name of the timezone (e.g. Europe/London)
     *
     * @var string
     */
    private $name;

    /**
     * The DST (Daylight Saving Time) offset
     *
     * @var float
     */
    private $dstOffset;

    /**
     * The GMT (Greenwich Mean Time) offset
     *
     * @var float
     */
    private $gmtOffset;

    /**
     * The amount of time in hours to add to UTC to get standard time in this time zone. Because this value
     * is not affected by daylight saving time, it is called raw offset.
     *
     * @var float
     */
    private $rawOffset;

    /**
     * The country
     *
     * @var Country
     */
    private $country;

    /**
     * The local current time
     *
     * @var string
     */
    private $time;

    /**
     * Sunset local time (date)
     *
     * @var string
     */
    private $sunset;

    /**
     * Sunrise local time (date)
     * @var string
     */
    private $sunrise;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Timezone
     */
    public function setName( string $name ): Timezone
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float
     */
    public function getDstOffset(): float
    {
        return $this->dstOffset;
    }

    /**
     * @param float $dstOffset
     * @return Timezone
     */
    public function setDstOffset( float $dstOffset ): Timezone
    {
        $this->dstOffset = $dstOffset;
        return $this;
    }

    /**
     * @return float
     */
    public function getGmtOffset(): float
    {
        return $this->gmtOffset;
    }

    /**
     * @param float $gmtOffset
     * @return Timezone
     */
    public function setGmtOffset( float $gmtOffset ): Timezone
    {
        $this->gmtOffset = $gmtOffset;
        return $this;
    }

    /**
     * @return float
     */
    public function getRawOffset(): float
    {
        return $this->rawOffset;
    }

    /**
     * @param float $rawOffset
     * @return Timezone
     */
    public function setRawOffset( float $rawOffset ): Timezone
    {
        $this->rawOffset = $rawOffset;
        return $this;
    }

    /**
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

    /**
     * @param Country $country
     * @return $this
     */
    public function setCountry( Country $country )
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     * @return Timezone
     */
    public function setTime( $time )
    {
        $this->time = $time;
        return $this;
    }

    /**
     * @return string
     */
    public function getSunset(): string
    {
        return $this->sunset;
    }

    /**
     * @param string $sunset
     * @return Timezone
     */
    public function setSunset( string $sunset ): Timezone
    {
        $this->sunset = $sunset;
        return $this;
    }

    /**
     * @return string
     */
    public function getSunrise(): string
    {
        return $this->sunrise;
    }

    /**
     * @param string $sunrise
     * @return Timezone
     */
    public function setSunrise( string $sunrise ): Timezone
    {
        $this->sunrise = $sunrise;
        return $this;
    }

    /**
     * Convert this timezone into a string representation
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}