<?php

use Lukaswhite\Geonames\Query\ReverseGeocoding\FindNearby;

class FindNearbyQueryTest extends PHPUnit_Framework_TestCase{

    public function testIsThereAnySyntaxError( )
    {
        $var = new FindNearby( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertTrue( is_object( $var ) );
        unset( $var );
    }

    public function testReturnsTheUri( )
    {
        $search = new FindNearby( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertEquals( 'findNearby', $search->getUri( ) );
    }

    public function testDeclaresWhatItExpects( )
    {
        $search = new FindNearby( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertEquals( 'features', $search->expects( ) );
    }

    public function testLatLngIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $search = new FindNearby( $coordinates );


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

        $search = new FindNearby( $coordinates );
        $search->withinRadius( 25 );

        $this->assertArrayHasKey( 'radius', $search->build( ) );
        $this->assertEquals( 25, $search->build( )[ 'radius' ] );

    }

    public function testStyleIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $search = new FindNearby( $coordinates );

        $search->withinRadius( 25 )->full( );

        $this->assertArrayHasKey( 'style', $search->build( ) );
        $this->assertEquals( 'FULL', $search->build( )[ 'style' ] );

    }


    public function testMaxRowsIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $search = new FindNearby( $coordinates );

        $search->withinRadius( 25 )
            ->full( )
            ->limit( 25 );

        $this->assertArrayHasKey( 'maxRows', $search->build( ) );
        $this->assertEquals( 25, $search->build( )[ 'maxRows' ] );
    }

    public function testLocalCountryIncludedInQuery( )
    {
        $search = new FindNearby( new \Lukaswhite\Geonames\Models\Coordinate( ) );

        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $search = new FindNearby( $coordinates );

        $search->withinRadius( 25 )->full( )
            ->limit( 25 )
            ->justLocalCountry( );

        $this->assertArrayHasKey( 'localCountry', $search->build( ) );
        $this->assertEquals( true, $search->build( )[ 'localCountry' ] );
    }

    public function testLimitingByFeatureClass( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $search = new FindNearby( $coordinates );
        $this->assertArrayNotHasKey( 'featureClass', $search->build( ) );
        $this->assertInstanceOf( FindNearby::class, $search->filterByFeatureClass( 'A' ) );
        $this->assertArrayHasKey( 'featureClass', $search->build() );
        $this->assertInternalType( 'array', $search->build()[ 'featureClass' ] );
        $this->assertEquals( [ 'A' ], $search->build()[ 'featureClass' ] );
        unset( $search );

        $search = new FindNearby( $coordinates );
        $this->assertArrayNotHasKey( 'featureClass', $search->build( ) );
        $search->filterByFeatureClass( 'A', 'P' );
        $this->assertArrayHasKey( 'featureClass', $search->build() );
        $this->assertInternalType( 'array', $search->build()[ 'featureClass' ] );
        $this->assertEquals( [ 'A', 'P' ], $search->build()[ 'featureClass' ] );
        unset( $search );
    }

    public function testLimitingByFeatureCode( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $search = new FindNearby( $coordinates );

        $this->assertArrayNotHasKey( 'featureCode', $search->build( ) );
        $this->assertInstanceOf( FindNearby::class, $search->filterByFeatureCode( 'PPL' ) );
        $this->assertArrayHasKey( 'featureCode', $search->build() );
        $this->assertInternalType( 'array', $search->build()[ 'featureCode' ] );
        $this->assertEquals( [ 'PPL' ], $search->build()[ 'featureCode' ] );
        unset( $search );

        $search = new FindNearby( $coordinates );
        $this->assertArrayNotHasKey( 'featureClass', $search->build( ) );
        $search->filterByFeatureCode( 'PPL', 'PPLA2' );
        $this->assertArrayHasKey( 'featureCode', $search->build() );
        $this->assertInternalType( 'array', $search->build()[ 'featureCode' ] );
        $this->assertEquals( [ 'PPL', 'PPLA2' ], $search->build()[ 'featureCode' ] );
        unset( $search );
    }

}