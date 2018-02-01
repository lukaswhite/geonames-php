<?php

use Lukaswhite\Geonames\Query\ReverseGeocoding\FindNearbyPOIsOSM;

class FindNearbyPOIsOSMQueryTest extends PHPUnit_Framework_TestCase{

    public function testIsThereAnySyntaxError( )
    {
        $var = new FindNearbyPOIsOSM( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertTrue( is_object( $var ) );
        unset( $var );
    }

    public function testReturnsTheUri( )
    {
        $query = new FindNearbyPOIsOSM( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertEquals( 'findNearbyPOIsOSM', $query->getUri( ) );
    }

    public function testDeclaresWhatItExpects( )
    {
        $query = new FindNearbyPOIsOSM( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertEquals( 'pois', $query->expects( ) );
    }

    public function testLatLngIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $query = new FindNearbyPOIsOSM( $coordinates );


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

        $query = new FindNearbyPOIsOSM( $coordinates );
        $query->withinRadius( 25 );

        $this->assertArrayHasKey( 'radius', $query->build( ) );
        $this->assertEquals( 25, $query->build( )[ 'radius' ] );

    }

    public function testMaxRowsIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $query = new FindNearbyPOIsOSM( $coordinates );

        $query->withinRadius( 25 )
            ->limit( 25 );

        $this->assertArrayHasKey( 'maxRows', $query->build( ) );
        $this->assertEquals( 25, $query->build( )[ 'maxRows' ] );
    }


}