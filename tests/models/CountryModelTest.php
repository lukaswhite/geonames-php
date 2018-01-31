<?php

use Lukaswhite\Geonames\Models\Country;

class CountryModelTest extends PHPUnit_Framework_TestCase{

    public function testSettersAndGetters( )
    {
        $country = new Country( 'GB' );

        $country->setName( 'United Kingdom' )
            ->setId( 2635167 )
            ->setIsoNumeric( 826 )
            ->setIsoAlpha3( 'GBR' )
            ->setFipsCode( 'UK' )
            ->setContinent( \Lukaswhite\Geonames\Models\Continent::EUROPE )
            ->setContinentName( 'Europe' )
            ->setCapital( 'London' )
            ->setAreaInSqKm( 244820.0 )
            ->setPopulation( 62348447 )
            ->setCurrencyCode( 'GBP' )
            ->setLanguages( 'en-GB,cy-GB,gd' )
            ->setPostalCodeFormat( '@# #@@|@## #@@|@@# #@@|@@## #@@|@#@ #@@|@@#@ #@@|GIR0AA' )
            ->setBoundingBox(
                new \Lukaswhite\Geonames\Models\BoundingBox( [
                    'west' => -8.61772077108559,
                    'north' => 59.3607741849963,
                    'east' => 1.7689121033873,
                    'south' => 49.9028622252397,
                ] )
            );


        $this->assertEquals( 'United Kingdom', $country->getName( ) );
        $this->assertEquals( 2635167, $country->getId( ) );
        $this->assertEquals( 826, $country->getIsoNumeric( ) );
        $this->assertEquals( 'GBR', $country->getIsoAlpha3( ) );
        $this->assertEquals( 'UK', $country->getFipsCode( ) );
        $this->assertEquals( \Lukaswhite\Geonames\Models\Continent::EUROPE, $country->getContinent( ) );
        $this->assertEquals( 'Europe', $country->getContinentName( ) );
        $this->assertEquals( 'London', $country->getCapital( ) );
        $this->assertEquals( 244820.0, $country->getAreaInSqKm( ) );
        $this->assertEquals( 62348447, $country->getPopulation( ) );
        $this->assertEquals( 'GBP', $country->getCurrencyCode( ) );
        $this->assertEquals( [ 'en-GB', 'cy-GB', 'gd' ], $country->getLanguages( ) );
        $this->assertEquals( '@# #@@|@## #@@|@@# #@@|@@## #@@|@#@ #@@|@@#@ #@@|GIR0AA', $country->getPostalCodeFormat( ) );
        $this->assertEquals( -8.61772077108559, $country->getBoundingBox( )->getWest( ) );
        $this->assertEquals( 59.3607741849963, $country->getBoundingBox( )->getNorth( ) );
        $this->assertEquals( 1.7689121033873, $country->getBoundingBox( )->getEast( ) );
        $this->assertEquals( 49.9028622252397, $country->getBoundingBox( )->getSouth( ) );

    }

    public function testLanguages( )
    {
        $country = new Country( 'GB' );
        $country->setLanguages( 'en-GB,cy-GB,gd' );
        $this->assertEquals( [ 'en-GB', 'cy-GB', 'gd' ], $country->getLanguages( ) );
        unset( $country );

        $country = new Country( 'GB' );
        $country->setLanguages( [ 'en-GB', 'cy-GB', 'gd' ] );
        $this->assertEquals( [ 'en-GB', 'cy-GB', 'gd' ], $country->getLanguages( ) );
        unset( $country );

    }


}