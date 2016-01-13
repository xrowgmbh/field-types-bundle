<?php
/*
 * xrowmetadata
 *
 */
namespace xrow\FieldTypesBundle\FieldType\XrowMetadata;

use eZ\Publish\Core\FieldType\FieldType;
use eZ\Publish\Core\FieldType\Value as BaseValue;
use eZ\Publish\SPI\FieldType\Value as SPIValue;
use eZ\Publish\SPI\Persistence\Content\FieldValue as FieldValue;
use eZ\Publish\Core\Base\Exceptions\InvalidArgumentType;

/**
 * xrowMetadata field types
 *
 * Represents Metadata.
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
        return "xrowmetadata";
    }
    
    /* (non-PHPdoc)
     * @see \eZ\Publish\SPI\FieldType\FieldType::getName()
    */
    public function getName ( SPIValue $value )
    {
        return implode( ', ', $value->keywords );;
    }
    
    /* (non-PHPdoc)
     * @see \eZ\Publish\SPI\FieldType\FieldType::getEmptyValue()
    */
    public function getEmptyValue ()
    {
        return new Value(array());
    }
    /* (non-PHPdoc)
     * @see \eZ\Publish\Core\FieldType\FieldType::createValueFromInput()
     */
    protected function createValueFromInput( $inputValue )
    {
        if ( is_array( $inputValue ) )
        {
            $inputValue = new Value( $inputValue );
        }

        return $inputValue;
    }
    /* (non-PHPdoc)
     * @see \eZ\Publish\Core\FieldType\FieldType::checkValueStructure()
     */
    protected function checkValueStructure ( BaseValue $value )
    {
        if ( !is_array( $value->keywords ) )
        {
            throw new InvalidArgumentType(
                '$value->keywords',
                'array',
                $value->keywords
            );
        }
    }

    protected function getSortInfo( BaseValue $value )
    {
        return false;
    }
    
    /* (non-PHPdoc)
     * @see \eZ\Publish\SPI\FieldType\FieldType::fromHash()
     */
    public function fromHash ( $hash )
    {
       return new Value( $hash );
    }
    /* (non-PHPdoc)
     * @see \eZ\Publish\SPI\FieldType\FieldType::toHash()
     */
    public function toHash ( SPIValue $value )
    {
        return array('keywords' => $value->keywords);
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
    
    public function toPersistenceValue( SPIValue $value )
    {
        return new FieldValue(
            array(
                "data" => null,
                "externalData" => $value->keywords,
                "sortKey" => $this->getSortInfo( $value ),
            )
        );
    }
    public function fromPersistenceValue( FieldValue $fieldValue )
    {
        return $this->fromHash( $fieldValue->externalData );
    }
}