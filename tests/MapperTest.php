<?php

use Lukaswhite\Geonames\Models\Feature;

class MapperTest extends PHPUnit_Framework_TestCase{

    public function testShortXml( )
    {
        $str = $this->getFixture(
            'search',
            'results-short.xml'
        );

        $mapper = new \Lukaswhite\Geonames\Mappers\Xml( );
        $results = $mapper->mapFeatures( simplexml_load_string( $str ) );

        $this->assertInstanceOf( \Lukaswhite\Geonames\Results\Resultset::class, $results );

        $this->assertEquals( 64250, $results->total( ) );

        $uk = $results->getResults( )[ 1 ];
        $this->assertUkShort( $uk );
    }

    public function testMediumXml( )
    {
        $str = $this->getFixture(
            'search',
            'results-medium.xml'
        );

        $mapper = new \Lukaswhite\Geonames\Mappers\Xml( );
        $results = $mapper->mapFeatures( simplexml_load_string( $str ) );

        $this->assertInstanceOf( \Lukaswhite\Geonames\Results\Resultset::class, $results );

        $this->assertEquals( 64250, $results->total( ) );

        $uk = $results->getResults( )[ 1 ];
        $this->assertUkShort( $uk );

        // The country doesn't appear in the short version, but it does the medium
        $this->assertEquals( 'United Kingdom', $uk->getCountry( )->getName( ) );
    }

    public function testFullXml( )
    {
        $str = $this->getFixture(
            'search',
            'results-full.xml'
        );

        $mapper = new \Lukaswhite\Geonames\Mappers\Xml( );
        $results = $mapper->mapFeatures( simplexml_load_string( $str ) );

        $this->assertInstanceOf( \Lukaswhite\Geonames\Results\Resultset::class, $results );

        $this->assertEquals( 64250, $results->total( ) );

        $uk = $results->getResults( )[ 1 ];
        $this->assertUkShort( $uk );

        // The country doesn't appear in the short version, but it does the medium
        $this->assertEquals( 'United Kingdom', $uk->getCountry( )->getName( ) );
        $this->assertEquals( 'United Kingdom of Great Britain and Northern Ireland', $uk->getAsciiName( ) );
        $this->assertEquals( '00', $uk->getAdminCode1( ) );
        $this->assertEquals( 1, $uk->getAdminCodeLevel( ) );
        $this->assertEquals( \Lukaswhite\Geonames\Models\Continent::EUROPE, $uk->getContinentCode( ) );

        $this->assertEquals( 62348447, $uk->getPopulation( ) );
        $this->assertEquals( 71, $uk->getStrm3( ) );
        $this->assertEquals( 57, $uk->getAstergdem( ) );

        $this->assertNotNull( $uk->getBoundingBox( ) );
        $this->assertEquals( -8.65001, $uk->getBoundingBox( )->getWest( ) );
        $this->assertEquals( 60.84581, $uk->getBoundingBox( )->getNorth( ) );
        $this->assertEquals( 33.9175, $uk->getBoundingBox( )->getEast( ) );
        $this->assertEquals( -34.69046, $uk->getBoundingBox( )->getSouth( ) );

        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Timezone::class, $uk->getTimezone( ) );
        $this->assertEquals( 'Europe/London', $uk->getTimezone( )->getName( ) );
        $this->assertEquals( 'Europe/London', ( string ) $uk->getTimezone( ) );
        $this->assertEquals( 1.0, $uk->getTimezone( )->getDstOffset( ) );
        $this->assertEquals( 0.0, $uk->getTimezone( )->getGmtOffset( ) );

        $this->assertEquals( 146, count( $uk->getAlternateNames( ) ) );

