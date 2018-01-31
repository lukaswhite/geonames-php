<?php namespace Lukaswhite\Geonames\Contracts;

/**
 * Interface HasPostalCodeData
 *
 * @package Lukaswhite\Geonames\Contracts
 */
interface HasPostalCodeData
{
    /**
     * @return string
     */
    public function getPostalCode(): string;

    /**
     * @param string $postalCode
     * @return $this
     */
    public function setPostalCode( string $postalCode );

    /**
     * @return mixed
     */
    public function getDistance();

    /**
     * @param mixed $distance
     * @return $this
     */
    public function setDistance( $distance );

    /**
if ( $el->postalcode ) {
$model->setPostalCode( ( string ) $el->postalcode );
}

// Map the distance, if present
if ( $el->distance ) {
    $model->setDistance( floatval( $el->distance ) );
}

// Map the name, if present
if ( $el->name ) {
    $model->setName( ( string ) $el->name );
}

// Map the country code, if present
if ( $el->countryCode ) {
    $model->setCountryCode( ( string ) $el->countryCode );
}
**/
}