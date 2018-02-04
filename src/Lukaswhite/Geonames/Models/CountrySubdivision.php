<?php namespace Lukaswhite\Geonames\Models;

use Lukaswhite\Geonames\Contracts\HasAdminCodes as HasAdminCodesContract;
use Lukaswhite\Geonames\Contracts\HasAdminCodeNames as HasAdminCodeNamesContract;
use Lukaswhite\Geonames\Contracts\HasAdministrativeDivisions as HasAdministrativeDivisionsContract;
use Lukaswhite\Geonames\Traits\Models\HasAdminCodes;
use Lukaswhite\Geonames\Traits\Models\HasAdministrativeDivisions;
use Lukaswhite\Geonames\Traits\Models\HasCountryCode;
use Lukaswhite\Geonames\Traits\Models\HasCountryName;
use Lukaswhite\Geonames\Traits\Models\HasDistance;

/**
 * Class CountrySubdivision
 *
 * Represents an administrative subdivision of a country
 *
 * @package Lukaswhite\Geonames\Models
 */
class CountrySubdivision implements HasAdminCodesContract, HasAdminCodeNamesContract, HasAdministrativeDivisionsContract
{
    use HasCountryCode,
        HasCountryName,
        HasAdminCodes,
        HasAdministrativeDivisions,
        HasDistance;

    /**
     * The code
     *
     * @var Code
     */
    private $code;

    /**
     * CountrySubdivision constructor.
     */
    public function __construct( )
    {
        $this->code = new Code( );
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get the name
     *
     * @return string
     */
    public function getName( )
    {
        if ( isset( $this->adminName1 ) && strlen( $this->adminName1 ) ) {
            return $this->adminName1;
        }

        return $this->countryName;
    }

    /**
     * Get the code
     *
     * @return string
     */
    /**
    public function __getCode( )
    {
        if ( isset( $this->adminCode1 ) && strlen( $this->adminCode1 ) ) {
            return $this->adminCode1;
        }

        return $this->countryCode;
    }
     **/

    /**
     * Get a string representation of this country subdivision
     *
     * @return string
     */
    public function __toString( )
    {
        if ( isset( $this->adminName1 ) && strlen( $this->adminName1 ) ) {
            return sprintf(
                '%s, %s',
                $this->adminName1,
                $this->countryName
            );
        }

        return $this->countryName;
    }
}