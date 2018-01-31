<?php

use Lukaswhite\Geonames\Models\Feature;
use Lukaswhite\Geonames\Models\Country;
use Lukaswhite\Geonames\Models\BoundingBox;
use Lukaswhite\Geonames\Models\Coordinate;

class BoundingBoxTest extends PHPUnit_Framework_TestCase{

    public function testConstructor( )
    {
        $boundingBox = new BoundingBox( );
        unset( $boundingBox );

        $boundingBox = new BoundingBox(
            [
                'west' => 1.95727,
                'north' => 52.19634,
                'east' => 1.44968,
                'south' => 50.57491,
            ]
        );

        $this->assertEquals( 1.95727, $boundingBox->getWest() );
        $this->assertEquals( 52.19634, $boundingBox->getNorth() );
        $this->assertEquals( 1.44968, $boundingBox->getEast() );
        $this->assertEquals( 50.57491, $boundingBox->getSouth() );

        unset( $boundingBox );

        // Just ensure that it doesn't break if you pass it an invalid axis
        $boundingBox = new BoundingBox(
            [
                'foo' => 1.95727,
            ]
        );
    }

    public function testSettingBoundingBoxInstance( )
    {
        $place = new Feature( );
        $boundingBox = new BoundingBox( );
        $boundingBox->setEast( 1.44968 );
        $this->assertInstanceOf( Feature::class, $place->setBoundingBox( $boundingBox ) );
        $this->assertInstanceOf( BoundingBox::class, $place->getBoundingBox( ) );
        $this->assertEquals( 1.44968, $place->getBoundingBox( )->getEast( ) );
    }

    public function testCoordinates( )
    {
        $boundingBox = new BoundingBox( );

        $northWest = new Coordinate( );
        $northWest->setLatitude( 52.19634 );
        $northWest->setLongitude( 1.95727 );

        $southEast = new Coordinate( );
        $southEast->setLatitude( 50.57491 );
        $southEast->setLongitude( 1.44968 );

        $this->assertEquals( $boundingBox, $boundingBox->setNorthWest( $northWest ) );
        $this->assertEquals( $boundingBox, $boundingBox->setSouthEast( $southEast ) );

        $this->assertInstanceOf( Coordinate::class, $boundingBox->getNorthWest( ) );
        $this->assertEquals( $northWest->getLatitude( ), $boundingBox->getNorthWest( )->getLatitude( ) );
        $this->assertEquals( $northWest->getLongitude( ), $boundingBox->getNorthWest( )->getLongitude( ) );
        $this->assertEquals( $southEast->getLatitude( ), $boundingBox->getSouthEast( )->getLatitude( ) );
        $this->assertEquals( $southEast->getLongitude( ), $boundingBox->getSouthEast( )->getLongitude( ) );
        $this->assertEquals( 1.95727, $boundingBox->getWest() );
        $this->assertEquals( 52.19634, $boundingBox->getNorth() );
        $this->assertEquals( 1.44968, $boundingBox->getEast() );
        $this->assertEquals( 50.57491, $boundingBox->getSouth() );
    }

    public function testParameterize( )
    {
        $place = new Feature( );

        $this->assertEquals( [ ], $place->parameterizeBoundingBox( ) );

        $boundingBox = new BoundingBox( );
        $boundingBox->setWest( 1.95727 );
        $boundingBox->setNorth( 52.19634 );
        $boundingBox->setEast( 1.44968 );
        $boundingBox->setSouth( 50.57491 );
        $place->setBoundingBox( $boundingBox );
        $this->assertEquals( [
            'west' => 1.95727,
            'north' => 52.19634,
            'east' => 1.44968,
            'south' => 50.57491,
        ], $place->parameterizeBoundingBox( ) );
    }

}