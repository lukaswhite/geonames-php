<?php namespace Lukaswhite\Geonames\Models;

/**
 * Class Coordinate
 *
 * Represents a lat/lng pair.
 *
 * @package Lukaswhite\Geonames\Models
 */
class Coordinate
{
    /**
     * The latitude
     *
     * @var float
     */
    private $latitude;

    /**
     * The longitude
     *
     * @var float
     */
    private $longitude;

    /**
     * Coordinate constructor.
     *
     * @param array $latLng
     */
    public function __construct( $latLng = null )
    {
        if ( $latLng ) {
            $this->latitude     =   $latLng[ 0 ];
            $this->longitude    =   $latLng[ 1 ];
        }
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     * @return Coordinate
     */
    public function setLatitude( float $latitude ): Coordinate
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     * @return Coordinate
     */
    public function setLongitude( float $longitude ): Coordinate
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * Create a string representation of this coordinate
     *
     * @return string
     */
    public function __toString( )
    {
        return sprintf(
            '%s, %s', // Note that using %f can add additional decimal places
            $this->latitude,
            $this->longitude
        );
    }

    /**
     * Create an array representation of this coordinate
     *
     * @param bool $associative
     * @return array
     */
    public function toArray( $associative = false )
    {
        if ( $associative ) {
            return [
                'latitude' => $this->latitude,
                'longitude' => $this->longitude
            ];
        }

        return [
            $this->latitude,
            $this->longitude
        ];
    }
}