<?php

use Lukaswhite\Geonames\Models\AdministrativeDivision;

class AdministrativeDivisionsTest extends PHPUnit_Framework_TestCase{

    public function testConstructor( )
    {
        $area = new AdministrativeDivision( 'ENG', 1 );
        $this->assertEquals( 'ENG', $area->getCode( ) );
        $this->assertEquals( 1, $area->getLevel( ) );
        $this->assertNull( $area->getName( ) );
        unset( $area );

        $area = new AdministrativeDivision( 'ENG', 1, 'England' );
        $this->assertEquals( 'England', $area->getName( ) );
    }

    public function testSettersAndGetters( )
    {
        $area = new AdministrativeDivision( 'ENG', 1 );
        $area->setName( 'England' );
        $this->assertEquals( 'England', $area->getName( ) );
    }
    public function testStringRepresentation( )
    {
        $area = new AdministrativeDivision( 'ENG', 1 );
        $this->assertEquals( 'ENG', ( string ) $area );
    }

    public function testSettingAndGettingParent( )
    {
        $england = new AdministrativeDivision( 'ENG', 1 );
        $greaterLondon = new AdministrativeDivision( 'GLA', 2 );
        $greaterLondon->setParent( $england );
        $this->assertEquals( 'ENG', $greaterLondon->getParent( )->getCode( ) );
    }

    public function testSettingAndGettingChildren( )
    {
        $england = new AdministrativeDivision( 'ENG', 1 );
        $greaterLondon = new AdministrativeDivision( 'GLA', 2 );
        $england->setChildren( [ $greaterLondon ] );
        $this->assertEquals( [ $greaterLondon ], $england->getChildren( ) );
    }

    public function testGetLowestLevelAdministrativeArea( )
    {
        $england = new AdministrativeDivision( 'ENG', 1 );
        $greaterLondon = new AdministrativeDivision( 'GLA', 2 );
        $barnet = new AdministrativeDivision( 'A3', 3 );

        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $feature->addAdministrativeDivision( $england );
        $feature->addAdministrativeDivision( $greaterLondon );
        $feature->addAdministrativeDivision( $barnet );
        $this->assertEquals( $barnet, $feature->getLowestLevelAdministrativeDivision( ) );
        unset( $feature );

        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $feature->addAdministrativeDivision( $england );
        $feature->addAdministrativeDivision( $greaterLondon );
        $this->assertEquals( $greaterLondon, $feature->getLowestLevelAdministrativeDivision( ) );
        unset( $feature );

        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $feature->addAdministrativeDivision( $england );
        $feature->addAdministrativeDivision( $barnet );
        $this->assertEquals( $barnet, $feature->getLowestLevelAdministrativeDivision( ) );
        unset( $feature );

        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $feature->addAdministrativeDivision( $england );
        $this->assertEquals( $england, $feature->getLowestLevelAdministrativeDivision( ) );
        unset( $feature );

        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $this->assertNull( $feature->getLowestLevelAdministrativeDivision( ) );
        unset( $feature );

    }

    public function testGetTopLevelAdministrativeArea( )
    {
        $england = new AdministrativeDivision( 'ENG', 1 );
        $greaterLondon = new AdministrativeDivision( 'GLA', 2 );
        $barnet = new AdministrativeDivision( 'A3', 3 );
        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $feature->addAdministrativeDivision( $england );
        $feature->addAdministrativeDivision( $greaterLondon );
        $feature->addAdministrativeDivision( $barnet );
        $this->assertEquals( $england, $feature->getTopLevelAdministrativeDivision( ) );
        unset( $feature );

        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $feature->addAdministrativeDivision( $england );
        $feature->addAdministrativeDivision( $greaterLondon );
        $this->assertEquals( $england, $feature->getTopLevelAdministrativeDivision( ) );
        unset( $feature );

        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $feature->addAdministrativeDivision( $england );
        $feature->addAdministrativeDivision( $barnet );
        $this->assertEquals( $england, $feature->getTopLevelAdministrativeDivision( ) );
        unset( $feature );

        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $feature->addAdministrativeDivision( $england );
        $this->assertEquals( $england, $feature->getTopLevelAdministrativeDivision( ) );
        unset( $feature );

        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $this->assertNull( $feature->getTopLevelAdministrativeDivision( ) );
        unset( $feature );

    }

    public function testGetNextAdministrativeLevelUpFrom( )
    {
        $england = new AdministrativeDivision( 'ENG', 1 );
        $greaterLondon = new AdministrativeDivision( 'GLA', 2 );
        $barnet = new AdministrativeDivision( 'A3', 3 );
        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $feature->addAdministrativeDivision( $england );
        $feature->addAdministrativeDivision( $greaterLondon );
        $feature->addAdministrativeDivision( $barnet );
        $this->assertEquals( $greaterLondon, $feature->getNextAdministrativeLevelUpFrom( 3 ) );
        unset( $feature );

        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $feature->addAdministrativeDivision( $england );
        $feature->addAdministrativeDivision( $greaterLondon );
        $feature->addAdministrativeDivision( $barnet );
        $this->assertEquals( $england, $feature->getNextAdministrativeLevelUpFrom( 2 ) );
        unset( $feature );

        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $feature->addAdministrativeDivision( $england );
        $feature->addAdministrativeDivision( $barnet );
        $this->assertEquals( $england, $feature->getNextAdministrativeLevelUpFrom( 3 ) );
        unset( $feature );
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Cannot get an admin level up from level one
     */
    public function testTryingToGetNextAdministrativeLevelUpFromOne( )
    {
        $england = new AdministrativeDivision( 'ENG', 1 );
        $greaterLondon = new AdministrativeDivision( 'GLA', 2 );
        $barnet = new AdministrativeDivision( 'A3', 3 );
        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $feature->addAdministrativeDivision( $england );
        $feature->addAdministrativeDivision( $greaterLondon );
        $feature->addAdministrativeDivision( $barnet );
        $feature->getNextAdministrativeLevelUpFrom( 1 );
    }

    public function testGetAdministrativeAreaLevels( )
    {
        $england = new AdministrativeDivision( 'ENG', 1 );
        $greaterLondon = new AdministrativeDivision( 'GLA', 2 );
        $barnet = new AdministrativeDivision( 'A3', 3 );
        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $feature->addAdministrativeDivision( $england );
        $feature->addAdministrativeDivision( $greaterLondon );
        $feature->addAdministrativeDivision( $barnet );
        $this->assertEquals( [ 1, 2, 3 ], $feature->getAdministrativeDivisionLevels( ) );
        unset( $feature );

        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $feature->addAdministrativeDivision( $england );
        $feature->addAdministrativeDivision( $barnet );
        $this->assertEquals( [ 1, 3 ], $feature->getAdministrativeDivisionLevels( ) );
        unset( $feature );

        $feature = new \Lukaswhite\Geonames\Models\Feature( );
        $this->assertEquals( [ ], $feature->getAdministrativeDivisionLevels( ) );
        unset( $feature );
    }
}