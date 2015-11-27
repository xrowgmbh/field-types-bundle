<?php
/**
 * File containing the XrowGis Value class
 */
namespace xrow\FieldTypesBundle\FieldType\XrowGis;

use eZ\Publish\Core\FieldType\Value as BaseValue;
/**
 * Value for XrowGis field type
 */
class Value extends BaseValue
{
   /**
     * Latitude of the location
     *
     * @var float
     */
    public $latitude;

    /**
     * Longitude of the location
     *
     * @var float
     */
    public $longitude;

    /**
     * Display street for the location
     *
     * @var string
     */
    public $street;
    /**
     * Display zip for the location
     *
     * @var zip
     */
    public $zip;
    /**
     * Display distric for the location
     *
     * @var distric
     */
    public $district;
    /**
     * Display city for the location
     *
     * @var city
     */
    public $city;
    /**
     * Display state for the location
     *
     * @var state
     */
    public $state;
    /**
     * Display country for the location
     *
     * @var country
     */
    public $country;
    
    /**
     * Construct a new Value object and initialize with $values
     *
     * @param string[]|string $values
     */
    public function __construct( array $values = null )
    {
        foreach ( (array)$values as $key => $value )
        {
            $this->$key = $value;
        }
    }
    /**
     * Returns a string representation of the keyword value.
     *
     * @return string A comma separated list of tags, eg: "php, eZ Publish, html5"
     */
    public function __toString()
    {
        return (string)($this->street.",".$this->zip.",".$this->city);
    }
}