<?php namespace Lukaswhite\Geonames\Traits\Models;

/**
 * Trait HasCountryName
 *
 * @package Lukaswhite\Geonames\Traits\Models
 */
trait HasCountryName
{
    /**
     * The country name
     *
     * @var string
     */
    private $countryName;

    /**
     * @return string
     */
    public function getCountryName()
    {
        return $this->countryName;
    }

    /**
     * @param mixed $countryName
     * @return $this
     */
    public function setCountryName( $countryName )
    {
        $this->countryName = $countryName;
        return $this;
    }

}