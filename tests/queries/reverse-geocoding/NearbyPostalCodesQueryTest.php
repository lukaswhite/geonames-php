<?php

use Lukaswhite\Geonames\Query\ReverseGeocoding\NearbyPostalCodes;

class NearbyPostalCodesQueryTest extends PHPUnit_Framework_TestCase{

    public function testIsThereAnySyntaxError( )
    {
        $var = new NearbyPostalCodes( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertTrue( is_object( $var ) );
        unset( $var );
    }

    public function testReturnsTheUri( )
    {
        $search = new NearbyPostalCodes( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertEquals( 'findNearbyPostalCodes', $search->getUri( ) );
    }

    public function testDeclaresWhatItExpects( )
    {
        $search = new NearbyPostalCodes( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertEquals( 'codes', $search->expects( ) );
    }

    public function testLatLngIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $search = new NearbyPostalCodes( $coordinates );


        $this->assertArrayHasKey( 'lat', $search->build( ) );
        $this->assertEquals( 53.41667, $search->build( )[ 'lat' ] );
        $this->assertArrayHasKey( 'lng', $search->build( ) );
        $this->assertEquals( -2.25, $search->build( )[ 'lng' ] );

    }

    public function testRadiusIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $search = new NearbyPostalCodes( $coordinates );
        $search->withinRadius( 25 );

        $this->assertArrayHasKey( 'radius', $search->build( ) );
        $this->assertEquals( 25, $search->build( )[ 'radius' ] );

    }

    public function testStyleIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $search = new NearbyPostalCodes( $coordinates );

        $search->withinRadius( 25 )->full( );

        $this->assertArrayHasKey( 'style', $search->build( ) );
        $this->assertEquals( 'FULL', $search->build( )[ 'style' ] );

    }


    public function testMaxRowsIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $search = new NearbyPostalCodes( $coordinates );

        $search->withinRadius( 25 )
            ->full( )
            ->limit( 25 );

        $this->assertArrayHasKey( 'maxRows', $search->build( ) );
        $this->assertEquals( 25, $search->build( )[ 'maxRows' ] );
    }

    public function testLocalCountryIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $search = new NearbyPostalCodes( $coordinates );

        $search->withinRadius( 25 )->full( )
            ->limit( 25 )
            ->justLocalCountry( );

        $this->assertArrayHasKey( 'localCountry', $search->build( ) );
        $this->assertEquals( true, $search->build( )[ 'localCountry' ] );
    }

}