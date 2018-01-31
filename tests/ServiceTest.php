<?php

use Lukaswhite\Geonames\Geonames;
use Lukaswhite\Geonames\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;
use Lukaswhite\Geonames\Query\Get;

class ServiceTest extends PHPUnit_Framework_TestCase{

    public function testIsThereAnySyntaxError( )
    {
        $var = new Geonames( 'user123' );
        $this->assertTrue( is_object( $var ) );
        unset( $var );
    }

    public function testSetUsernameInConstructor( )
    {
        $service = new Geonames( 'user123' );

        $this->assertAttributeEquals( 'user123', 'username', $service );
    }

    public function testSetUsername( )
    {
        $service = new Geonames( 'user123' );
        $service->setUsername( 'user456' );

        $this->assertAttributeEquals( 'user456', 'username', $service );
    }

    public function testGet( )
    {
        $client = $this->getClientThatReturns( '/fixtures/get/barnet.xml' );
        $service = new Geonames( 'user123', $client );

        $place = $service->get( 2656295 );
        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Feature::class, $place );
        $this->assertEquals( 'Barnet', $place->getName( ) );
    }

    public function testGetQuery( )
    {
        $client = $this->getClientThatReturns( '/fixtures/get/barnet.xml' );
        $service = new Geonames( 'user123', $client );

        $place = $service->run( ( new Get( ) )->setPlace( 2656295 ) );
        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Feature::class, $place );
        $this->assertEquals( 'Barnet', $place->getName( ) );
    }

    public function testSearch( )
    {
        $client = $this->getClientThatReturns( '/fixtures/search/results.xml' );

        $service = new Geonames( 'user123', $client );

        $query = new \Lukaswhite\Geonames\Query\Search( );
        $query->filterByFeatureClass( 'P' );

        $results = $service->run( $query );
        $this->assertInstanceOf( \Lukaswhite\Geonames\Results\Resultset::class, $results );
        $this->assertEquals( 64250, $results->total( ) );
        $northernEurope = $results->first( );
        $this->assertEquals( 'Northern Europe', $northernEurope->getName( ) );
        $this->assertEquals( 'Northern Europe', $northernEurope->getToponymName( ) );
        $uk = $results->getResults( )[ 1 ];
        $this->assertEquals( 'United Kingdom', $uk->getName( ) );
    }

    public function testPostalCodeSearch( )
    {
        $client = $this->getClientThatReturns( '/fixtures/postal-codes/manchester-full.xml' );
        $service = new Geonames( 'user123', $client );
        $query = new \Lukaswhite\Geonames\Query\PostalCodeSearch( );
        $query->placeName( 'Manchester' )->inCountry( 'GB' )->limit( 50 );
        $results = $service->run( $query );
        $this->assertEquals( 70787, $results->total( ) );
        $this->assertEquals( 50, $results->count( ) );
        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\PostalCode::class, $results->first( ) );
        $this->assertEquals( 'M3 1AR', $results->first( )->getPostalCode( ) );
        $this->assertEquals( 'Manchester', $results->first( )->getName( ) );
        $this->assertEquals( 'ENG', $results->first( )->getAdminCode1( ) );
        $this->assertEquals( 'E08000003', $results->first( )->getAdminCode3( ) );
    }

    public function testTimezoneQuery( )
    {
        $client = $this->getClientThatReturns( '/fixtures/timezones/europe-london-gb.xml' );
        $service = new Geonames( 'user123', $client );
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );
        $query = new \Lukaswhite\Geonames\Query\Timezone( );
        $query->setCoordinates( $coordinates );
        $timezone = $service->run( $query );
        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Timezone::class, $timezone );
        $this->assertEquals( 'Europe/London', $timezone->getName( ) );
        $country = $timezone->getCountry( );
        $this->assertEquals( 'GB', $country->getCode( ) );
        $this->assertEquals( 'United Kingdom', $country->getName( ) );
        $this->assertEquals( 53.41667, $timezone->getLatitude( ) );
        $this->assertEquals( -2.25, $timezone->getLongitude( ) );
        $this->assertEquals( 1.0, $timezone->getDstOffset( ) );
        $this->assertEquals( 0.0, $timezone->getGmtOffset( ) );
        $this->assertEquals( 0.0, $timezone->getRawOffset( ) );
        $this->assertEquals( '2018-01-29 08:14', $timezone->getTime( ) );
        $this->assertEquals( '2018-01-29 07:59', $timezone->getSunrise( ) );
        $this->assertEquals( '2018-01-29 16:45', $timezone->getSunset( ) );
    }

    public function testCountryInfoQueryAllCountries( )
    {
        $client = $this->getClientThatReturns( '/fixtures/countries/all.xml' );
        $service = new Geonames( 'user123', $client );
        $results = $service->run( new \Lukaswhite\Geonames\Query\CountryInfo( ) );
        $this->assertEquals( 250, $results->count( ) );

        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Country::class, $results[ 0 ] );
        $this->assertEquals( 'Andorra', $results[ 0 ]->getName( ) );
    }

    public function testCountryInfoQuerySingleCountry( )
    {
        $client = $this->getClientThatReturns( '/fixtures/countries/united-kingdom.xml' );
        $service = new Geonames( 'user123', $client );
        $results = $service->run( ( new \Lukaswhite\Geonames\Query\CountryInfo( ) )->inCountry( 'GB' ) );
        $this->assertEquals( 1, $results->count( ) );
        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Country::class, $results[ 0 ] );
        $this->assertEquals( 'United Kingdom', $results[ 0 ]->getName( ) );
    }

    public function testFindNearbyOcean( )
    {
        $client = $this->getClientThatReturns( '/fixtures/oceans/north-atlantic-ocean.xml' );
        $service = new Geonames( 'user123', $client );
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 40.78343 )
            ->setLongitude( -43.96625 );
        $ocean = $service->run( ( new \Lukaswhite\Geonames\Query\ReverseGeocoding\Ocean( $coordinates ) ) );
        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Ocean::class, $ocean );
        $this->assertEquals( 'North Atlantic Ocean', $ocean );
    }

    public function testFindCountryCode( )
    {
        $client = $this->getClientThatReturns( '/fixtures/reverse-geocoding/country-code.txt' );
        $service = new Geonames( 'user123', $client );
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 47.03 )
            ->setLongitude( 10.2 );
        $country = $service->run( ( new \Lukaswhite\Geonames\Query\ReverseGeocoding\CountryCode( $coordinates ) ) );
        $this->assertInternalType( 'string', $country );
        $this->assertEquals( 'AT', $country );
    }

    public function testFindCountrySubdivision( )
    {
        $client = $this->getClientThatReturns( '/fixtures/country-subdivisions/tyrol.xml' );
        $service = new Geonames( 'user123', $client );
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( [ 47.03, 10.2 ] );
        $results = $service->run( ( new \Lukaswhite\Geonames\Query\ReverseGeocoding\CountrySubdivision( $coordinates ) ) );
        $this->assertInstanceOf( \Lukaswhite\Geonames\Results\Resultset::class, $results );
        $this->assertEquals( 1, $results->count( ) );
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
    }

    public function testFindCountrySubdivisions( )
    {
        $client = $this->getClientThatReturns( '/fixtures/country-subdivisions/austria.xml' );
        $service = new Geonames( 'user123', $client );
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( [ 47.03, 10.2 ] );
        $query = new \Lukaswhite\Geonames\Query\ReverseGeocoding\CountrySubdivision( $coordinates );
        $query->withinRadius( 10 )->limit( 10 );
        $results = $service->run( $query );
        $this->assertInstanceOf( \Lukaswhite\Geonames\Results\Resultset::class, $results );
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

    public function testNeighbourhoodQuery( )
    {
        $client = $this->getClientThatReturns( '/fixtures/neighbourhoods/central-park.xml' );
        $service = new Geonames( 'user123', $client );

        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 40.78343 )
            ->setLongitude( -73.96625 );

        $query = new \Lukaswhite\Geonames\Query\ReverseGeocoding\Neighbourhood( $coordinates );
        $neighbourhood = $service->run( $query );
        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Neighbourhood::class, $neighbourhood );
        $this->assertEquals( 'Central Park', $neighbourhood->getName( ) );
        $this->assertEquals( 'Central Park', ( string ) $neighbourhood );
        $this->assertEquals( 'New York City-Manhattan', $neighbourhood->getCity( ) );
        $this->assertEquals( 'NY', $neighbourhood->getAdminCode1( ) );
        $this->assertEquals( 'New York', $neighbourhood->getAdminName1( ) );
        $this->assertEquals( '061', $neighbourhood->getAdminCode2( ) );
        $this->assertEquals( 'New York County', $neighbourhood->getAdminName2( ) );
        $this->assertEquals( 'US', $neighbourhood->getCountryCode( ) );
        $this->assertEquals( 'United States', $neighbourhood->getCountryName( ) );

    }

    public function testLogger( )
    {
        $client = $this->getClientThatReturns( '/fixtures/get/barnet.xml' );
        $service = new Geonames( 'user123', $client );
        $logger = new \WMDE\PsrLogTestDoubles\LoggerSpy( );
        $service->setLogger( $logger );
        $place = $service->get( 2656295 );

        $this->assertSame(
            [
                'http://api.geonames.org/get?geonameId=2656295&username=user123',
                file_get_contents( __DIR__ . '/fixtures/get/barnet.xml' )
            ],
            $logger->getLogCalls()->getMessages()
        );

        $this->assertSame( \Psr\Log\LogLevel::INFO, $logger->getFirstLogCall( )->getLevel() );

    }

    /**
     * @expectedException \Lukaswhite\Geonames\Exceptions\AuthException
     * @expectedExceptionMessage Please add a username to each call in order for geonames to be able to identify the calling application and count the credits usage.
     */
    public function testUsernameNotProvided( )
    {
        $client = $this->getClientThatReturns( '/fixtures/errors/username-not-provided.xml' );
        $service = new Geonames( 'user123', $client );
        $query = new Get( );
        $query->setPlace( 2656295 );
        $service->run( ( new Get( ) )->setPlace( 2656295 ) );
    }

    /**
     * @expectedException \Lukaswhite\Geonames\Exceptions\AuthException
     * @expectedExceptionMessage user does not exist.
     */
    public function testUsernameDoesNotExist( )
    {
        $client = $this->getClientThatReturns( '/fixtures/errors/username-does-not-exist.xml' );
        $service = new Geonames( 'user123', $client );
        $query = new Get( );
        $query->setPlace( 2656295 );
        $service->run( ( new Get( ) )->setPlace( 2656295 ) );
    }

    /**
     * @expectedException \Lukaswhite\Geonames\Exceptions\MaxRequestsExceededException
     */
    public function testMaximumRequestsExceeded( )
    {
        $client = $this->getClientThatReturns( '/fixtures/errors/max-requests-exceeded.xml' );
        $service = new Geonames( 'user123', $client );
        $query = new Get( );
        $query->setPlace( 2656295 );
        $service->run( ( new Get( ) )->setPlace( 2656295 ) );
    }

    /**
     * @expectedException \Lukaswhite\Geonames\Exceptions\InvalidXmlException
     */
    public function testInvalidXml( )
    {
        $client = $this->getClientThatReturns( '/fixtures/errors/invalid-xml.xml' );
        $service = new Geonames( 'user123', $client );
        $query = new Get( );
        $query->setPlace( 2656295 );
        $service->run( ( new Get( ) )->setPlace( 2656295 ) );
    }

    /**
     * @expectedException \Lukaswhite\Geonames\Exceptions\InvalidXmlException
     */
    public function testBrokenXml( )
    {
        $client = $this->getClientThatReturns( '/fixtures/errors/broken-xml.xml' );
        $service = new Geonames( 'user123', $client );
        $query = new Get( );
        $query->setPlace( 2656295 );
        $service->run( ( new Get( ) )->setPlace( 2656295 ) );
    }

    public function ___testLookup( )
    {
        $mock = new MockHandler( [
            new Response( 200, [ ], file_get_contents( __DIR__ . '/fixtures/get/barnet.xml' ) ),
        ] );

        $handler = HandlerStack::create( $mock );

        $client = new Client( [
            'username'  =>  'user123',
            'handler'   =>  $handler,
        ] );

        $place = $client->lookup( 2656295 );
        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Feature::class, $place );
        $this->assertEquals( 'Barnet', $place->getName( ) );
    }

    /**
     * @expectedException \Lukaswhite\Geonames\Exceptions\NotFoundException
     * @expectedExceptionMessage this geonameid does not exist
     */
    public function testGetNotFound( )
    {
        $client = $this->getClientThatReturns( '/fixtures/errors/geonameid-does-not-exist.xml' );
        $service = new Geonames( 'user123', $client );
        $query = new Get( );
        $query->setPlace( 2656295 );
        $service->run( ( new Get( ) )->setPlace( 1 ) );
    }

    /**
     * @expectedException \Lukaswhite\Geonames\Exceptions\InvalidParameterException
     * @expectedExceptionMessage radius is too large.
     */
    public function testInvalidParameter( )
    {
        $client = $this->getClientThatReturns( '/fixtures/errors/radius-too-large.xml' );
        $service = new Geonames( 'user123', $client );
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 40.78343 )
            ->setLongitude( -43.96625 );
        $query = new \Lukaswhite\Geonames\Query\ReverseGeocoding\Ocean( $coordinates );
        $query->withinRadius( 100000 );
        $service->run( $query );
    }

    /**
     * @expectedException \Lukaswhite\Geonames\Exceptions\UnknownErrorException
     * @expectedExceptionMessage some other error
     */
    public function testUnknownErrorException( )
    {
        $client = $this->getClientThatReturns( '/fixtures/errors/other-error.xml' );
        $service = new Geonames( 'user123', $client );
        $query = new Get( );
        $query->setPlace( 2656295 );
        $service->run( ( new Get( ) )->setPlace( 1 ) );
    }

    /**
     * @expectedException \Lukaswhite\Geonames\Exceptions\HttpException
     */
    public function testRequestException( )
    {
        $mock = new MockHandler( [
            new Response( 500, [ ], 'Internal Service Error' ),
        ] );

        $handler = HandlerStack::create( $mock );

        $client = new Client( [
            'handler'   =>  $handler,
        ] );

        $service = new Geonames( 'user123', $client );
        $service->run( ( new Get( ) )->setPlace( 2656295 ) );
    }

    public function testRequestExceptionSetsStatusCode( )
    {
        $mock = new MockHandler( [
            new Response( 500, [ ], 'Internal Service Error' ),
        ] );

        $handler = HandlerStack::create( $mock );

        $client = new Client( [
            'handler'   =>  $handler,
        ] );

        $service = new Geonames( 'user123', $client );
        try {
            $service->run( ( new Get() )->setPlace( 2656295 ) );
        } catch ( \Lukaswhite\Geonames\Exceptions\HttpException $e ) {
            $this->assertEquals( 500, $e->getHttpStatusCode( ) );
        }
    }

    /**
     * @expectedException  \RuntimeException
     * @expectedExceptionMessage Unsupported response
     */
    public function testUnsupportedResponseType( )
    {
        $client = $this->getClientThatReturns( '/fixtures/postal-codes/manchester-full.xml' );
        $service = new Geonames( 'user123', $client );
        $service->run( new QueryWithUnsupportedExpects() );
    }

    private function getClientThatReturns( $filepath )
    {
        $mock = new MockHandler( [
            new Response( 200, [ ], file_get_contents( __DIR__ . $filepath ) ),
        ] );

        $handler = HandlerStack::create( $mock );

        $client = new Client( [
            'handler'   =>  $handler,
        ] );

        return $client;
    }

}

class QueryWithUnsupportedExpects implements \Lukaswhite\Geonames\Contracts\QueriesService {
    public function getUri( ) {
        return 'restaurants';
    }
    public function expects( ) {
        return 'restaurants';
    }
    public function build( ) {
        return [ ];
    }
}