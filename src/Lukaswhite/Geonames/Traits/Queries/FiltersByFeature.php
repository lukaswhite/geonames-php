<?php namespace Lukaswhite\Geonames\Traits\Queries;

/**
 * Class FiltersByFeature
 *
 * This trait indicates that a query type allows results to be filtered by feature (class / code)
 *
 * @package Lukaswhite\Geonames\Traits\Queries
 */
trait FiltersByFeature
{
    /**
     * The feature classes to limit the query to
     *
     * @var array
     */
    private $featureClasses = [ ];

    /**
     * The feature codes to limit the query to
     *
     * @var array
     */
    private $featureCodes = [ ];

    /**
     * Filter the query by feature code(s)
     *
     * @param array $codes
     * @return $this
     */
    public function filterByFeatureCode( ...$codes )
    {
        $this->featureCodes = $codes;
        return $this;
    }

    /**
     * Filter the query by feature class(es)
     *
     * @param array $classes
     * @return $this
     */
    public function filterByFeatureClass( ...$classes )
    {
        $this->featureClasses = $classes;
        return $this;
    }

    /**
     * Restrict the selection to countries, states, regions; syntactic sugar for filterByFeatureClass( 'A' )
     *
     * @return $this
     */
    public function justCountriesStatesRegions( )
    {
        return $this->filterByFeatureClass( 'A' );
    }

    /**
     * Restrict the selection to cities, villages syntactic sugar for filterByFeatureClass( 'P' )
     *
     * @return $this
     */
    public function justCitiesVillages( )
    {
        return $this->filterByFeatureClass( 'P' );
    }

    /**
     * Optionally add the feature filters to the query
     *
     * @param array
     */
    private function addFeatureFiltersToQuery( & $query )
    {
        // Optionally filter by feature class(es)
        if ( count( $this->featureClasses ) ) {
            $query[ 'featureClass' ] = $this->featureClasses;
        }

        // Optionally filter by feature class(es)
        if ( count( $this->featureCodes ) ) {
            $query[ 'featureCode' ] = $this->featureCodes;
        }
    }

}