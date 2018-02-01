<?php namespace Lukaswhite\Geonames\Mappers;

use Lukaswhite\Geonames\Contracts\HasAdminCodeNames;
use Lukaswhite\Geonames\Contracts\HasAdministrativeAreas;
use Lukaswhite\Geonames\Models\AdministrativeArea;
use Lukaswhite\Geonames\Models\BoundingBox;
use Lukaswhite\Geonames\Models\CountrySubdivision;
use Lukaswhite\Geonames\Models\Neighbourhood;
use Lukaswhite\Geonames\Models\Ocean;
use Lukaswhite\Geonames\Models\PointOfInterest;
use Lukaswhite\Geonames\Models\Timezone;
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
 * This class is responsible for mapping XML responses from the Geonames API to models, result sets etc.
 *
 * @package Lukaswhite\Geonames\Mappers
 */
class Xml
{
    /**
     * Map a collection of Geoname features, in XML format, to a resultset
     *
     * @param \SimpleXmlElement $xml
     * @return Resultset
     */
    public function mapFeatures( $xml )
    {
        $results = [ ];

        $total = intval( $xml->totalResultsCount );

        foreach( $xml->geoname as $el ) {
            $results[ ] = $this->mapFeature( $el );
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
    public function mapFeature( \SimpleXMLElement $el )
    {
        $feature = new Feature( );

        if ( $el->geonameId ) {
            $feature->setId( intval( $el->geonameId ) );
        }

        if ( $el->toponymName ) {
            $feature->setToponymName( ( string ) $el->toponymName );
        }

        if ( $el->asciiName ) {
            $feature->setAsciiName( ( string ) $el->asciiName );
        }

        if ( $el->name ) {
            $feature->setName( $el->name );
        }

        if ( $el->continentCode ) {
            $feature->setContinentCode( ( string ) $el->continentCode );
        }

        if ( $el->countryCode ) {
            $country = new Country( ( string ) $el->countryCode );
            if ( $el->countryName ) {
                $country->setName( ( string ) $el->countryName );
            }
            $feature->setCountry( $country );
        }

        if ( $el->fcl ) {
            $feature->setFcl( ( string ) $el->fcl );
        }
        
        if ( $el->fcode ) {
            $feature->setFcode( ( string ) $el->fcode );
        }

        if ( $el->population ) {
            $feature->setPopulation( intval( $el->population ) );
        }

        if ( $el->elevation ) {
            $feature->setElevation( intval( $el->elevation ) );
        }

        if ( $el->srtm3 ) {
            $feature->setStrm3( intval( $el->srtm3 ) );
        }

        if ( $el->astergdem ) {
            $feature->setAstergdem( intval( $el->astergdem ) );
        }

        if ( $el->distance ) {
            $feature->setDistance( floatval( $el->distance ) );
        }

        if ( $el->score ) {
            $feature->setScore( floatval( $el->score ) );
        }

        if ( $el->bbox ) {
            $boundingBox = new BoundingBox( [
                'west'  => floatval( $el->bbox->west ),
                'north' => floatval( $el->bbox->north ),
                'east'  => floatval( $el->bbox->east ),
                'south' => floatval( $el->bbox->south ),
            ] );
            if ( $el->bbox->accuracyLevel ) {
                $boundingBox->setAccuracyLevel( intval( $el->bbox->accuracyLevel ) );
            }
            $feature->setBoundingBox( $boundingBox );
        }

        if ( $el->alternateName ) {

            foreach( $el->alternateName as $alternateNameEl ) {

                $language = ( string ) $alternateNameEl->attributes( )->lang;
                $name = ( string ) $alternateNameEl[ 0 ];

                $isPreferredName = ( isset( $alternateNameEl->attributes( )->isPreferredName ) )
                    && ( bool ) $alternateNameEl->attributes( )->isPreferredName;
                $isShortName = ( isset( $alternateNameEl->attributes( )->isShortName ) )
                    && ( bool ) $alternateNameEl->attributes( )->isShortName;

                $feature->addAlternateName(
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
            $timezone = new Timezone( );
            $timezone->setName( ( string ) $el->timezone );
            $timezone->setDstOffset( floatval( $el->timezone->attributes( )->dstOffset ) );
            $timezone->setGmtOffset( floatval( $el->timezone->attributes( )->gmtOffset ) );
            $feature->setTimezone( $timezone );
        }

        // Now map the admin codes
        $this->mapAdminCodes( $el, $feature );

        // Now map the admin code names
        $this->mapAdminCodeNames( $el, $feature );

        // Now map the administrative areas
        $this->mapAdministrativeAreas( $el, $feature );

        // Now map the coordinates
        $this->mapCoordinates( $el, $feature );

        return $feature;
    }

    /**
     * Map a collection of countries, in XML format, to a resultset
     *
     * @param \SimpleXmlElement $xml
     * @return Resultset
     */
    public function mapCountries( $xml )
    {
        $results = [ ];
        foreach( $xml->country as $el ) {
            $results[ ] = $this->mapCountry( $el );
        }

        $resultset = new Resultset( $results );
        return $resultset;
    }

    /**
     * Map a SimpleXml element to a country
     *
     * @param \SimpleXmlElement $el
     * @return Country
     */
    public function mapCountry( \SimpleXMLElement $el )
    {
        $code = ( string ) $el->countryCode;

        $country = new Country( $code );

        if ( $el->geonameId ) {
            $country->setId( intval( $el->geonameId ) );
        }

        if ( $el->countryName ) {
            $country->setName( ( string ) $el->countryName );
        }

        if ( $el->isoNumeric ) {
            $country->setIsoNumeric( intval( $el->isoNumeric ) );
        }

        if ( $el->isoAlpha3 ) {
            $country->setIsoAlpha3( ( string ) $el->isoAlpha3 );
        }

        if ( $el->fipsCode ) {
            $country->setFipsCode( ( string ) $el->fipsCode );
        }

        if ( $el->continent ) {
            $country->setContinent( ( string ) $el->continent );
        }

        if ( $el->continentName ) {
            $country->setContinentName( $el->continentName );
        }

        if ( $el->capital ) {
            $country->setCapital( ( string ) $el->capital );
        }

        if ( $el->areaInSqKm ) {
            $country->setAreaInSqKm( floatval( $el->areaInSqKm ) );
        }

        if ( $el->population ) {
            $country->setPopulation( intval( $el->population ) );
        }

        if ( $el->currencyCode ) {
            $country->setCurrencyCode( ( string ) $el->currencyCode );
        }

        if ( $el->languages ) {
            $country->setLanguages( ( string ) $el->languages );
        }

        if ( $el->postalCodeFormat ) {
            $country->setPostalCodeFormat( ( string ) $el->postalCodeFormat );
        }

        if (
            ( $el->west ) &&
            ( $el->north ) &&
            ( $el->east ) &&
            ( $el->south ) )
            {
            $boundingBox = new BoundingBox( [
                'west'      =>  floatval( $el->west ),
                'north'     =>  floatval( $el->north ),
                'east'      =>  floatval( $el->east ),
                'south'     =>  floatval( $el->south ),
            ] );
            $country->setBoundingBox( $boundingBox );
        }

        return $country;

    }

    /**
     * Map a SimpleXml element to an ocean
     *
     * @param \SimpleXmlElement $el
     * @return Ocean
     */
    public function mapOcean( \SimpleXMLElement $el )
    {
        $name = ( string ) $el->ocean->name;
        return new Ocean( $name );
    }

    /**
     * Map a SimpleXml element to a collection of country subdivisions
     *
     * @param \SimpleXmlElement $xml
     * @return Resultset
     */
    public function mapCountrySubdivisions( $xml )
    {
        $results = [ ];

        foreach( $xml->countrySubdivision as $el ) {
            $results[ ] = $this->mapCountrySubdivision( $el );
        }

        return new Resultset( $results );

    }

    /**
     * @param \SimpleXMLElement $el
     * @return CountrySubdivision
     */
    public function mapCountrySubdivision( \SimpleXMLElement $el )
    {
        $countrySubdivision = new CountrySubdivision( );

        if ( $el->countryCode ) {
            /**
            $country = new Country( $el->countryCode );
            if ( $el->countryName ) {
                $country->setName( $el->countryName );
            }
            $feature->setCountry( $country );
             **/
        }

        if ( $el->countryCode ) {
            $countrySubdivision->setCountryCode( ( string ) $el->countryCode );
        }

        if ( $el->countryName ) {
            $countrySubdivision->setCountryName( ( string ) $el->countryName );
        }

        if ( $el->code ) {
            $countrySubdivision->getCode( )->setName( ( string ) $el->code );
            $countrySubdivision->getCode( )->setLevel( intval( $el->code->attributes( )->level ) );
            $countrySubdivision->getCode( )->setType( $el->code->attributes( )->type );
        }

        if ( $el->distance ) {
            $countrySubdivision->setDistance( floatval( $el->distance ) );
        }

        // Now map the admin codes
        $this->mapAdminCodes( $el, $countrySubdivision );

        // Now map the admin code names
        $this->mapAdminCodeNames( $el, $countrySubdivision );

        // Now map the administrative areas
        $this->mapAdministrativeAreas( $el, $countrySubdivision );

        return $countrySubdivision;
    }

    /**
     * Map a collection of postal codes, in XML format, to a resultset
     *
     * @param \SimpleXmlElement $xml
     * @return Resultset
     */
    public function mapPostalCodes( $xml )
    {
        $results = [ ];

        foreach( $xml->code as $el ) {
            $results[ ] = $this->mapPostalCode( $el );
        }

        // A set of codes may or may not have a total results count
        if ( $xml->totalResultsCount ) {
            $resultset = new Resultset( $results, intval( $xml->totalResultsCount ) );
        } else {
            $resultset = new Resultset( $results );
        }

        return $resultset;
    }

    /**
     * Map a SimpleXml element to a postal code
     *
     * @param \SimpleXmlElement $el
     * @return PostalCode
     */
    public function mapPostalCode( \SimpleXMLElement $el )
    {
        $code = new PostalCode( );

        $this->mapPostalCodeData( $el, $code );

        return $code;
    }

    /**
     * Map a SimpleXml element to data shared between postal codes and addresses
     *
     * @param \SimpleXmlElement $el
     * @return PostalCode
     */
    public function mapPostalCodeData( \SimpleXMLElement $el, PostalCode $model )
    {
        // Map the actual postal code
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

        // Now map the admin codes
        $this->mapAdminCodes( $el, $model );

        // Now map the admin code names
        $this->mapAdminCodeNames( $el, $model );

        // Now map the administrative areas
        $this->mapAdministrativeAreas( $el, $model );

        // Now map the coordinates
        $this->mapCoordinates( $el, $model );

    }

    /**
     * Map a SimpleXml element to an address
     *
     * @param \SimpleXmlElement $el
     * @return Address
     */
    public function mapAddress( \SimpleXMLElement $el )
    {
        $address = new Address( );

        $this->mapPostalCodeData( $el, $address );

        if ( $el->street ) {
            $address->setStreet( ( string ) $el->street );
        }

        if ( $el->streetNumber ) {
            $address->setStreetNumber( ( string ) $el->streetNumber );
        }

        if ( $el->placename ) {
            $address->setPlaceName( ( string ) $el->placename );
        }

        if ( $el->mtfcc ) {
            $address->setMtfcc( ( string ) $el->mtfcc );
        }

        return $address;
    }

    /**
     * Map a SimpleXml element to a timezone
     *
     * @param \SimpleXmlElement $el
     * @return Timezone
     */
    public function mapTimezone( \SimpleXMLElement $el )
    {
        $timezone = new Timezone( );

        if ( $el->timezoneId ) {
            $timezone->setName( ( string ) $el->timezoneId );
        }

        if ( $el->countryCode ) {
            $country = new Country( ( string ) $el->countryCode );
            if ( $el->countryName ) {
                $country->setName( ( string ) $el->countryName );
            }
            $timezone->setCountry( $country );
        }

        $this->mapCoordinates( $el, $timezone );

        if ( $el->dstOffset ) {
            $timezone->setDstOffset( floatval( $el->dstOffset ) );
        }

        if ( $el->gmtOffset ) {
            $timezone->setGmtOffset( floatval( $el->gmtOffset ) );
        }

        if ( $el->rawOffset ) {
            $timezone->setRawOffset( floatval( $el->rawOffset ) );
        }

        if ( $el->time ) {
            $timezone->setTime( ( string ) $el->time );
        }

        if ( $el->sunrise ) {
            $timezone->setSunrise( ( string ) $el->sunrise );
        }

        if ( $el->sunset ) {
            $timezone->setSunset( ( string ) $el->sunset );
        }

        return $timezone;
    }

    /**
     * Map a neighbourhood from a SimpleXml element to a model
     *
     * @param \SimpleXMLElement $el
     * @return Neighbourhood
     */
    public function mapNeighbourhood( $el )
    {
        $neighbourhood = new Neighbourhood( );

        if ( $el->countryCode ) {
            /**
            $country = new Country( ( string ) $el->countryCode );
            if ( $el->countryName ) {
                $country->setName( ( string ) $el->countryName );
            }
            $feature->setCountry( $country );
             **/
        }

        if ( $el->name ) {
            $neighbourhood->setName( ( string ) $el->name );
        }

        if ( $el->countryCode ) {
            $neighbourhood->setCountryCode( ( string ) $el->countryCode );
        }

        if ( $el->countryName ) {
            $neighbourhood->setCountryName( ( string ) $el->countryName );
        }

        if ( $el->city ) {
            $neighbourhood->setCity( ( string ) $el->city );
        }

        $this->mapAdminCodes( $el, $neighbourhood );
        $this->mapAdminCodeNames( $el, $neighbourhood );

        // Now map the administrative areas
        $this->mapAdministrativeAreas( $el, $neighbourhood );

        return $neighbourhood;
    }

    /**
     * Map points of interest to a resultt set
     *
     * @param \SimpleXMLElement $xml
     * @return Resultset
     */
    public function mapPointsOfInterest( \SimpleXMLElement $xml )
    {
        $results = [ ];

        foreach( $xml->poi as $el ) {
            $results[ ] = $this->mapPointOfInterest( $el );
        }

        $resultset = new Resultset( $results );
        return $resultset;
    }

    /**
     * Map an XML element to a Point Of Interest model
     *
     * @param \SimpleXMLElement $el
     * @return PointOfInterest
     */
    public function mapPointOfInterest( \SimpleXMLElement $el )
    {
        $poi = new PointOfInterest( );

        if ( $el->name ) {
            $poi->setName( ( string ) $el->name );
        }

        if ( $el->typeClass ) {
            $poi->setTypeClass( ( string ) $el->typeClass );
        }

        if ( $el->typeName ) {
            $poi->setTypeName( ( string ) $el->typeName );
        }

        if ( $el->distance ) {
            $poi->setDistance( ( float ) $el->distance );
        }

        $this->mapCoordinates( $el, $poi );

        return $poi;
    }

    /**
     * Map administrative areas from a SimpleXml element to a model
     *
     * @param \SimpleXMLElement $el
     * @param $model
     */
    private function mapAdministrativeAreas( \SimpleXMLElement $el, HasAdministrativeAreas $model )
    {
        if ( $el->adminCode1 ) {
            $model->addAdministrativeArea(
                new AdministrativeArea(
                    ( string ) $el->adminCode1,
                    1,
                    ( isset( $el->adminName1 ) ) ? ( string ) $el->adminName1 : null
                )
            );
        }

        if ( $el->adminCode2 ) {
            $model->addAdministrativeArea(
                new AdministrativeArea(
                    ( string ) $el->adminCode2,
                    2,
                    ( isset( $el->adminName2 ) ) ? ( string ) $el->adminName2 : null
                )
            );
        }

        if ( $el->adminCode3 ) {
            $model->addAdministrativeArea(
                new AdministrativeArea(
                    ( string ) $el->adminCode3,
                    3,
                    ( isset( $el->adminName3 ) ) ? ( string ) $el->adminName3 : null
                )
            );
        }
    }

    /**
     * Map admin codes from a SimpleXml element to a model
     *
     * @param \SimpleXMLElement $el
     * @param $model
     */
    private function mapAdminCodes( \SimpleXMLElement $el, HasAdminCodes $model )
    {
        if ( $el->adminCode1 ) {
            $model->setAdminCode1( ( string ) $el->adminCode1 );
        }

        if ( $el->adminCode2 ) {
            $model->setAdminCode2( ( string ) $el->adminCode2 );
        }

        if ( $el->adminCode3 ) {
            $model->setAdminCode3( ( string ) $el->adminCode3 );
        }

        if ( $el->adminCode1 ) {
            //$model->add
        }
    }

    /**
     * Map admin code names from a SimpleXml element to a model
     *
     * @param \SimpleXMLElement $el
     * @param $model
     */
    private function mapAdminCodeNames( \SimpleXMLElement $el, HasAdminCodeNames $model )
    {
        if ( $el->adminName1 ) {
            $model->setAdminName1( ( string ) $el->adminName1 );
        }

        if ( $el->adminName2 ) {
            $model->setAdminName2( ( string ) $el->adminName2 );
        }

        if ( $el->adminName3 ) {
            $model->setAdminName3( ( string ) $el->adminName3 );
        }
    }

    /**
     * Map co-ordinates from a SimpleXml element to a model
     *
     * @param \SimpleXMLElement $el
     * @param $model
     */
    private function mapCoordinates( \SimpleXMLElement $el, HasCoordinates $model )
    {
        if ( $el->lat && $el->lng ) {
            $model->setCoordinates( new Coordinate( [
                floatval( $el->lat ),
                floatval( $el->lng ),
            ] ) );
        }
    }

}