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
        $query = new Neighbourhood( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertEquals( 'neighbourhood', $query->getUri( ) );
    }

    public function testDeclaresWhatItExpects( )
    {
        $query = new Neighbourhood( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertEquals( 'neighbourhood', $query->expects( ) );
    }

    public function testLatLngIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 40.78343 )
            ->setLongitude( -73.96625 );

        $query = new Neighbourhood( $coordinates );

        $this->assertArrayHasKey( 'lat', $query->build( ) );
        $this->assertEquals( 40.78343, $query->build( )[ 'lat' ] );
        $this->assertArrayHasKey( 'lng', $query->build( ) );
        $this->assertEquals( -73.96625, $query->build( )[ 'lng' ] );

    }


}