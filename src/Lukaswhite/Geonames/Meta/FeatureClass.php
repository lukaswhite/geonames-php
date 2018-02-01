<?php namespace Lukaswhite\Geonames\Meta;

class FeatureClass
{
    /**
     * The class; i.e. the single character
     *
     * @var string
     */
    private $class;

    /**
     * The name
     *
     * @var string
     */
    private $name;

    /**
     * The feature codes that make up this feature class
     *
     * @var array
     */
    private $codes = [ ];

    /**
     * FeatureClass constructor.
     *
     * @param string $class
     * @param string $name
     */
    public function __construct( $class, $name = null )
    {
        $this->class = $class;
        if ( $name ) {
            $this->name = $name;
        }
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param string $class
     * @return FeatureClass
     */
    public function setClass( string $class ): FeatureClass
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return FeatureClass
     */
    public function setName( string $name ): FeatureClass
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodes()
    {
        return $this->codes;
    }

    /**
     * @param mixed $codes
     * @return FeatureClass
     */
    public function setCodes( $codes )
    {
        $this->codes = $codes;
        return $this;
    }

    /**
     * Add a code to this feature class
     *
     * @param FeatureCode $code
     * @return $this
     */
    public function addCode( FeatureCode $code )
    {
        $this->codes[ $code->getCode( ) ] = $code;
        return $this;
    }

    /**
     * Get a feature code
     *
     * @param string $code
     * @return FeatureCode
     */
    public function getCode( $code )
    {
        return ( isset( $this->codes[ $code ] ) ) ? $this->codes[ $code ] : null;
    }
}