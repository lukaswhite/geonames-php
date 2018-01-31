<?php 

use Lukaswhite\Geonames\Models\Feature;
use Lukaswhite\Geonames\Models\Country;
use Lukaswhite\Geonames\Models\AlternateName;

class FeatureModelTest extends PHPUnit_Framework_TestCase{

    public function testIsThereAnySyntaxError( )
    {
        $var = new Feature( );
        $this->assertTrue( is_object( $var ) );
        unset( $var );
    }

    public function testGettersAndSetters( )
    {
        $place = new Feature( );
        $this->assertInstanceOf( Feature::class, $place->setId( 12345 ) );
        $this->assertAttributeEquals( 12345, 'id', $place );
        $this->assertEquals( 12345, $place->getId( ) );
        $this->assertArrayHasKey( 'id', $place->toArray( ) );
        $this->assertEquals( 12345, $place->toArray( )[ 'id' ] );

        $this->assertInstanceOf( Feature::class, $place->setName( 'Manchester' ) );
        $this->assertAttributeEquals( 'Manchester', 'name', $place );
        $this->assertEquals( 'Manchester', $place->getName( ) );
        $this->assertArrayHasKey( 'name', $place->toArray( ) );
        $this->assertEquals( 'Manchester', $place->toArray( )[ 'name' ] );

        $this->assertInstanceOf( Feature::class, $place->setToponymName( 'Greater Manchester' ) );
        $this->assertAttributeEquals( 'Greater Manchester', 'toponymName', $place );
        $this->assertEquals( 'Greater Manchester', $place->getToponymName( ) );
        $this->assertArrayHasKey( 'toponymName', $place->toArray( ) );
        $this->assertEquals( 'Greater Manchester', $place->toArray( )[ 'toponymName' ] );

        $this->assertInstanceOf( Feature::class, $place->setFcl( 'P' ) );
        $this->assertAttributeEquals( 'P', 'fcl', $place );
        $this->assertEquals( 'P', $place->getFcl( ) );
        $this->assertArrayHasKey( 'fcl', $place->toArray( ) );
        $this->assertEquals( 'P', $place->toArray( )[ 'fcl' ] );

        $this->assertInstanceOf( Feature::class, $place->setFcode( 'PPL' ) );
        $this->assertAttributeEquals( 'PPL', 'fcode', $place );
        $this->assertEquals( 'PPL', $place->getFcode( ) );
        $this->assertArrayHasKey( 'fcode', $place->toArray( ) );
        $this->assertEquals( 'PPL', $place->toArray( )[ 'fcode' ] );

        $this->assertInstanceOf( Feature::class, $place->setPopulation( 100000 ) );
        $this->assertAttributeEquals( 100000, 'population', $place );
        $this->assertEquals( 100000, $place->getPopulation( ) );

        $this->assertInstanceOf( Feature::class, $place->setElevation( 300 ) );
        $this->assertAttributeEquals( 300, 'elevation', $place );
        $this->assertEquals( 300, $place->getElevation( ) );

        $this->assertInstanceOf( Feature::class, $place->setStrm3( 400 ) );
        $this->assertAttributeEquals( 400, 'strm3', $place );
        $this->assertEquals( 400, $place->getStrm3( ) );

        $this->assertInstanceOf( Feature::class, $place->setAstergdem( 500 ) );
        $this->assertAttributeEquals( 500, 'astergdem', $place );
        $this->assertEquals( 500, $place->getAstergdem( ) );

        $this->assertInstanceOf( Feature::class, $place->setCc2( 'GB,SE,DK,FI,NO,IE,LT,LV,EE,IS,JE,IM,GG,FO,AX' ) );
        $this->assertAttributeEquals( 'GB,SE,DK,FI,NO,IE,LT,LV,EE,IS,JE,IM,GG,FO,AX', 'cc2', $place );
        $this->assertEquals( 'GB,SE,DK,FI,NO,IE,LT,LV,EE,IS,JE,IM,GG,FO,AX', $place->getCc2( ) );
        $this->assertEquals( [ 'GB','SE','DK','FI','NO','IE','LT','LV','EE','IS','JE','IM','GG','FO','AX' ],
            $place->getAlternateCountryCodes( )
        );


        $this->assertInstanceOf( Feature::class, $place->setContinentCode( 'EU' ) );
        $this->assertAttributeEquals( 'EU', 'continentCode', $place );
        $this->assertEquals( 'EU', $place->getContinentCode( ) );


    }

