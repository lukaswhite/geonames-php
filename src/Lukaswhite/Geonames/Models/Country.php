<?php namespace Lukaswhite\Geonames\Models;

use Lukaswhite\Geonames\Traits\Geo\HasBoundingBox;
use Lukaswhite\Geonames\Traits\Geo\HasCoordinates;
use Lukaswhite\Geonames\Traits\Models\HasGeonamesId;

/**
 * Class Country
 *
 * Represents, as the name implies, a country.
 *
 * @package Lukaswhite\Geonames\Models
 */
class Country
{
    use HasGeonamesId,
        HasCoordinates,
        HasBoundingBox;

    /**
     * The two-letter country code
     *
     * @var string
     */
    private $code;

    /**
     * The full name of the country
     *
     * @var string
     */
    private $name;

    /**
     * The numeric ISO code for this country
     *
     * @var integer
     */
    private $isoNumeric;

    /**
     * The alpha ISO code (3 letters) for this country
     *
     * @var string
     */
    private $isoAlpha3;

    /**
     * The FIPS code
     *
     * The Federal Information Processing Standard Publication 6-4 (FIPS 6-4) was a five-digit
     * Federal Information Processing Standards code which uniquely identified counties and county
     * equivalents in the United States, certain U.S. possessions, and certain freely associated states.
     *
     * @var string
     */
    private $fipsCode;

    /**
     * The continent; this is a two-letter representation.
     *
     * @var string
     */
    private $continent;

    /**
     * The name of the continent
     *
     * @var string
     */
    private $continentName;

    /**
     * The name of the capital
     *
     * @var string
     */
    private $capital;

    /**
     * The area, in square kilometres
     * @var float
     */
    private $areaInSqKm;

    /**
     * The population of the country
     *
     * @var integer
     */
    private $population;

    /**
     * The currency code (e.g. GBP, USD, EUR)
     *
     * @var string
     */
    private $currencyCode;

    /**
     * The official languages
     *
     * @var array
     */
    private $languages;

    /**
     * The postal code format
     *
     * @var string
     */
    private $postalCodeFormat;

    /**
     * Country constructor.
     *
     * @param string $code
     * @param string|null $name
     */
    public function __construct( $code, $name = null )
    {
        $this->code = $code;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCode( ): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getName( ): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Country
     */
    public function setName( string $name ): Country
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getIsoNumeric(): int
    {
        return $this->isoNumeric;
    }

    /**
     * @param int $isoNumeric
     * @return Country
     */
    public function setIsoNumeric( int $isoNumeric ): Country
    {
        $this->isoNumeric = $isoNumeric;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsoAlpha3(): string
    {
        return $this->isoAlpha3;
    }

    /**
     * @param string $isoAlpha3
     * @return Country
     */
    public function setIsoAlpha3( string $isoAlpha3 ): Country
    {
        $this->isoAlpha3 = $isoAlpha3;
        return $this;
    }

    /**
     * @return string
     */
    public function getFipsCode(): string
    {
        return $this->fipsCode;
    }

    /**
     * @param string $fipsCode
     * @return Country
     */
    public function setFipsCode( string $fipsCode ): Country
    {
        $this->fipsCode = $fipsCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getContinent(): string
    {
        return $this->continent;
    }

    /**
     * @param string $continent
     * @return Country
     */
    public function setContinent( string $continent ): Country
    {
        $this->continent = $continent;
        return $this;
    }

    /**
     * @return string
     */
    public function getContinentName(): string
    {
        return $this->continentName;
    }

    /**
     * @param string $continentName
     * @return Country
     */
    public function setContinentName( string $continentName ): Country
    {
        $this->continentName = $continentName;
        return $this;
    }

    /**
     * @return string
     */
    public function getCapital(): string
    {
        return $this->capital;
    }

    /**
     * @param string $capital
     * @return Country
     */
    public function setCapital( string $capital ): Country
    {
        $this->capital = $capital;
        return $this;
    }

    /**
     * @return float
     */
    public function getAreaInSqKm(): float
    {
        return $this->areaInSqKm;
    }

    /**
     * @param float $areaInSqKm
     * @return Country
     */
    public function setAreaInSqKm( float $areaInSqKm ): Country
    {
        $this->areaInSqKm = $areaInSqKm;
        return $this;
    }

    /**
     * @return int
     */
    public function getPopulation(): int
    {
        return $this->population;
    }

    /**
     * @param int $population
     * @return Country
     */
    public function setPopulation( int $population ): Country
    {
        $this->population = $population;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    /**
     * @param string $currencyCode
     * @return Country
     */
    public function setCurrencyCode( string $currencyCode ): Country
    {
        $this->currencyCode = $currencyCode;
        return $this;
    }

    /**
     * @return array
     */
    public function getLanguages(): array
    {
        return $this->languages;
    }

    /**
     * @param string|array $languages
     * @return Country
     */
    public function setLanguages( $languages ): Country
    {
        $this->languages = ( is_array( $languages ) ) ? $languages : explode( ',', $languages );
        return $this;
    }

    /**
     * @return string
     */
    public function getPostalCodeFormat(): string
    {
        return $this->postalCodeFormat;
    }

    /**
     * @param string $postalCodeFormat
     * @return Country
     */
    public function setPostalCodeFormat( string $postalCodeFormat ): Country
    {
        $this->postalCodeFormat = $postalCodeFormat;
        return $this;
    }

    /**
     * Convert this country into a string representation
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Create an array representation of this country
     *
     * @return array
     */
    public function toArray( )
    {
        $arr = [ ];
        if ( $this->code && strlen( $this->code ) ) {
            $arr[ 'code' ] = $this->code;
        }
        if ( $this->name && strlen( $this->name ) ) {
            $arr[ 'name' ] = $this->name;
        }
        return $arr;
    }

}