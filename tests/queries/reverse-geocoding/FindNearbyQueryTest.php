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
        $query = new FindNearby( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertEquals( 'findNearby', $query->getUri( ) );
    }

    public function testDeclaresWhatItExpects( )
    {
        $query = new FindNearby( new \Lukaswhite\Geonames\Models\Coordinate( ) );
        $this->assertEquals( 'features', $query->expects( ) );
    }

    public function testLatLngIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $query = new FindNearby( $coordinates );


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

        $query = new FindNearby( $coordinates );
        $query->withinRadius( 25 );

        $this->assertArrayHasKey( 'radius', $query->build( ) );
        $this->assertEquals( 25, $query->build( )[ 'radius' ] );

    }

    public function testStyleIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $query = new FindNearby( $coordinates );

        $query->withinRadius( 25 )->full( );

        $this->assertArrayHasKey( 'style', $query->build( ) );
        $this->assertEquals( 'FULL', $query->build( )[ 'style' ] );

    }


    public function testMaxRowsIncludedInQuery( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $query = new FindNearby( $coordinates );

        $query->withinRadius( 25 )
            ->full( )
            ->limit( 25 );

        $this->assertArrayHasKey( 'maxRows', $query->build( ) );
        $this->assertEquals( 25, $query->build( )[ 'maxRows' ] );
    }

    public function testLocalCountryIncludedInQuery( )
    {
        $query = new FindNearby( new \Lukaswhite\Geonames\Models\Coordinate( ) );

        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $query = new FindNearby( $coordinates );

        $query->withinRadius( 25 )->full( )
            ->limit( 25 )
            ->justLocalCountry( );

        $this->assertArrayHasKey( 'localCountry', $query->build( ) );
        $this->assertEquals( true, $query->build( )[ 'localCountry' ] );
    }

    public function testLimitingByFeatureClass( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $query = new FindNearby( $coordinates );
        $this->assertArrayNotHasKey( 'featureClass', $query->build( ) );
        $this->assertInstanceOf( FindNearby::class, $query->filterByFeatureClass( 'A' ) );
        $this->assertArrayHasKey( 'featureClass', $query->build() );
        $this->assertInternalType( 'array', $query->build()[ 'featureClass' ] );
        $this->assertEquals( [ 'A' ], $query->build()[ 'featureClass' ] );
        unset( $query );

        $query = new FindNearby( $coordinates );
        $this->assertArrayNotHasKey( 'featureClass', $query->build( ) );
        $query->filterByFeatureClass( 'A', 'P' );
        $this->assertArrayHasKey( 'featureClass', $query->build() );
        $this->assertInternalType( 'array', $query->build()[ 'featureClass' ] );
        $this->assertEquals( [ 'A', 'P' ], $query->build()[ 'featureClass' ] );
        unset( $query );
    }

    public function testLimitingByFeatureCode( )
    {
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( );
        $coordinates->setLatitude( 53.41667 )
            ->setLongitude( -2.25 );

        $query = new FindNearby( $coordinates );

        $this->assertArrayNotHasKey( 'featureCode', $query->build( ) );
        $this->assertInstanceOf( FindNearby::class, $query->filterByFeatureCode( 'PPL' ) );
        $this->assertArrayHasKey( 'featureCode', $query->build() );
        $this->assertInternalType( 'array', $query->build()[ 'featureCode' ] );
        $this->assertEquals( [ 'PPL' ], $query->build()[ 'featureCode' ] );
        unset( $query );

        $query = new FindNearby( $coordinates );
        $this->assertArrayNotHasKey( 'featureClass', $query->build( ) );
        $query->filterByFeatureCode( 'PPL', 'PPLA2' );
        $this->assertArrayHasKey( 'featureCode', $query->build() );
        $this->assertInternalType( 'array', $query->build()[ 'featureCode' ] );
        $this->assertEquals( [ 'PPL', 'PPLA2' ], $query->build()[ 'featureCode' ] );
        unset( $query );
    }

}