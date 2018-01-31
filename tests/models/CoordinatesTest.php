<?php

use Lukaswhite\Geonames\Models\Coordinate;
use Lukaswhite\Geonames\Models\Feature;

class CoordinatesTest extends PHPUnit_Framework_TestCase{

    public function testConstructorWithLatLng( )
    {
        $coordinates = new Coordinate( [ 52.19634, 1.95727 ] );
        $this->assertEquals( 1.95727 , $coordinates->getLongitude( ) );
        $this->assertEquals( 52.19634 , $coordinates->getLatitude( ) );
    }

    public function testConstructorNoArgs( )
    {
        $coordinates = new Coordinate( );
        $this->assertInstanceOf( Coordinate::class, $coordinates->setLatitude( 52.19634 ) );
        $this->assertInstanceOf( Coordinate::class, $coordinates->setLongitude( 1.95727 ) );
        $this->assertEquals( 1.95727 , $coordinates->getLongitude( ) );
        $this->assertEquals( 52.19634 , $coordinates->getLatitude( ) );
    }

    public function testCreatingStringRepresentation( )
    {
        $coordinates = new Coordinate( [ 52.19634, 1.95727 ] );
        $this->assertEquals( '52.19634, 1.95727',  ( string ) $coordinates );
    }

    public function testSetterAndGetter( )
    {
        $place = new \Lukaswhite\Geonames\Models\Feature( );
        $coordinates = new Coordinate( [ 52.19634, 1.95727 ] );
        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Feature::class, $place->setCoordinates( $coordinates ) );
        $this->assertInstanceOf( Coordinate::class, $place->getCoordinates( ) );
        $this->assertEquals( 1.95727 , $place->getCoordinates( )->getLongitude( ) );
        $this->assertEquals( 52.19634 , $place->getCoordinates( )->getLatitude( ) );
        $this->assertEquals( 1.95727 , $place->getLongitude( ) );
        $this->assertEquals( 52.19634 , $place->getLatitude( ) );
    }

    public function testCreateArrayRepresentation( )
    {
        $coordinates = new Coordinate( [ 52.19634, 1.95727 ] );
        $this->assertEquals( [
            'latitude' => 52.19634,
            'longitude' => 1.95727
        ], $coordinates->toArray( true ) );
        $this->assertEquals( [
            52.19634,
            1.95727
        ], $coordinates->toArray( false ) );
        $this->assertEquals( [
            52.19634,
            1.95727
        ], $coordinates->toArray( ) );
    }

}