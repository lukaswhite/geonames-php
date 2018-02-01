<?php

use Lukaswhite\Geonames\Query\ReverseGeocoding\ExtendedFindNearby;

class ExtendedFindNearbyQueryTest extends PHPUnit_Framework_TestCase{

    public function testIsThereAnySyntaxError( )
    {
        $var = new ExtendedFindNearby( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertTrue( is_object( $var ) );
        unset( $var );
    }

    public function testReturnsTheUri( )
    {
        $query = new ExtendedFindNearby( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertEquals( 'extendedFindNearby', $query->getUri( ) );
    }

    public function testDeclaresWhatItExpects( )
    {
        $query = new ExtendedFindNearby( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertEquals( 'features|addresses', $query->expects( ) );
    }

    public function testLatLngIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $query = new ExtendedFindNearby( $coordinates );


        $this->assertArrayHasKey( 'lat', $query->build( ) );
        $this->assertEquals( 53.41667, $query->build( )[ 'lat' ] );
        $this->assertArrayHasKey( 'lng', $query->build( ) );
        $this->assertEquals( -2.25, $query->build( )[ 'lng' ] );

    }

}