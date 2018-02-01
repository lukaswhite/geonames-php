<?php

use Lukaswhite\Geonames\Query\ReverseGeocoding\Ocean;

class OceanQueryTest extends PHPUnit_Framework_TestCase{

    public function testIsThereAnySyntaxError( )
    {
        $var = new Ocean( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertTrue( is_object( $var ) );
        unset( $var );
    }

    public function testReturnsTheUri( )
    {
        $query = new Ocean( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertEquals( 'ocean', $query->getUri( ) );
    }

    public function testDeclaresWhatItExpects( )
    {
        $query = new Ocean( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertEquals( 'ocean', $query->expects( ) );
    }

    public function testLatLngIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $query = new Ocean( $coordinates );


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

        $query = new Ocean( $coordinates );
        $query->withinRadius( 25 );

        $this->assertArrayHasKey( 'radius', $query->build( ) );
        $this->assertEquals( 25, $query->build( )[ 'radius' ] );

    }

}