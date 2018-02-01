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
        $query = new NearbyPostalCodes( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertEquals( 'findNearbyPostalCodes', $query->getUri( ) );
    }

    public function testDeclaresWhatItExpects( )
    {
        $query = new NearbyPostalCodes( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertEquals( 'codes', $query->expects( ) );
    }

    public function testLatLngIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $query = new NearbyPostalCodes( $coordinates );


        $this->assertArrayHasKey( 'lat', $query->build( ) );
        $this->assertEquals( 53.41667, $query->build( )[ 'lat' ] );
        $this->assertArrayHasKey( 'lng', $query->build( ) );
        $this->assertEquals( -2.25, $query->build( )[ 'lng' ] );

    }

    public function testRadiusIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $query = new NearbyPostalCodes( $coordinates );
        $query->withinRadius( 25 );

        $this->assertArrayHasKey( 'radius', $query->build( ) );
        $this->assertEquals( 25, $query->build( )[ 'radius' ] );

    }

    public function testStyleIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $query = new NearbyPostalCodes( $coordinates );

        $query->withinRadius( 25 )->full( );

        $this->assertArrayHasKey( 'style', $query->build( ) );
        $this->assertEquals( 'FULL', $query->build( )[ 'style' ] );

    }


    public function testMaxRowsIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $query = new NearbyPostalCodes( $coordinates );

        $query->withinRadius( 25 )
            ->full( )
            ->limit( 25 );

        $this->assertArrayHasKey( 'maxRows', $query->build( ) );
        $this->assertEquals( 25, $query->build( )[ 'maxRows' ] );
    }

    public function testLocalCountryIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $query = new NearbyPostalCodes( $coordinates );

        $query->withinRadius( 25 )->full( )
            ->limit( 25 )
            ->justLocalCountry( );

        $this->assertArrayHasKey( 'localCountry', $query->build( ) );
        $this->assertEquals( true, $query->build( )[ 'localCountry' ] );
    }

}