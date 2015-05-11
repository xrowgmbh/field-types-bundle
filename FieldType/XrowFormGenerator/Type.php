<?php
/*
 * xrowformgenerator
 *
 */

namespace xrow\FieldTypesBundle\FieldType\XrowFormGenerator;

use eZ\Publish\Core\FieldType\FieldType;
use eZ\Publish\Core\FieldType\Value as BaseValue;
use eZ\Publish\SPI\FieldType\Value as SPIValue;
use eZ\Publish\SPI\Persistence\Content\FieldValue as FieldValue;

class Type extends FieldType
{
    /* (non-PHPdoc)
     * @see \eZ\Publish\Core\FieldType\FieldType::createValueFromInput()
     */
    protected function createValueFromInput( $inputValue )
    {
        return new Value( $inputValue );
    }

    /* (non-PHPdoc)
     * @see \eZ\Publish\Core\FieldType\FieldType::checkValueStructure()
     */
    protected function checkValueStructure ( BaseValue $value )
    {
        // TODO Auto-generated method stub

    }

    /* (non-PHPdoc)
     * @see \eZ\Publish\SPI\FieldType\FieldType::getFieldTypeIdentifier()
     */
    public function getFieldTypeIdentifier ()
    {
        // TODO Auto-generated method stub
        return "xrowformgenerator";
    }

    /* (non-PHPdoc)
     * @see \eZ\Publish\SPI\FieldType\FieldType::getName()
     */
    public function getName ( SPIValue $value )
    {
        // TODO Auto-generated method stub

    }

    /* (non-PHPdoc)
     * @see \eZ\Publish\SPI\FieldType\FieldType::getEmptyValue()
     */
    public function getEmptyValue ()
    {
        // TODO Auto-generated method stub
        return new Value;
    }

    /* (non-PHPdoc)
     * @see \eZ\Publish\SPI\FieldType\FieldType::fromHash()
     */
    public function fromHash ( $hash )
    {
        // TODO Auto-generated method stub
       if ( $hash === null )
       {
           return $this->getEmptyValue();
       }
       return new Value( $hash );
    }

    public function isEmptyValue( SPIValue $value )
    {
        return false;
    }

    /* (non-PHPdoc)
     * @see \eZ\Publish\SPI\FieldType\FieldType::toHash()
     */
    public function toHash ( SPIValue $value )
    {
        // TODO Auto-generated method stub
        if ( $this->isEmptyValue( $value ) )
        {
           return null;
        }
        return $value->value;
    }

    protected function getSortInfo( BaseValue $value )
    {
        return false;
    }


    public function toPersistenceValue( SPIValue $value )
    {
        if ( $value === null )
        {
            return new FieldValue(
                array(
                    "data" => null
                )
            );
        }
        return new FieldValue(
            array(
                "data" => $this->toHash( $value )
            )
        );
    }

    public function fromPersistenceValue( FieldValue $fieldValue )
    {
        if ( $fieldValue->data === null )
        {
            return $this->getEmptyValue();
        }
        return new Value( $fieldValue->data );
    }
}