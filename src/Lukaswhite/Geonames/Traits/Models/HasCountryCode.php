<?php namespace Lukaswhite\Geonames\Traits\Models;

/**
 * Trait HasCountryCode
 *
 * @package Lukaswhite\Geonames\Traits\Models
 */
trait HasCountryCode
{
    /**
     * The country code
     *
     * @var string
     */
    private $countryCode;

    /**
     * @return mixed
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param mixed $countryCode
     * @return $this
     */
    public function setCountryCode( $countryCode )
    {
        $this->countryCode = $countryCode;
        return $this;
    }

}