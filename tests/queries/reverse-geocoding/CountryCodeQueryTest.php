<?php

use Lukaswhite\Geonames\Query\ReverseGeocoding\CountryCode;

class CountryCodeQueryTest extends PHPUnit_Framework_TestCase{

    public function testIsThereAnySyntaxError( )
    {
        $var = new CountryCode( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertTrue( is_object( $var ) );
        unset( $var );
    }

    public function testReturnsTheUri( )
    {
        $search = new CountryCode( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertEquals( 'countryCode', $search->getUri( ) );
    }

    public function testDeclaresWhatItExpects( )
    {
        $search = new CountryCode( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertEquals( 'string', $search->expects( ) );
    }

    public function testLatLngIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $search = new CountryCode( $coordinates );


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

        $search = new CountryCode( $coordinates );
        $search->withinRadius( 25 );

        $this->assertArrayHasKey( 'radius', $search->build( ) );
        $this->assertEquals( 25, $search->build( )[ 'radius' ] );

    }

}