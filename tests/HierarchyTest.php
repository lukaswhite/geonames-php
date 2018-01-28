<?php

use Lukaswhite\Geonames\Query\Hierarchy;

class HierarchyTest extends PHPUnit_Framework_TestCase{
	

    public function testIsThereAnySyntaxError( )
    {
        $var = new Hierarchy( );
        $this->assertTrue( is_object( $var ) );
        unset( $var );
    }

    public function testbuildWithDefaults( )
    {
        $search = new Hierarchy( );
        //$this->assertEquals( [ ], $search->build( ) );
    }

    public function testDeclaresWhatItExpects( )
    {
        $search = new Hierarchy( );
        $this->assertEquals( 'geonames', $search->expects( ) );
    }

    public function testBuildingChildrenQuery( )
    {
        $search = ( new Hierarchy( ) )->children( 12345 );
        $this->assertAttributeEquals( 12345, 'geonamesId', $search );
        $this->assertAttributeEquals( Hierarchy::CHILDREN, 'endpoint', $search );
        $this->assertEquals( Hierarchy::CHILDREN, $search->getUri( ) );
        $this->assertArrayHasKey( 'geonameId', $search->build( ) );
        $this->assertEquals( 12345, $search->build( )[ 'geonameId' ] );
        unset( $search );
        $place = new \Lukaswhite\Geonames\Models\Feature( );
        $place->setId( 12345 );
        $search = ( new Hierarchy( ) )->children( $place );
        $this->assertAttributeEquals( 12345, 'geonamesId', $search );
    }

    public function testBuildingHierarchyQuery( )
    {
        $search = ( new Hierarchy( ) )->hierarchy( 12345 );
        $this->assertAttributeEquals( 12345, 'geonamesId', $search );
        $this->assertAttributeEquals( Hierarchy::HIERARCHY, 'endpoint', $search );
        $this->assertEquals( Hierarchy::HIERARCHY, $search->getUri( ) );
        $this->assertArrayHasKey( 'geonameId', $search->build( ) );
        $this->assertEquals( 12345, $search->build( )[ 'geonameId' ] );
    }

    public function testBuildingNeighboursQuery( )
    {
        $search = ( new Hierarchy( ) )->neighbours( 12345 );
        $this->assertAttributeEquals( 12345, 'geonamesId', $search );
        $this->assertAttributeEquals( Hierarchy::NEIGHBOURS, 'endpoint', $search );
        $this->assertEquals( Hierarchy::NEIGHBOURS, $search->getUri( ) );
        $this->assertArrayHasKey( 'geonameId', $search->build( ) );
        $this->assertEquals( 12345, $search->build( )[ 'geonameId' ] );
        unset( $search );

        $search = ( new Hierarchy( ) )->neighbors( 12345 );
        $this->assertAttributeEquals( 12345, 'geonamesId', $search );
        $this->assertAttributeEquals( Hierarchy::NEIGHBOURS, 'endpoint', $search );
        $this->assertEquals( Hierarchy::NEIGHBOURS, $search->getUri( ) );
        $this->assertArrayHasKey( 'geonameId', $search->build( ) );
        $this->assertEquals( 12345, $search->build( )[ 'geonameId' ] );
    }

    public function testBuildingContainsQuery( )
    {
        $search = ( new Hierarchy( ) )->contains( 12345 );
        $this->assertAttributeEquals( 12345, 'geonamesId', $search );
        $this->assertAttributeEquals( Hierarchy::CONTAINS, 'endpoint', $search );
        $this->assertEquals( Hierarchy::CONTAINS, $search->getUri( ) );
        $this->assertArrayHasKey( 'geonameId', $search->build( ) );
        $this->assertEquals( 12345, $search->build( )[ 'geonameId' ] );
    }

