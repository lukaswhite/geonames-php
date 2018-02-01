<?php

use Lukaswhite\Geonames\Query\ReverseGeocoding\NearestPopulatedPlace;

class NearestPopulatedPlaceQueryTest extends PHPUnit_Framework_TestCase{

    public function testIsThereAnySyntaxError( )
    {
        $var = new NearestPopulatedPlace( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertTrue( is_object( $var ) );
        unset( $var );
    }

    public function testReturnsTheUri( )
    {
        $query = new NearestPopulatedPlace( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertEquals( 'findNearbyPlaceName', $query->getUri( ) );
    }

    public function testDeclaresWhatItExpects( )
    {
        $query = new NearestPopulatedPlace( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertEquals( 'features', $query->expects( ) );
    }

    public function testLatLngIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $query = new NearestPopulatedPlace( $coordinates );


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

        $query = new NearestPopulatedPlace( $coordinates );
        $query->withinRadius( 25 );

        $this->assertArrayHasKey( 'radius', $query->build( ) );
        $this->assertEquals( 25, $query->build( )[ 'radius' ] );

    }

    public function testLanguageIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $query = new NearestPopulatedPlace( $coordinates );

        $query->withinRadius( 25 )->language( 'en' );

        $this->assertArrayHasKey( 'lang', $query->build( ) );
        $this->assertEquals( 'en', $query->build( )[ 'lang' ] );

    }

    public function testStyleIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $query = new NearestPopulatedPlace( $coordinates );

        $query->withinRadius( 25 )->language( 'en' )->full( );

        $this->assertArrayHasKey( 'style', $query->build( ) );
        $this->assertEquals( 'FULL', $query->build( )[ 'style' ] );

    }


    public function testCitiesIncludedInQuery( )
    {
        $query = new NearestPopulatedPlace( new \Lukaswhite\Geonames\Models\Coordinate( ) );

        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $query = new NearestPopulatedPlace( $coordinates );

        $query->withinRadius( 25 )->language( 'en' )->full( )
            ->populationOver5000( );

        $this->assertArrayHasKey( 'cities', $query->build( ) );
        $this->assertEquals( 'cities5000', $query->build( )[ 'cities' ] );
    }

    public function testMaxRowsIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $query = new NearestPopulatedPlace( $coordinates );

        $query->withinRadius( 25 )->language( 'en' )->full( )
            ->populationOver5000( )
            ->limit( 25 );

        $this->assertArrayHasKey( 'maxRows', $query->build( ) );
        $this->assertEquals( 25, $query->build( )[ 'maxRows' ] );
    }

    public function testLocalCountryIncludedInQuery( )
    {
        $query = new NearestPopulatedPlace( new \Lukaswhite\Geonames\Models\Coordinate( ) );

        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $query = new NearestPopulatedPlace( $coordinates );

        $query->withinRadius( 25 )->language( 'en' )->full( )
            ->populationOver5000( )
            ->limit( 25 )
            ->justLocalCountry( );

        $this->assertArrayHasKey( 'localCountry', $query->build( ) );
        $this->assertEquals( true, $query->build( )[ 'localCountry' ] );
    }

}