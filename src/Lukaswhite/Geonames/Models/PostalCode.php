<?php namespace Lukaswhite\Geonames\Models;

use Lukaswhite\Geonames\Contracts\HasAdminCodeNames;
use Lukaswhite\Geonames\Traits\Geo\HasCoordinates;
use Lukaswhite\Geonames\Traits\Models\HasAdminCodes;
use Lukaswhite\Geonames\Traits\Models\HasCountryCode;
use Lukaswhite\Geonames\Traits\Models\HasName;
use Lukaswhite\Geonames\Contracts\HasAdminCodes as HasAdminCodesContract;
use Lukaswhite\Geonames\Contracts\HasAdminCodeNames as HasAdminCodeNamesContract;
use Lukaswhite\Geonames\Contracts\HasCoordinates as HasCoordinatesContract;

/**
 * Class PostalCode
 *
 * Represents, as the name implies, a postal code.
 *
 * @package Lukaswhite\Geonames\Models
 */
class PostalCode implements HasAdminCodesContract, HasAdminCodeNames, HasCoordinatesContract
{
    use HasName,
        HasCountryCode,
        HasAdminCodes,
        HasCoordinates;

    /**
     * The actual postal code
     *
     * @var string
     */
    protected $postalCode;

    /**
     * The distance from the co-ordinates provided when finding nearby postcodes.
     *
     * @var float
     */
    protected $distance;

    /**
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     * @return PostalCode
     */
    public function setPostalCode( string $postalCode ): PostalCode
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param mixed $distance
     * @return PostalCode
     */
    public function setDistance( $distance )
    {
        $this->distance = $distance;
        return $this;
    }

    /**
     * Convert this postal code into a string representation
     *
     * @return string
     */
    public function __toString()
    {
        return $this->postalCode;
    }
}