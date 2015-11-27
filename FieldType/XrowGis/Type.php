<?php
/*
 * File containing the XrowGis field type
 *
 */

namespace xrow\FieldTypesBundle\FieldType\XrowGis;

use eZ\Publish\Core\FieldType\FieldType;
use eZ\Publish\SPI\Persistence\Content\FieldValue;
use eZ\Publish\Core\Base\Exceptions\InvalidArgumentType;
use eZ\Publish\SPI\FieldType\Value as SPIValue;
use eZ\Publish\Core\FieldType\Value as BaseValue;

/**
 * XrowGis field types
 *
 * Represents keywords.
 */
class Type extends FieldType
{
    /**
     * Returns the field type identifier for this field type
     *
     * @return string
     */
    public function getFieldTypeIdentifier ()
    {
        return "xrowgis";
    }
    
    /**
     * Returns the name of the given field value.
     *
     * It will be used to generate content name and url alias if current field is designated
     * to be used in the content name/urlAlias pattern.
     *
     * @param \xrow\field-types-bundle\FieldType\XrowGis\Value $value
     *
     * @return string
     */
    public function getName ( SPIValue $value )
    {
        return (string)($value->street.",".$value->zip.",".$value->city);
    }
    
    /**
     * Returns the fallback default value of field type when no such default
     * value is provided in the field definition in content types.
     *
     * @return \xrow\field-types-bundle\FieldType\XrowGis\Value
     */
    public function getEmptyValue ()
    {
        return new Value;
    }
    
    /**
     * Returns if the given $value is considered empty by the field type
     *
     * @param mixed $value
     *
     * @return boolean
     */
    public function isEmptyValue( SPIValue $value )
    {
        return $value->latitude === null && $value->longitude === null;
    }
    
    
   /**
     * Inspects given $inputValue and potentially converts it into a dedicated value object.
     *
     * @param array|\xrow\field-types-bundle\FieldType\XrowGis\Value $inputValue
     *
     * @return \xrow\field-types-bundle\FieldType\XrowGis\Value The potentially converted and structurally plausible value.
     */
    protected function createValueFromInput( $inputValue )
    {
        if ( is_array( $inputValue ) )
        {
            $inputValue = new Value( $inputValue );
        }

        return $inputValue;
    }

   /**
     * Throws an exception if value structure is not of expected format.
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException If the value does not match the expected structure.
     *
     * @param \xrow\field-types-bundle\FieldType\XrowGis\Value $value
     *
     * @return void
     */
    protected function checkValueStructure( BaseValue $value )
    {
        if ( !is_float( $value->latitude ) && !is_int( $value->latitude ) )
        {
            throw new InvalidArgumentType(
                '$value->latitude',
                'float',
                $value->latitude
            );
        }
        if ( !is_float( $value->longitude ) && !is_int( $value->longitude ) )
        {
            throw new InvalidArgumentType(
                '$value->longitude',
                'float',
                $value->longitude
            );
        }
        if ( !is_string( $value->street ) )
        {
            throw new InvalidArgumentType(
                '$value->street',
                'string',
                $value->street
            );
        }
        if ( !is_string( $value->zip ) )
        {
            throw new InvalidArgumentType(
                '$value->zip',
                'string',
                $value->zip
            );
        }
        if ( !is_string( $value->district ) )
        {
            throw new InvalidArgumentType(
                '$value->district',
                'string',
                $value->district
            );
        }
        if ( !is_string( $value->city ) )
        {
            throw new InvalidArgumentType(
                '$value->city',
                'string',
                $value->city
            );
        }
        if ( !is_string( $value->state ) )
        {
            throw new InvalidArgumentType(
                '$value->state',
                'string',
                $value->state
            );
        }
        if ( !is_string( $value->country ) )
        {
            throw new InvalidArgumentType(
                '$value->country',
                'string',
                $value->country
            );
        }
    }
    
    /**
     * Returns information for FieldValue->$sortKey relevant to the field type.
     *
     * @param \xrow\field-types-bundle\FieldType\XrowGis\Value $value
     *
     * @return string
     */
    protected function getSortInfo( BaseValue $value )
    {
        return $this->transformationProcessor->transformByGroup( (string)$value, "lowercase" );
    }

    /**
     * Converts an $hash to the Value defined by the field type
     *
     * @param mixed $hash
     *
     * @return \xrow\field-types-bundle\FieldType\XrowGis\Value $value
     */
    public function fromHash( $hash )
    {
        if ( $hash === null )
        {
            return $this->getEmptyValue();
        }
        return new Value( $hash );
    }

    /**
     * Converts a $Value to a hash
     *
     * @param \xrow\field-types-bundle\FieldType\XrowGis\Value $value
     *
     * @return mixed
     */
    public function toHash( SPIValue $value )
    {
        if ( $this->isEmptyValue( $value ) )
        {
            return null;
        }
        return array(
            'latitude' => $value->latitude,
            'longitude' => $value->longitude,
            'street' => $value->street,
            'zip' => $value->zip,
            'district' => $value->district,
            'city' => $value->city,
            'state' => $value->state,
            'country' => $value->country
        );
    }

    /**
     * Returns whether the field type is searchable
     *
     * @return boolean
     */
    public function isSearchable()
    {
        return true;
    }

    /**
     * Converts a $value to a persistence value
     *
     * @param \xrow\field-types-bundle\FieldType\XrowGis\Value $value
     *
     * @return \eZ\Publish\SPI\Persistence\Content\FieldValue
     */
    public function toPersistenceValue( SPIValue $value )
    {
        return new FieldValue(
            array(
                "data" => null,
                "externalData" => $this->toHash( $value ),
                "sortKey" => $this->getSortInfo( $value ),
            )
        );
    }

    /**
     * Converts a persistence $fieldValue to a Value
     *
     * @param \eZ\Publish\SPI\Persistence\Content\FieldValue $fieldValue
     *
     * @return \xrow\field-types-bundle\FieldType\XrowGis\Value
     */
    public function fromPersistenceValue( FieldValue $fieldValue )
    {
        if ( $fieldValue->externalData === null )
        {
            return $this->getEmptyValue();
        }
        return $this->fromHash( $fieldValue->externalData );
    }
}