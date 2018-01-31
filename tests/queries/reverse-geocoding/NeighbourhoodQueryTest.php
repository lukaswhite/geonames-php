<?php

use Lukaswhite\Geonames\Query\ReverseGeocoding\Neighbourhood;

class NeighbourhoodQueryTest extends PHPUnit_Framework_TestCase{

    public function testIsThereAnySyntaxError( )
    {
        $var = new Neighbourhood( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertTrue( is_object( $var ) );
        unset( $var );
    }

    public function testReturnsTheUri( )
    {
        $search = new Neighbourhood( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertEquals( 'neighbourhood', $search->getUri( ) );
    }

    public function testDeclaresWhatItExpects( )
    {
        $search = new Neighbourhood( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertEquals( 'neighbourhood', $search->expects( ) );
    }

    public function testLatLngIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 40.78343 )
            ->setLongitude( -73.96625 );

        $search = new Neighbourhood( $coordinates );

        $this->assertArrayHasKey( 'lat', $search->build( ) );
        $this->assertEquals( 40.78343, $search->build( )[ 'lat' ] );
        $this->assertArrayHasKey( 'lng', $search->build( ) );
        $this->assertEquals( -73.96625, $search->build( )[ 'lng' ] );

    }


}