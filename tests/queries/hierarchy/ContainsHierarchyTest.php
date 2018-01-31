<?php

use Lukaswhite\Geonames\Query\Hierarchy;

class ContainsHierarchyTest extends PHPUnit_Framework_TestCase{

    public function testBuildingContainsQuery( )
    {
        $search = ( new Hierarchy\Contains( 12345 ) );
        $this->assertEquals( 'contains', $search->getUri( ) );
        $this->assertEquals( 'features', $search->expects( ) );
        $this->assertArrayHasKey( 'geonameId', $search->build( ) );
        $this->assertEquals( 12345, $search->build( )[ 'geonameId' ] );

        $place = new \Lukaswhite\Geonames\Models\Feature( );
        $place->setId( 12345 );
        $search = ( new Hierarchy\Contains( $place ) );
        $this->assertAttributeEquals( 12345, 'geonamesId', $search );
    }

    public function testFilteringByFeatureClass( )
    {
        $search = ( new Hierarchy\Contains( 12345 ) );
        $this->assertArrayNotHasKey( 'featureClass', $search->build( ) );
        $this->assertInstanceOf( Hierarchy\Contains::class, $search->filterByFeatureClass( 'A' ) );
        $this->assertArrayHasKey( 'featureClass', $search->build() );
        $this->assertInternalType( 'array', $search->build()[ 'featureClass' ] );
        $this->assertEquals( [ 'A' ], $search->build()[ 'featureClass' ] );
        unset( $search );

        $search = ( new Hierarchy\Contains( 12345 ) );
        $this->assertArrayNotHasKey( 'featureClass', $search->build( ) );
        $search->filterByFeatureClass( 'A', 'P' );
        $this->assertArrayHasKey( 'featureClass', $search->build() );
        $this->assertInternalType( 'array', $search->build()[ 'featureClass' ] );
        $this->assertEquals( [ 'A', 'P' ], $search->build()[ 'featureClass' ] );
        unset( $search );
    }

    public function testFilteringByFeatureCode( )
    {
        $search = ( new Hierarchy\Contains( 12345 ) );
        $this->assertArrayNotHasKey( 'featureCode', $search->build( ) );
        $search->filterByFeatureCode( 'PPL' );
        $this->assertArrayHasKey( 'featureCode', $search->build() );
        $this->assertInternalType( 'array', $search->build()[ 'featureCode' ] );
        $this->assertEquals( [ 'PPL' ], $search->build()[ 'featureCode' ] );
        unset( $search );

        $search = ( new Hierarchy\Contains( 12345 ) );
        $this->assertArrayNotHasKey( 'featureClass', $search->build( ) );
        $search->filterByFeatureCode( 'PPL', 'PPLA2' );
        $this->assertArrayHasKey( 'featureCode', $search->build() );
        $this->assertInternalType( 'array', $search->build()[ 'featureCode' ] );
        $this->assertEquals( [ 'PPL', 'PPLA2' ], $search->build()[ 'featureCode' ] );
        unset( $search );
    }

}