<?php

use Lukaswhite\Geonames\Query\Hierarchy;

class ContainsHierarchyTest extends PHPUnit_Framework_TestCase{

    public function testBuildingContainsQuery( )
    {
        $query = ( new Hierarchy\Contains( 12345 ) );
        $this->assertEquals( 'contains', $query->getUri( ) );
        $this->assertEquals( 'features', $query->expects( ) );
        $this->assertArrayHasKey( 'geonameId', $query->build( ) );
        $this->assertEquals( 12345, $query->build( )[ 'geonameId' ] );

        $place = new \Lukaswhite\Geonames\Models\Feature( );
        $place->setId( 12345 );
        $query = ( new Hierarchy\Contains( $place ) );
        $this->assertAttributeEquals( 12345, 'geonamesId', $query );
    }

    public function testFilteringByFeatureClass( )
    {
        $query = ( new Hierarchy\Contains( 12345 ) );
        $this->assertArrayNotHasKey( 'featureClass', $query->build( ) );
        $this->assertInstanceOf( Hierarchy\Contains::class, $query->filterByFeatureClass( 'A' ) );
        $this->assertArrayHasKey( 'featureClass', $query->build() );
        $this->assertInternalType( 'array', $query->build()[ 'featureClass' ] );
        $this->assertEquals( [ 'A' ], $query->build()[ 'featureClass' ] );
        unset( $query );

        $query = ( new Hierarchy\Contains( 12345 ) );
        $this->assertArrayNotHasKey( 'featureClass', $query->build( ) );
        $query->filterByFeatureClass( 'A', 'P' );
        $this->assertArrayHasKey( 'featureClass', $query->build() );
        $this->assertInternalType( 'array', $query->build()[ 'featureClass' ] );
        $this->assertEquals( [ 'A', 'P' ], $query->build()[ 'featureClass' ] );
        unset( $query );
    }

    public function testFilteringByFeatureCode( )
    {
        $query = ( new Hierarchy\Contains( 12345 ) );
        $this->assertArrayNotHasKey( 'featureCode', $query->build( ) );
        $query->filterByFeatureCode( 'PPL' );
        $this->assertArrayHasKey( 'featureCode', $query->build() );
        $this->assertInternalType( 'array', $query->build()[ 'featureCode' ] );
        $this->assertEquals( [ 'PPL' ], $query->build()[ 'featureCode' ] );
        unset( $query );

        $query = ( new Hierarchy\Contains( 12345 ) );
        $this->assertArrayNotHasKey( 'featureClass', $query->build( ) );
        $query->filterByFeatureCode( 'PPL', 'PPLA2' );
        $this->assertArrayHasKey( 'featureCode', $query->build() );
        $this->assertInternalType( 'array', $query->build()[ 'featureCode' ] );
        $this->assertEquals( [ 'PPL', 'PPLA2' ], $query->build()[ 'featureCode' ] );
        unset( $query );
    }

}