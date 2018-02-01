<?php

use Lukaswhite\Geonames\Query\Hierarchy;

class SiblingsHierarchyTest extends PHPUnit_Framework_TestCase{

    public function testBuildingQuery( )
    {
        $query = ( new Hierarchy\Siblings( 12345 ) );
        $this->assertEquals( 'siblings', $query->getUri( ) );
        $this->assertEquals( 'features', $query->expects( ) );
        $this->assertArrayHasKey( 'geonameId', $query->build( ) );
        $this->assertEquals( 12345, $query->build( )[ 'geonameId' ] );

        $place = new \Lukaswhite\Geonames\Models\Feature( );
        $place->setId( 12345 );
        $query = ( new Hierarchy\Siblings( $place ) );
        $this->assertAttributeEquals( 12345, 'geonamesId', $query );
    }

    public function testStyle( )
    {
        $query = new Hierarchy\Siblings( 12345 );
        $this->assertArrayNotHasKey( 'style', $query->build( ) );
        $this->assertInstanceOf( Hierarchy\Siblings::class, $query->style( 'FULL' ) );
        $this->assertArrayHasKey( 'style', $query->build() );
        $this->assertEquals( 'FULL', $query->build()[ 'style' ] );
        unset( $query );

        $query = new Hierarchy\Siblings( 12345 );
        $query->style( 'short' );
        $this->assertEquals( 'SHORT', $query->build()[ 'style' ] );
        unset( $query );

        $query = new Hierarchy\Siblings( 12345 );
        $query->style( 'MedIUM' );
        $this->assertEquals( 'MEDIUM', $query->build()[ 'style' ] );
        unset( $query );

        $query = new Hierarchy\Siblings( 12345 );
        $query->style( 'LONG' );
        $this->assertEquals( 'LONG', $query->build()[ 'style' ] );
        unset( $query );

        $query = new Hierarchy\Siblings( 12345 );
        $query->short( );
        $this->assertEquals( 'SHORT', $query->build()[ 'style' ] );
        $query->medium( );
        $this->assertEquals( 'MEDIUM', $query->build()[ 'style' ] );
        $query->long( );
        $this->assertEquals( 'LONG', $query->build()[ 'style' ] );
        $query->full( );
        $this->assertEquals( 'FULL', $query->build()[ 'style' ] );
        unset( $query );
    }
}