    public function testBuildingSiblingsQuery( )
    {
        $search = ( new Hierarchy( ) )->siblings( 12345 );
        $this->assertAttributeEquals( 12345, 'geonamesId', $search );
        $this->assertAttributeEquals( Hierarchy::SIBLINGS, 'endpoint', $search );
        $this->assertEquals( Hierarchy::SIBLINGS, $search->getUri( ) );
        $this->assertArrayHasKey( 'geonameId', $search->build( ) );
        $this->assertEquals( 12345, $search->build( )[ 'geonameId' ] );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsExceptionIfPlaceInvalid( )
    {
        $search = ( new Hierarchy( ) )->children( true );
    }

    public function testLimitingByFeatureClass( )
    {
        $search = ( new Hierarchy( ) )->contains( 12345 );
        $this->assertArrayNotHasKey( 'featureClass', $search->build( ) );
        $this->assertInstanceOf( Hierarchy::class, $search->filterByFeatureClass( 'A' ) );
        $this->assertArrayHasKey( 'featureClass', $search->build() );
        $this->assertInternalType( 'array', $search->build()[ 'featureClass' ] );
        $this->assertEquals( [ 'A' ], $search->build()[ 'featureClass' ] );
        unset( $search );

        $search = ( new Hierarchy( ) )->contains( 12345 );
        $this->assertArrayNotHasKey( 'featureClass', $search->build( ) );
        $search->filterByFeatureClass( [ 'A', 'P' ] );
        $this->assertArrayHasKey( 'featureClass', $search->build() );
        $this->assertInternalType( 'array', $search->build()[ 'featureClass' ] );
        $this->assertEquals( [ 'A', 'P' ], $search->build()[ 'featureClass' ] );
        unset( $search );
    }

    public function testLimitingByFeatureCode( )
    {
        $search = ( new Hierarchy( ) )->contains( 12345 );
        $this->assertArrayNotHasKey( 'featureCode', $search->build( ) );
        $search->filterByFeatureCode( 'PPL' );
        $this->assertArrayHasKey( 'featureCode', $search->build() );
        $this->assertInternalType( 'array', $search->build()[ 'featureCode' ] );
        $this->assertEquals( [ 'PPL' ], $search->build()[ 'featureCode' ] );
        unset( $search );

        $search = ( new Hierarchy( ) )->contains( 12345 );
        $this->assertArrayNotHasKey( 'featureClass', $search->build( ) );
        $search->filterByFeatureCode( [ 'PPL', 'PPLA2' ] );
        $this->assertArrayHasKey( 'featureCode', $search->build() );
        $this->assertInternalType( 'array', $search->build()[ 'featureCode' ] );
        $this->assertEquals( [ 'PPL', 'PPLA2' ], $search->build()[ 'featureCode' ] );
        unset( $search );
    }

    public function testSettingHierarchy( )
    {
        $search = ( new Hierarchy( ) )->children( 12345 );
        $search->ofType( 'tourism' );
        $this->assertArrayHasKey( 'hierarchy', $search->build() );
        $this->assertEquals( 'tourism', $search->build()[ 'hierarchy' ] );
    }

    public function testBasingQueryOnCountry( )
    {
        $search = ( new Hierarchy( ) )->neighbours( 'GB' );
        $this->assertArrayNotHasKey( 'geonameId', $search->build( ) );
        $this->assertArrayHasKey( 'country', $search->build() );
        $this->assertEquals( 'GB', $search->build()[ 'country' ] );
    }

    public function testStyle( )
    {
        $search = new Hierarchy( );
        $this->assertArrayNotHasKey( 'style', $search->build( ) );
        $this->assertInstanceOf( Hierarchy::class, $search->style( 'FULL' ) );
        $this->assertArrayHasKey( 'style', $search->build() );
        $this->assertEquals( 'FULL', $search->build()[ 'style' ] );
        unset( $search );

        $search = new Hierarchy( );
        $search->style( 'short' );
        $this->assertEquals( 'SHORT', $search->build()[ 'style' ] );
        unset( $search );

        $search = new Hierarchy( );
        $search->style( 'MedIUM' );
        $this->assertEquals( 'MEDIUM', $search->build()[ 'style' ] );
        unset( $search );

        $search = new Hierarchy( );
        $search->style( 'LONG' );
        $this->assertEquals( 'LONG', $search->build()[ 'style' ] );
        unset( $search );

        $search = new Hierarchy( );
        $search->short( );
        $this->assertEquals( 'SHORT', $search->build()[ 'style' ] );
        $search->medium( );
        $this->assertEquals( 'MEDIUM', $search->build()[ 'style' ] );
        $search->long( );
        $this->assertEquals( 'LONG', $search->build()[ 'style' ] );
        $search->full( );
        $this->assertEquals( 'FULL', $search->build()[ 'style' ] );
        unset( $search );
    }

    public function testLimitingChildrenQuery( )
    {
        $search = ( new Hierarchy( ) )->children( 12345 );
        $search->limit( 250 );
        $this->assertArrayHasKey( 'maxRows', $search->build() );
        $this->assertEquals( 250, $search->build()[ 'maxRows' ] );
    }


}