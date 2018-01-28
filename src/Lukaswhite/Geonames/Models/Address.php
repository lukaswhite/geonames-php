<?php namespace Lukaswhite\Geonames\Models;

use Lukaswhite\Geonames\Models\PostalCode;

/**
 * Class Address
 *
 * Represents, as the name implies, an address.
 *
 * Since addresses share the data available for a postcode, it extends that class.
 *
 * @package Lukaswhite\Geonames\Models
 */
class Address extends PostalCode
{
    /**
     * The name of the street
     *
     * @var string
     */
    private $street;

    /**
     * The street number
     *
     * @var string
     */
    private $streetNumber;

    /**
     * The place name
     *
     * @var string
     */
    private $placeName;

    /**
     * The MAF/TIGER Feature Class Code (MTFCC) is a 5-digit code assigned by the Census Bureau intended to
     * classify and describe geographic objects or features.
     *
     * @var string
     */
    private $mtfcc;

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     * @return Address
     */
    public function setStreet( string $street ): Address
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStreetNumber()
    {
        return $this->streetNumber;
    }

    /**
     * @param mixed $streetNumber
     * @return Address
     */
    public function setStreetNumber( $streetNumber )
    {
        $this->streetNumber = $streetNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlaceName(): string
    {
        return $this->placeName;
    }

    /**
     * An alias for getPlaceName
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->getPlaceName( );
    }

    /**
     * @param string $placeName
     * @return Address
     */
    public function setPlaceName( string $placeName ): Address
    {
        $this->placeName = $placeName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMtfcc()
    {
        return $this->mtfcc;
    }

    /**
     * @param mixed $mtfcc
     * @return Address
     */
    public function setMtfcc( $mtfcc )
    {
        $this->mtfcc = $mtfcc;
        return $this;
    }

    /**
     * Convert this address into a string representation
     *
     * @return string
     */
    public function __toString()
    {
        if ( $this->streetNumber && strlen( $this->streetNumber ) ) {
            $street = sprintf(
                '%s %s',
                $this->streetNumber,
                $this->street
            );
        } else {
            $street = $this->street;
        }

        return $street;
    }
}