<?php

class FeaturesTest extends PHPUnit_Framework_TestCase{

    public function testDefaultFilename( )
    {
        $features = new \Lukaswhite\Geonames\Meta\Features( );
        $this->assertStringEndsWith(
            'src/Lukaswhite/Geonames/Meta/../../../../data/featureCodes_en.txt',
            $features->getFilepath( )
        );
    }

    public function testLoad( )
    {
        $features = new \Lukaswhite\Geonames\Meta\Features(
            sprintf(
                '%s/../fixtures/meta/featureCodes_en.txt',
                __DIR__
            )
        );
        $countryStateRegion = $features->getClass( 'A' );
        $this->assertInstanceOf(
            \Lukaswhite\Geonames\Meta\FeatureClass::class,
            $countryStateRegion
        );
        $this->assertEquals( 'country, state, region,...', $countryStateRegion->getName( ) );
    }

    public function testGetCodeFromClass( )
    {
        $features = new \Lukaswhite\Geonames\Meta\Features(
            sprintf(
                '%s/../fixtures/meta/featureCodes_en.txt',
                __DIR__
            )
        );

        $countryStateRegion = $features->getClass( 'A' );

        $adm1 = $countryStateRegion->getCode( 'ADM1' );
        $this->assertInstanceOf(
            \Lukaswhite\Geonames\Meta\FeatureCode::class,
            $adm1
        );
        $this->assertEquals(
            'first-order administrative division',
            $adm1->getName( )
        );
        $this->assertEquals(
            'a primary administrative division of a country, such as a state in the United States',
            $adm1->getDescription( )
        );
    }

    public function testGetCodeUsingDotSyntax( )
    {
        $features = new \Lukaswhite\Geonames\Meta\Features(
            sprintf(
                '%s/../fixtures/meta/featureCodes_en.txt',
                __DIR__
            )
        );

        $adm1 = $features->getCode( 'A.ADM1' );

        $this->assertInstanceOf(
            \Lukaswhite\Geonames\Meta\FeatureCode::class,
            $adm1
        );
        $this->assertEquals(
            'first-order administrative division',
            $adm1->getName( )
        );
        $this->assertEquals(
            'a primary administrative division of a country, such as a state in the United States',
            $adm1->getDescription( )
        );
    }

    public function testGetCodeByCode( )
    {
        $features = new \Lukaswhite\Geonames\Meta\Features(
            sprintf(
                '%s/../fixtures/meta/featureCodes_en.txt',
                __DIR__
            )
        );

        $adm1 = $features->getCode( 'ADM1' );

        $this->assertInstanceOf(
            \Lukaswhite\Geonames\Meta\FeatureCode::class,
            $adm1
        );
        $this->assertEquals(
            'first-order administrative division',
            $adm1->getName( )
        );
        $this->assertEquals(
            'a primary administrative division of a country, such as a state in the United States',
            $adm1->getDescription( )
        );
    }

    public function testGetCodeThatDoesNotExist( )
    {
        $features = new \Lukaswhite\Geonames\Meta\Features(
            sprintf(
                '%s/../fixtures/meta/featureCodes_en.txt',
                __DIR__
            )
        );

        $this->assertNull( $features->getCode( 'FOO' ) );

    }

    public function testFeatureClassModel( )
    {
        $featureClass = new \Lukaswhite\Geonames\Meta\FeatureClass( 'A' );
        $this->assertEquals( 'A', $featureClass->getClass( ) );
        $featureClass->setName( 'country, state, region,...' );
        $this->assertEquals( 'country, state, region,...', $featureClass->getName( ) );
        $this->assertEquals( [ ], $featureClass->getCodes( ) );
        $featureClass->setClass( 'S' );
        $this->assertEquals( 'S', $featureClass->getClass( ) );
        $featureClass->setCodes( [ 1, 2, 3 ], $featureClass->getCodes( ) );
    }

    public function testFeatureCodeModel( )
    {
        $featureCode = new \Lukaswhite\Geonames\Meta\FeatureCode( 'ADM1' );
        $this->assertEquals( 'ADM1', $featureCode->getCode( ) );
        $featureCode->setName( 'first-order administrative division' );
        $this->assertEquals( 'first-order administrative division', $featureCode->getName( ) );
        $this->assertEquals( 'first-order administrative division', ( string ) $featureCode );
        $featureCode->setDescription( 'a primary administrative division of a country, such as a state in the United States' );
        $this->assertEquals( 'a primary administrative division of a country, such as a state in the United States', $featureCode->getDescription( ) );
        $featureCode->setCode( 'ADM2' );
        $this->assertEquals( 'ADM2', $featureCode->getCode( ) );
    }

    public function testFeaturesToArray( )
    {
        $features = new \Lukaswhite\Geonames\Meta\Features(
            sprintf(
                '%s/../fixtures/meta/featureCodes_en.txt',
                __DIR__
            )
        );

        $table = $features->toArray( );

        $this->assertEquals( 679, count( $table ) );

        $adm1 = $table[ 0 ];
        $this->assertInternalType( 'array', $adm1 );
        $this->assertEquals( 4, count( $table[ 0 ] ) );
        $this->assertEquals( 'A', $table[ 0 ][ 0 ] );
        $this->assertEquals( 'ADM1', $table[ 0 ][ 1 ] );
        $this->assertEquals( 'first-order administrative division', $table[ 0 ][ 2 ] );
        $this->assertEquals(
            'a primary administrative division of a country, such as a state in the United States',
            $table[ 0 ][ 3 ]
        );


    }


}