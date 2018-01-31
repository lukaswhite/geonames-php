<?php

use Lukaswhite\Geonames\Query\Hierarchy;

class SiblingsHierarchyTest extends PHPUnit_Framework_TestCase{

    public function testBuildingQuery( )
    {
        $search = ( new Hierarchy\Siblings( 12345 ) );
        $this->assertEquals( 'siblings', $search->getUri( ) );
        $this->assertEquals( 'features', $search->expects( ) );
        $this->assertArrayHasKey( 'geonameId', $search->build( ) );
        $this->assertEquals( 12345, $search->build( )[ 'geonameId' ] );

        $place = new \Lukaswhite\Geonames\Models\Feature( );
        $place->setId( 12345 );
        $search = ( new Hierarchy\Siblings( $place ) );
        $this->assertAttributeEquals( 12345, 'geonamesId', $search );
    }

    public function testStyle( )
    {
        $search = new Hierarchy\Siblings( 12345 );
        $this->assertArrayNotHasKey( 'style', $search->build( ) );
        $this->assertInstanceOf( Hierarchy\Siblings::class, $search->style( 'FULL' ) );
        $this->assertArrayHasKey( 'style', $search->build() );
        $this->assertEquals( 'FULL', $search->build()[ 'style' ] );
        unset( $search );

        $search = new Hierarchy\Siblings( 12345 );
        $search->style( 'short' );
        $this->assertEquals( 'SHORT', $search->build()[ 'style' ] );
        unset( $search );

        $search = new Hierarchy\Siblings( 12345 );
        $search->style( 'MedIUM' );
        $this->assertEquals( 'MEDIUM', $search->build()[ 'style' ] );
        unset( $search );

        $search = new Hierarchy\Siblings( 12345 );
        $search->style( 'LONG' );
        $this->assertEquals( 'LONG', $search->build()[ 'style' ] );
        unset( $search );

        $search = new Hierarchy\Siblings( 12345 );
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
}