<?php

use Lukaswhite\Geonames\Models\AdministrativeArea;

class AdministrativeAreaTest extends PHPUnit_Framework_TestCase{

    public function testConstructor( )
    {
        $area = new AdministrativeArea( 'ENG', 1 );
        $this->assertEquals( 'ENG', $area->getCode( ) );
        $this->assertEquals( 1, $area->getLevel( ) );
        $this->assertNull( $area->getName( ) );
        unset( $area );

        $area = new AdministrativeArea( 'ENG', 1, 'England' );
        $this->assertEquals( 'England', $area->getName( ) );
    }

    public function testSettersAndGetters( )
    {
        $area = new AdministrativeArea( 'ENG', 1 );
        $area->setName( 'England' );
        $this->assertEquals( 'England', $area->getName( ) );
    }
    public function testStringRepresentation( )
    {
        $area = new AdministrativeArea( 'ENG', 1 );
        $this->assertEquals( 'ENG', ( string ) $area );
    }

    public function testSettingAndGettingParent( )
    {
        $england = new AdministrativeArea( 'ENG', 1 );
        $greaterLondon = new AdministrativeArea( 'GLA', 2 );
        $greaterLondon->setParent( $england );
        $this->assertEquals( 'ENG', $greaterLondon->getParent( )->getCode( ) );
    }

    public function testSettingAndGettingChildren( )
    {
        $england = new AdministrativeArea( 'ENG', 1 );
        $greaterLondon = new AdministrativeArea( 'GLA', 2 );
        $england->setChildren( [ $greaterLondon ] );
        $this->assertEquals( [ $greaterLondon ], $england->getChildren( ) );
    }

    public function testGetLowestLevelAdministrativeArea( )
    {
        $england = new AdministrativeArea( 'ENG', 1 );
        $greaterLondon = new AdministrativeArea( 'GLA', 2 );
        $barnet = new AdministrativeArea( 'A3', 3 );

        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $feature->addAdministrativeArea( $england );
        $feature->addAdministrativeArea( $greaterLondon );
        $feature->addAdministrativeArea( $barnet );
        $this->assertEquals( $barnet, $feature->getLowestLevelAdministrativeArea( ) );
        unset( $feature );

        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $feature->addAdministrativeArea( $england );
        $feature->addAdministrativeArea( $greaterLondon );
        $this->assertEquals( $greaterLondon, $feature->getLowestLevelAdministrativeArea( ) );
        unset( $feature );

        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $feature->addAdministrativeArea( $england );
        $feature->addAdministrativeArea( $barnet );
        $this->assertEquals( $barnet, $feature->getLowestLevelAdministrativeArea( ) );
        unset( $feature );

        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $feature->addAdministrativeArea( $england );
        $this->assertEquals( $england, $feature->getLowestLevelAdministrativeArea( ) );
        unset( $feature );

        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $this->assertNull( $feature->getLowestLevelAdministrativeArea( ) );
        unset( $feature );

    }

    public function testGetTopLevelAdministrativeArea( )
    {
        $england = new AdministrativeArea( 'ENG', 1 );
        $greaterLondon = new AdministrativeArea( 'GLA', 2 );
        $barnet = new AdministrativeArea( 'A3', 3 );
        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $feature->addAdministrativeArea( $england );
        $feature->addAdministrativeArea( $greaterLondon );
        $feature->addAdministrativeArea( $barnet );
        $this->assertEquals( $england, $feature->getTopLevelAdministrativeArea( ) );
        unset( $feature );

        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $feature->addAdministrativeArea( $england );
        $feature->addAdministrativeArea( $greaterLondon );
        $this->assertEquals( $england, $feature->getTopLevelAdministrativeArea( ) );
        unset( $feature );

        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $feature->addAdministrativeArea( $england );
        $feature->addAdministrativeArea( $barnet );
        $this->assertEquals( $england, $feature->getTopLevelAdministrativeArea( ) );
        unset( $feature );

        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $feature->addAdministrativeArea( $england );
        $this->assertEquals( $england, $feature->getTopLevelAdministrativeArea( ) );
        unset( $feature );

        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $this->assertNull( $feature->getTopLevelAdministrativeArea( ) );
        unset( $feature );

    }
}