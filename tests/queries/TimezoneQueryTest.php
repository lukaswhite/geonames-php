<?php

use Lukaswhite\Geonames\Query\Timezone;

class TimezoneQueryTest extends PHPUnit_Framework_TestCase{


    public function testIsThereAnySyntaxError( )
    {
        $var = new Timezone( );
        $this->assertTrue( is_object( $var ) );
        unset( $var );
    }

    public function testReturnsTheUri( )
    {
        $search = new Timezone( );
        $this->assertEquals( 'timezone', $search->getUri( ) );
    }

    public function testDeclaresWhatItExpects( )
    {
        $search = new Timezone( );
        $this->assertEquals( 'timezone', $search->expects( ) );
    }

    public function testLatLngIncludedInQuery( )
    {
        $search = new Timezone( );

        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );
        $search->setCoordinates( $coordinates );


        $this->assertArrayHasKey( 'lat', $search->build( ) );
        $this->assertEquals( 53.41667, $search->build( )[ 'lat' ] );
        $this->assertArrayHasKey( 'lng', $search->build( ) );
        $this->assertEquals( -2.25, $search->build( )[ 'lng' ] );

    }

    public function testRadiusIncludedInQuery( )
    {
        $search = new Timezone( );

        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );
        $search->setCoordinates( $coordinates )->withinRadius( 25 );

        $this->assertArrayHasKey( 'radius', $search->build( ) );
        $this->assertEquals( 25, $search->build( )[ 'radius' ] );

    }

    public function testDateIncludedInQuery( )
    {
        $search = new Timezone( );

        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );
        $search->setCoordinates( $coordinates )->withinRadius( 25 )->onDate( '2018-02-03' );

        $this->assertArrayHasKey( 'date', $search->build( ) );
        $this->assertEquals( '2018-02-03', $search->build( )[ 'date' ] );

    }


}