        $am = $uk->getAlternateName( 'am' );
        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\AlternateName::class, $am );
        $this->assertEquals( 'am', $am->getLanguage( ) );
        $this->assertEquals( 'እንግሊዝ', $am->getName( ) );
        $this->assertFalse( $am->isPreferred( ) );
        $this->assertFalse( $am->isShort( ) );
        $this->assertFalse( $am->isLink( ) );
        $this->assertFalse( $am->isAbbreviation( ) );
        $this->assertFalse( $am->isPseudoLanguage( ) );

        $ak = $uk->getAlternateName( 'ak' );
        $this->assertTrue( $ak->isPreferred( ) );

        $ak = $uk->getAlternateName( 'ak' );
        $this->assertTrue( $ak->isPreferred( ) );

        $lt = $uk->getAlternateName( 'lt' );
        $this->assertTrue( $lt->isShort( ) );

        $link = $uk->getAlternateName( 'link' );
        $this->assertTrue( $link->isLink( ) );
        $this->assertTrue( $link->isPseudoLanguage( ) );
        $this->assertEquals( 'http://en.wikipedia.org/wiki/United_Kingdom', $link->getName( ) );

        $london = $results->getResults( )[ 6 ];
        $this->assertEquals( 'London', $london->getName( ) );
        $this->assertEquals( 'ENG', $london->getAdminCode1( ) );
        $this->assertEquals( 'GLA', $london->getAdminCode2( ) );
        $this->assertEquals( 2, $london->getAdminCodeLevel( ) );

        $barnet = $results->getResults( )[ 90 ];
        $this->assertEquals( 'Barnet', $barnet->getName( ) );
        $this->assertEquals( 'ENG', $barnet->getAdminCode1( ) );
        $this->assertEquals( 'GLA', $barnet->getAdminCode2( ) );
        $this->assertEquals( 'A2', $barnet->getAdminCode3( ) );
        $this->assertEquals( 3, $barnet->getAdminCodeLevel( ) );

    }


    public function testFullXmlWithDistance( )
    {
        $str = $this->getFixture(
            'reverse-geocoding',
            'near-manchester.xml'
        );

        $mapper = new \Lukaswhite\Geonames\Mappers\Xml( );
        $results = $mapper->mapFeatures( simplexml_load_string( $str ) );

        $this->assertEquals( 5.03799, $results->first( )->getDistance( ) );

    }

    public function testPostalCodes( )
    {

        $str = $this->getFixture(
            'postal-codes',
            'manchester.xml'
        );

        $mapper = new \Lukaswhite\Geonames\Mappers\Xml( );
        $results = $mapper->mapPostalCodes( simplexml_load_string( $str ) );

        $this->assertInstanceOf( \Lukaswhite\Geonames\Results\Resultset::class, $results );

        $m3 = $results->getResults( )[ 0 ];
        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\PostalCode::class, $m3 );
        $this->assertEquals( 'M3', $m3->getPostalCode( ) );
        $this->assertEquals( 'M3', $m3->__toString( ) );
        $this->assertEquals( 'M3', ( string ) $m3 );
        $this->assertEquals( 'Manchester', $m3->getName( ) );
        $this->assertEquals( 'GB', $m3->getCountryCode( ) );
        $this->assertEquals( 'ENG', $m3->getAdminCode1( ) );
        $this->assertEquals( 'England', $m3->getAdminName1( ) );
        $this->assertEquals( '2648108', $m3->getAdminCode2( ) );
        $this->assertEquals( 'Greater Manchester', $m3->getAdminName2( ) );
        $this->assertEquals( '', $m3->getAdminName3( ) );
        $this->assertEquals( 2, $m3->getAdminCodeLevel( ) );
        $this->assertEquals( 0.00048, $m3->getDistance( ) );
        $this->assertEquals( 53.48095, $m3->getLatitude( ) );
        $this->assertEquals( -2.23743, $m3->getLongitude( ) );

    }

    public function testMappingAddress( )
    {
        $str = $this->getFixture(
            'nearby',
            'address.xml'
        );

        $xml = simplexml_load_string( $str );

        $mapper = new \Lukaswhite\Geonames\Mappers\Xml( );
        $address = $mapper->mapAddress( $xml->address[ 0 ] );

        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Address::class, $address );

        $this->assertEquals( 'Roble Ave', $address->getStreet( ) );
        $this->assertEquals( '649', $address->getStreetNumber( ) );
        $this->assertEquals( '94025', $address->getPostalCode( ) );
        $this->assertEquals( 'US', $address->getCountryCode( ) );
        $this->assertEquals( 'CA', $address->getAdminCode1( ) );
        $this->assertEquals( 'California', $address->getAdminName1( ) );
        $this->assertEquals( '081', $address->getAdminCode2( ) );
        $this->assertEquals( 'San Mateo', $address->getAdminName2( ) );
        $this->assertEquals( 0.04, $address->getDistance( ) );
        $this->assertEquals( 37.45127, $address->getLatitude( ) );
        $this->assertEquals( -122.18032, $address->getLongitude( ) );
        $this->assertEquals( 'S1400', $address->getMtfcc( ) );
        $this->assertEquals( 'Menlo Park', $address->getPlaceName( ) );
        $this->assertEquals( 'Menlo Park', $address->getName( ) );

    }

    public function testMappingCountry( )
    {
        $str = $this->getFixture(
            'countries',
            'united-kingdom.xml'
        );

        $xml = simplexml_load_string( $str );

        $mapper = new \Lukaswhite\Geonames\Mappers\Xml( );
        $country = $mapper->mapCountry( $xml->country[ 0 ] );

        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Country::class, $country );

        $this->assertEquals( 'United Kingdom', $country->getName( ) );
        $this->assertEquals( 2635167, $country->getId( ) );
        $this->assertEquals( 826, $country->getIsoNumeric( ) );
        $this->assertEquals( 'GBR', $country->getIsoAlpha3( ) );
        $this->assertEquals( 'UK', $country->getFipsCode( ) );
        $this->assertEquals( \Lukaswhite\Geonames\Models\Continent::EUROPE, $country->getContinent( ) );
        $this->assertEquals( 'Europe', $country->getContinentName( ) );
        $this->assertEquals( 'London', $country->getCapital( ) );
        $this->assertEquals( 244820.0, $country->getAreaInSqKm( ) );
        $this->assertEquals( 62348447, $country->getPopulation( ) );
        $this->assertEquals( 'GBP', $country->getCurrencyCode( ) );
        $this->assertEquals( [ 'en-GB', 'cy-GB', 'gd' ], $country->getLanguages( ) );
        $this->assertEquals( '@# #@@|@## #@@|@@# #@@|@@## #@@|@#@ #@@|@@#@ #@@|GIR0AA', $country->getPostalCodeFormat( ) );
        $this->assertEquals( -8.61772077108559, $country->getBoundingBox( )->getWest( ) );
        $this->assertEquals( 59.3607741849963, $country->getBoundingBox( )->getNorth( ) );
        $this->assertEquals( 1.7689121033873, $country->getBoundingBox( )->getEast( ) );
        $this->assertEquals( 49.9028622252397, $country->getBoundingBox( )->getSouth( ) );
    }

    public function testMappingCountries( )
    {
        $str = $this->getFixture(
            'countries',
            'all.xml'
        );

        $xml = simplexml_load_string( $str );

        $mapper = new \Lukaswhite\Geonames\Mappers\Xml( );
        $results = $mapper->mapCountries( $xml );

        $this->assertEquals( 250, $results->count( ) );

        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Country::class, $results[ 0 ] );
        $this->assertEquals( 'Andorra', $results[ 0 ]->getName( ) );

    }

    public function testMappingTimezone( )
    {
        $str = $this->getFixture(
            'timezones',
            'europe-london-gb.xml'
        );

        $xml = simplexml_load_string( $str );

        $mapper = new \Lukaswhite\Geonames\Mappers\Xml( );
        $timezone = $mapper->mapTimezone( $xml->timezone[ 0 ] );

        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Timezone::class, $timezone );

        $country = $timezone->getCountry( );
        $this->assertEquals( 'GB', $country->getCode( ) );
        $this->assertEquals( 'United Kingdom', $country->getName( ) );

        $this->assertEquals( 'Europe/London', $timezone->getName( ) );
        $this->assertEquals( 53.41667, $timezone->getLatitude( ) );
        $this->assertEquals( -2.25, $timezone->getLongitude( ) );

        $this->assertEquals( 1.0, $timezone->getDstOffset( ) );
        $this->assertEquals( 0.0, $timezone->getGmtOffset( ) );
        $this->assertEquals( 0.0, $timezone->getRawOffset( ) );


        $this->assertEquals( '2018-01-29 08:14', $timezone->getTime( ) );
        $this->assertEquals( '2018-01-29 07:59', $timezone->getSunrise( ) );
        $this->assertEquals( '2018-01-29 16:45', $timezone->getSunset( ) );
    }

    public function testMappingCountrySubdivisions( )
    {
        $str = $this->getFixture(
            'country-subdivisions',
            'austria.xml'
        );

        $xml = simplexml_load_string( $str );

        $mapper = new \Lukaswhite\Geonames\Mappers\Xml( );
        $results = $mapper->mapCountrySubdivisions( $xml );

        $this->assertEquals( 6, $results->count( ) );

        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\CountrySubdivision::class, $results[ 0 ] );
        $tyrol = $results->first( );

        $this->assertEquals( 'AT', $tyrol->getCountryCode( ) );
        $this->assertEquals( 'Austria', $tyrol->getCountryName( ) );
        $this->assertEquals( '07', $tyrol->getAdminCode1( ) );
        $this->assertEquals( 'Tyrol', $tyrol->getAdminName1( ) );
        $this->assertEquals( 0.0, $tyrol->getDistance( ) );
        $this->assertEquals( 7, $tyrol->getCode( )->getName( ) );
        $this->assertEquals( 1, $tyrol->getCode( )->getLevel( ) );
        $this->assertEquals( 'ISO3166-2', $tyrol->getCode( )->getType( ) );
        $this->assertEquals( 'Tyrol', $tyrol->getName( ) );
        $this->assertEquals( 'Tyrol, Austria', ( string ) $tyrol );

        $switzerland = $results[ 2 ];
        $this->assertEquals( 'CH', $switzerland->getCountryCode( ) );
        $this->assertEquals( 'Switzerland', $switzerland->getCountryName( ) );
        $this->assertEquals( 11.273608957781, $switzerland->getDistance( ) );
        $this->assertEquals( 'Switzerland', $switzerland->getName( ) );
    }

    public function testMappingOcean( )
    {
        $str = $this->getFixture(
            'oceans',
            'north-atlantic-ocean.xml'
        );

        $xml = simplexml_load_string( $str );

        $mapper = new \Lukaswhite\Geonames\Mappers\Xml( );
        $ocean = $mapper->mapOcean( $xml );

        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Ocean::class, $ocean );
        $this->assertEquals( 'North Atlantic Ocean', $ocean->getName( ) );
    }

    public function testMappingNeighbourhood( )
    {
        $str = $this->getFixture(
            'neighbourhoods',
            'central-park.xml'
        );

        $xml = simplexml_load_string( $str );

        $mapper = new \Lukaswhite\Geonames\Mappers\Xml( );
        $neighbourhood = $mapper->mapNeighbourhood( $xml->neighbourhood[ 0 ] );

        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Neighbourhood::class, $neighbourhood );
        $this->assertEquals( 'Central Park', $neighbourhood->getName( ) );
        $this->assertEquals( 'New York City-Manhattan', $neighbourhood->getCity( ) );
        $this->assertEquals( 'NY', $neighbourhood->getAdminCode1( ) );
        $this->assertEquals( 'New York', $neighbourhood->getAdminName1( ) );
        $this->assertEquals( '061', $neighbourhood->getAdminCode2( ) );
        $this->assertEquals( 'New York County', $neighbourhood->getAdminName2( ) );
        $this->assertEquals( 'US', $neighbourhood->getCountryCode( ) );
        $this->assertEquals( 'United States', $neighbourhood->getCountryName( ) );

    }

    public function testMappingPointsOfInterest( )
    {
        $str = $this->getFixture(
            'poi',
            'menlo-park.xml'
        );

        $xml = simplexml_load_string( $str );

        $mapper = new \Lukaswhite\Geonames\Mappers\Xml( );
        $results = $mapper->mapPointsOfInterest( $xml );

        $this->assertInstanceOf( \Lukaswhite\Geonames\Results\Resultset::class, $results );

        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\PointOfInterest::class, $results->first( ) );
        $this->assertEquals( 'amenity', $results->first( )->getTypeClass( ) );
        $this->assertEquals( '', $results->first( )->getName( ) );
        $this->assertEquals( 'fire_hydrant', ( string ) $results->first( ) );
        $this->assertEquals( 'fire_hydrant', $results->first( )->getTypeName( ) );
        $this->assertEquals( 37.45131, $results->first( )->getCoordinates( )->getLatitude( ) );
        $this->assertEquals( -122.18023, $results->first( )->getCoordinates( )->getLongitude( ) );
        $this->assertEquals( 0.04, $results->first( )->getDistance( ) );

        $this->assertEquals( 'Jenny Craig Weight Loss', $results[ 3 ]->getName( ) );
        $this->assertEquals( 'Jenny Craig Weight Loss', (string ) $results[ 3 ] );
    }

    private function assertUkShort( $uk )
    {
        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Feature::class, $uk );

        $this->assertEquals( 2635167, $uk->getId( ) );
        $this->assertEquals( 'United Kingdom', $uk->getName( ) );
        $this->assertEquals( 'United Kingdom of Great Britain and Northern Ireland', $uk->getToponymName( ) );
        $this->assertNotNull( $uk->getCoordinates( ) );
        $this->assertEquals( 54.75844, $uk->getCoordinates( )->getLatitude( ) );
        $this->assertEquals( -2.69531, $uk->getCoordinates( )->getLongitude( ) );
        $this->assertEquals( 'A', $uk->getFcl( ) );
        $this->assertEquals( 'PCLI', $uk->getFcode( ) );
        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Classification::class, $uk->getClassification( ) );
        $this->assertEquals( 'A', $uk->getClassification( )->getClass( ) );
        $this->assertEquals( 'PCLI', $uk->getClassification( )->getCode( ) );
        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Country::class, $uk->getCountry( ) );
        $this->assertEquals( 'GB', $uk->getCountry( )->getCode( ) );
    }

    private function getFixture( $type, $filename )
    {
        return file_get_contents(
            sprintf(
                '%s%sfixtures%s%s%s%s',
                __DIR__,
                DIRECTORY_SEPARATOR,
                DIRECTORY_SEPARATOR,
                $type,
                DIRECTORY_SEPARATOR,
                $filename
            )
        );
    }

}