    public function testClassification( )
    {
        $place = new Feature( );
        $place->setFcl( 'P' );
        $place->setFcode( 'PPLA' );
        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Classification::class, $place->getClassification( ) );
        $this->assertEquals( 'P', $place->getClassification( )->getClass( ) );
        $this->assertEquals( 'PPLA', $place->getClassification( )->getCode( ) );
    }

    public function testCountry( )
    {
        $country = new Country( 'GB', 'Great Britain' );
        $place = new Feature( );
        $place->setCountry( $country );
        $this->assertInstanceOf( Country::class, $place->getCountry( ) );
        $this->assertEquals( 'GB', $place->getCountry( )->getCode( ) );
        $this->assertEquals( 'Great Britain', $place->getCountry( )->getName( ) );
        $this->assertEquals( 'Great Britain', $place->getCountry( )->__toString( ) );
        $this->assertEquals( 'Great Britain', ( string ) $place->getCountry( ) );
        $this->assertArrayHasKey( 'country', $place->toArray( ) );
        $this->assertEquals( [
            'code' => 'GB',
            'name' => 'Great Britain'
        ], $place->toArray( )[ 'country' ] );

        unset( $place );

        $country = new Country( 'GB' );
        $country->setName( 'Great Britain' );
        $place = new Feature( );
        $place->setCountry( $country );
        $this->assertInstanceOf( Country::class, $place->getCountry( ) );
        $this->assertEquals( 'Great Britain', $place->getCountry( )->getName( ) );
        unset( $place );

    }

    public function testAlternateNames( )
    {
        $place = new Feature( );

        $names = [
            new AlternateName( 'ab', 'Лондан' ),
            new AlternateName( 'af', 'Londen' ),
            new AlternateName( 'als', 'London' ),
        ];

        $place->setAlternateNames( $names );

        $this->assertInternalType( 'array', $place->getAlternateNames( ) );
        $this->assertEquals( 3, count( $place->getAlternateNames( ) ) );
        $this->assertArrayHasKey( 'af', $place->getAlternateNames( ) );
        $this->assertInstanceOf( AlternateName::class, $place->getAlternateNames( )[ 'af' ] );
        $this->assertEquals( 'af', $place->getAlternateNames( )[ 'af' ]->getLanguage( ) );
        $this->assertEquals( 'Londen', $place->getAlternateNames( )[ 'af' ]->getName( ) );

        $this->assertEquals( 'af', $place->getAlternateName( 'af' )->getLanguage( ) );
        $this->assertEquals( 'Londen', $place->getAlternateName( 'af' )->getName( ) );

        $this->assertNull( $place->getAlternateName( 'es' ) );

        $place->addAlternateName( new AlternateName( 'es', 'Londres' ) );
        $this->assertEquals( 4, count( $place->getAlternateNames( ) ) );
        $this->assertEquals( 'Londres', $place->getAlternateName( 'es' )->getName( ) );

    }

    public function testAdminCodeLevel( )
    {
        $manchester = new Feature( );
        $this->assertEquals( 0, $manchester->getAdminCodeLevel( ) );

        $uk = new Feature( );
        $uk->setAdminCode1( '00' );
        $this->assertEquals( 1, $uk->getAdminCodeLevel( ) );

        $greaterLondon = new Feature( );
        $greaterLondon->setAdminCode1( '00' );
        $greaterLondon->setAdminCode2( 'GLA' );
        $this->assertEquals( 2, $greaterLondon->getAdminCodeLevel( ) );

        $barnet = new Feature( );
        $barnet->setAdminCode1( '00' );
        $barnet->setAdminCode2( 'GLA' );
        $barnet->setAdminCode3( 'A2' );
        $this->assertEquals( 3, $barnet->getAdminCodeLevel( ) );
    }

    public function testCoordinates( )
    {
        $place = new Feature( );
        $coordinates = new \Lukaswhite\Geonames\Models\Coordinate( [ 53.41667, -2.25 ] );
        $this->assertInstanceOf( Feature::class, $place->setCoordinates( $coordinates ) );
        $this->assertArrayHasKey( 'latitude', $place->toArray( ) );
        $this->assertEquals( 53.41667, $place->toArray( )[ 'latitude' ] );
        $this->assertEquals( -2.25, $place->toArray( )[ 'longitude' ] );
    }

}