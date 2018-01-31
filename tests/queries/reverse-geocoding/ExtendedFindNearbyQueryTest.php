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
        $search = new ExtendedFindNearby( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertEquals( 'extendedFindNearby', $search->getUri( ) );
    }

    public function testDeclaresWhatItExpects( )
    {
        $search = new ExtendedFindNearby( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertEquals( 'features|addresses', $search->expects( ) );
    }

    public function testLatLngIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $search = new ExtendedFindNearby( $coordinates );


        $this->assertArrayHasKey( 'lat', $search->build( ) );
        $this->assertEquals( 53.41667, $search->build( )[ 'lat' ] );
        $this->assertArrayHasKey( 'lng', $search->build( ) );
        $this->assertEquals( -2.25, $search->build( )[ 'lng' ] );

    }

}