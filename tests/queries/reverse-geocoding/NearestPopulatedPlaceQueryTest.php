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
        $search = new NearestPopulatedPlace( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertEquals( 'findNearbyPlaceName', $search->getUri( ) );
    }

    public function testDeclaresWhatItExpects( )
    {
        $search = new NearestPopulatedPlace( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertEquals( 'features', $search->expects( ) );
    }

    public function testLatLngIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $search = new NearestPopulatedPlace( $coordinates );


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

        $search = new NearestPopulatedPlace( $coordinates );
        $search->withinRadius( 25 );

        $this->assertArrayHasKey( 'radius', $search->build( ) );
        $this->assertEquals( 25, $search->build( )[ 'radius' ] );

    }

    public function testLanguageIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $search = new NearestPopulatedPlace( $coordinates );

        $search->withinRadius( 25 )->language( 'en' );

        $this->assertArrayHasKey( 'lang', $search->build( ) );
        $this->assertEquals( 'en', $search->build( )[ 'lang' ] );

    }

    public function testStyleIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $search = new NearestPopulatedPlace( $coordinates );

        $search->withinRadius( 25 )->language( 'en' )->full( );

        $this->assertArrayHasKey( 'style', $search->build( ) );
        $this->assertEquals( 'FULL', $search->build( )[ 'style' ] );

    }


    public function testCitiesIncludedInQuery( )
    {
        $search = new NearestPopulatedPlace( new \Lukaswhite\Geonames\Models\Coordinate( ) );

        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $search = new NearestPopulatedPlace( $coordinates );

        $search->withinRadius( 25 )->language( 'en' )->full( )
            ->populationOver5000( );

        $this->assertArrayHasKey( 'cities', $search->build( ) );
        $this->assertEquals( 'cities5000', $search->build( )[ 'cities' ] );
    }

    public function testMaxRowsIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $search = new NearestPopulatedPlace( $coordinates );

        $search->withinRadius( 25 )->language( 'en' )->full( )
            ->populationOver5000( )
            ->limit( 25 );

        $this->assertArrayHasKey( 'maxRows', $search->build( ) );
        $this->assertEquals( 25, $search->build( )[ 'maxRows' ] );
    }

    public function testLocalCountryIncludedInQuery( )
    {
        $search = new NearestPopulatedPlace( new \Lukaswhite\Geonames\Models\Coordinate( ) );

        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $search = new NearestPopulatedPlace( $coordinates );

        $search->withinRadius( 25 )->language( 'en' )->full( )
            ->populationOver5000( )
            ->limit( 25 )
            ->justLocalCountry( );

        $this->assertArrayHasKey( 'localCountry', $search->build( ) );
        $this->assertEquals( true, $search->build( )[ 'localCountry' ] );
    }

}