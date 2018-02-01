<?php namespace Lukaswhite\Geonames\Meta;

class Features
{
    /**
     * The path to the data file
     *
     * @var string
     */
    private $filepath;

    /**
     * The feature classes
     *
     * @var array
     */
    private $classes;

    /**
     * Features constructor.
     *
     * @param string $filepath
     */
    public function __construct( $filepath = null )
    {
        if ( ! $filepath ) {
            $this->filepath = sprintf(
                '%s/../../../../data/%s',
                __DIR__,
                'featureCodes_en.txt'
            );
        } else {
            $this->filepath = $filepath;
        }

        foreach(
            [
                'A'     =>  'country, state, region,...',
                'H'     =>  'stream, lake, ...',
                'L'     =>  'parks,area, ...',
                'P'     =>  'city, village,...',
                'R'     =>  'road, railroad',
                'S'     =>  'spot, building, farm',
                'T'     =>  'mountain,hill,rock,...',
                'U'     =>  'undersea',
                'V'     =>  'forest,heath,...',
            ]
            as $class => $name )
        {
            $this->classes[ $class ] = new FeatureClass( $class, $name );
        }

        $this->load( );
    }

    /**
     * Load the data
     *
     * @return void
     */
    private function load( )
    {
        $handle = fopen( $this->filepath, 'r' );
        //if ( ( $handle = fopen( $this->filepath, 'r' ) ) !== FALSE) {
        while ( ( $data = fgetcsv( $handle, 1000, "\t" ) ) !== FALSE) {
            if ( $data[ 0 ] !== 'null' ) {
                $parts = explode( '.', $data[ 0 ] );
                $this->classes[ $parts[ 0 ] ]->addCode(
                    new FeatureCode(
                        $parts[ 1 ],
                        $data[ 1 ],
                        isset( $data[ 2 ] ) ? $data[ 2 ] : null
                    )
                );
            }
        }
        fclose( $handle );

    }

    /**
     * Get a feature class by its single-character class
     *
     * @param string $class
     * @return FeatureClass
     */
    public function getClass( $class )
    {
        return $this->classes[ $class ];
    }

    /**
     * Get a feature code
     *
     * @param string $code
     * @return FeatureCode
     */
    public function getCode( $code )
    {
        // If it's in the format [CLASS].[CODE] (e.g. A.ADM1, A.PCLI, T.MT) then it's simple
        if ( preg_match( '/([A-Z])\.([A-Z0-9]*)/', $code, $parts ) ) {
            return $this->getClass( $parts[ 1 ] )->getCode( $parts[ 2 ] );
        }
        // Otherwise we need to do a simple search
        foreach( $this->classes as $class ) {
            if ( $featureCode = $class->getCode( $code ) ) {
                return $featureCode;
            }
        }
        return null;
    }

    /**
     * @return string
     */
    public function getFilepath(): string
    {
        return $this->filepath;
    }

    /**
     * Get an array representation of the features
     *
     * Row format is: feature class, feature code, name, description
     *
     * @return array
     */
    public function toArray( )
    {
        $rows = [ ];
        foreach( $this->classes as $class ) {
            foreach( $class->getCodes( ) as $code ) {
                $rows[ ] = [
                    $class->getClass( ),
                    $code->getCode( ),
                    $code->getName( ),
                    $code->getDescription( )
                ];
            }
        }
        return $rows;
    }
}