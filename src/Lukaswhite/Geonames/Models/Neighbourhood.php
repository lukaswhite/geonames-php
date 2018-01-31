<?php namespace Lukaswhite\Geonames\Models;

use Lukaswhite\Geonames\Traits\Models\HasAdminCodes;
use Lukaswhite\Geonames\Traits\Models\HasCountryCode;
use Lukaswhite\Geonames\Traits\Models\HasCountryName;
use Lukaswhite\Geonames\Traits\Models\HasName;
use Lukaswhite\Geonames\Contracts\HasAdminCodes as HasAdminCodesContract;
use Lukaswhite\Geonames\Contracts\HasAdminCodeNames as HasAdminCodeNamesContract;

/**
 * Class Neighbourhood
 *
 * Represents a neighbourhood in a US city
 *
 * @package Lukaswhite\Geonames\Models
 */
class Neighbourhood implements HasAdminCodesContract, HasAdminCodeNamesContract
{
    use HasName,
        HasAdminCodes,
        HasCountryCode,
        HasCountryName;

    /**
     * The name of the city
     *
     * @var string
     */
    private $city;

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return Neighbourhood
     */
    public function setCity( string $city ): Neighbourhood
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Get a string representation of this neighbourhood.
     *
     * @return string
     */
    public function __toString( )
    {
        return $this->name;
    }
}