<?php namespace Lukaswhite\Geonames\Mappers;

use Lukaswhite\Geonames\Results\Resultset;
use Lukaswhite\Geonames\Models\Coordinate;
use Lukaswhite\Geonames\Models\Address;
use Lukaswhite\Geonames\Models\AlternateName;
use Lukaswhite\Geonames\Models\Country;
use Lukaswhite\Geonames\Models\Feature;
use Lukaswhite\Geonames\Contracts\HasAdminCodes;
use Lukaswhite\Geonames\Contracts\HasCoordinates;
use Lukaswhite\Geonames\Models\PostalCode;

/**
 * Class Xml
 *
 * This class is responsible for mapping XML responses from the Geonames API to models.
 *
 * @package Lukaswhite\Geonames\Mappers
 */
class Xml
{

    /**
     * Map a collection of Geoname places, in XML format, to a resultset
     *
     * @param \SimpleXmlElement $xml
     * @return Resultset
     */
    public static function geonames( $xml )
    {
        $results = [ ];

        $total = intval( $xml->totalResultsCount );

        foreach( $xml->geoname as $el ) {
            $results[ ] = self::geoname( $el );
        }

        $resultset = new Resultset( $results, $total );
        return $resultset;
    }

    /**
     * Map a geoname XML element to a Geoname instance
     *
     * @param \SimpleXMLElement $el
     * @return Feature
     */
    public static function geoname( \SimpleXMLElement $el )
    {
        $geoname = new Feature( );

        if ( $el->geonameId ) {
            $geoname->setId( intval( $el->geonameId ) );
        }

        if ( $el->toponymName ) {
            $geoname->setToponymName( $el->toponymName );
        }

        if ( $el->asciiName ) {
            $geoname->setAsciiName( $el->asciiName );
        }

        if ( $el->name ) {
            $geoname->setName( $el->name );
        }

        if ( $el->continentCode ) {
            $geoname->setContinentCode( $el->continentCode );
        }

        if ( $el->countryCode ) {
            $country = new Country( $el->countryCode );
            if ( $el->countryName ) {
                $country->setName( $el->countryName );
            }
            $geoname->setCountry( $country );
        }

        if ( $el->fcl ) {
            $geoname->setFcl( $el->fcl );
        }

        if ( $el->fcode ) {
            $geoname->setFcode( $el->fcode );
        }

        if ( $el->population ) {
            $geoname->setPopulation( intval( $el->population ) );
        }

        if ( $el->elevation ) {
            $geoname->setElevation( intval( $el->elevation ) );
        }

        if ( $el->srtm3 ) {
            $geoname->setStrm3( intval( $el->srtm3 ) );
        }

        if ( $el->astergdem ) {
            $geoname->setAstergdem( intval( $el->astergdem ) );
        }

        if ( $el->bbox ) {
            $geoname->setBoundingBox( [
                'west'  => floatval( $el->bbox->west ),
                'north' => floatval( $el->bbox->north ),
                'east'  => floatval( $el->bbox->east ),
                'south' => floatval( $el->bbox->south ),
            ] );
        }

        if ( $el->alternateName ) {

            foreach( $el->alternateName as $alternateNameEl ) {

                $language = ( string ) $alternateNameEl->attributes( )->lang;
                $name = ( string ) $alternateNameEl[ 0 ];

                $isPreferredName = ( isset( $alternateNameEl->attributes( )->isPreferredName ) )
                    && ( bool ) $alternateNameEl->attributes( )->isPreferredName;
                $isShortName = ( isset( $alternateNameEl->attributes( )->isShortName ) )
                    && ( bool ) $alternateNameEl->attributes( )->isShortName;

                $geoname->addAlternateName(
                    new AlternateName(
                        $language,
                        $name,
                        $isPreferredName,
                        $isShortName
                    )
                );
            }
        }

        if ( $el->timezone ) {
            $geoname->setTimezone( ( string ) $el->timezone );
        }

        // Now map the admin codes
        self::adminCodes( $el, $geoname );

        // Now map the coordinates
        self::coordinates( $el, $geoname );

        return $geoname;
    }

    /**
     * Map a collection of postal codes, in XML format, to a resultset
     *
     * @param \SimpleXmlElement $xml
     * @return Resultset
     */
    public static function codes( $xml )
    {
        $results = [ ];

        foreach( $xml->code as $el ) {
            $results[ ] = self::code( $el );
        }

        $resultset = new Resultset( $results );
        return $resultset;
    }

    /**
     * Map a SimpleXml element to a postal code
     *
     * @param \SimpleXmlElement $el
     * @return PostalCode
     */
    public static function code( \SimpleXMLElement $el )
    {
        $code = new PostalCode( );

        self::codeData( $el, $code );

        return $code;
    }

    /**
     * Map a SimpleXml element to data shared between postal codes and addresses
     *
     * @param \SimpleXmlElement $el
     * @return PostalCode
     */
    public static function codeData( \SimpleXMLElement $el, $model )
    {
        // Map the actual postal code
        if ( $el->postalcode ) {
            $model->setPostalCode( $el->postalcode );
        }

        // Map the distance, if present
        if ( $el->distance ) {
            $model->setDistance( floatval( $el->distance ) );
        }

        // Map the name, if present
        if ( $el->name ) {
            $model->setName( $el->name );
        }

        // Map the country code, if present
        if ( $el->countryCode ) {
            $model->setCountryCode( $el->countryCode );
        }

        // Now map the admin codes
        self::adminCodes( $el, $model );

        // Now map the coordinates
        self::coordinates( $el, $model );

    }

    /**
     * Map a SimpleXml element to an address
     *
     * @param \SimpleXmlElement $el
     * @return Address
     */
    public static function address( \SimpleXMLElement $el )
    {
        $address = new Address( );

        self::codeData( $el, $address );

        if ( $el->street ) {
            $address->setStreet( $el->street );
        }

        if ( $el->streetNumber ) {
            $address->setStreetNumber( $el->streetNumber );
        }

        if ( $el->placename ) {
            $address->setPlaceName( $el->placename );
        }

        if ( $el->mtfcc ) {
            $address->setMtfcc( $el->mtfcc );
        }

        return $address;
    }

    /**
     * Map admin codes from a SimpleXml element to a model
     *
     * @param \SimpleXMLElement $el
     * @param $model
     */
    private static function adminCodes( \SimpleXMLElement $el, HasAdminCodes $model )
    {
        if ( $el->adminCode1 ) {
            $model->setAdminCode1( $el->adminCode1 );
        }

        if ( $el->adminCode2 ) {
            $model->setAdminCode2( $el->adminCode2 );
        }

        if ( $el->adminCode3 ) {
            $model->setAdminCode3( $el->adminCode3 );
        }

        if ( $el->adminName1 ) {
            $model->setAdminName1( $el->adminName1 );
        }

        if ( $el->adminName2 ) {
            $model->setAdminName2( $el->adminName2 );
        }

        if ( $el->adminName3 ) {
            $model->setAdminName3( $el->adminName3 );
        }
    }

    /**
     * Map co-ordinates from a SimpleXml element to a model
     *
     * @param \SimpleXMLElement $el
     * @param $model
     */
    private static function coordinates( \SimpleXMLElement $el, HasCoordinates $model )
    {
        if ( $el->lat && $el->lng ) {
            $model->setCoordinates( new Coordinate( [
                floatval( $el->lat ),
                floatval( $el->lng ),
            ] ) );
        }
    }

}