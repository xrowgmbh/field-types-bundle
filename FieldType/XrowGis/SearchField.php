<?php
/**
 * File containing the XrowGis SearchField class
 */

namespace xrow\FieldTypesBundle\FieldType\XrowGis;

use eZ\Publish\SPI\Persistence\Content\Field;
use eZ\Publish\SPI\FieldType\Indexable;
use eZ\Publish\SPI\Search;

/**
 * Indexable definition for XrowGis field type
 */
class SearchField implements Indexable
{
    /**
     * Get index data for field for search backend
     *
     * @param \eZ\Publish\SPI\Persistence\Content\Field $field
     *
     * @return \eZ\Publish\SPI\Search\Field[]
     */
    public function getIndexData( Field $field )
    {
        return array(
            new Search\Field(
                'value_address',
                array(
                   "street" => $field->value->externalData["street"],
                   "zip" => $field->value->externalData["zip"],
                   "district" => $field->value->externalData["district"],
                   "city" => $field->value->externalData["city"],
                   "state" => $field->value->externalData["state"],
                   "country" => $field->value->externalData["country"]
                ),
                new Search\FieldType\StringField()
            ),
            new Search\Field(
                'value_location',
                array(
                    "latitude" => $field->value->externalData["latitude"],
                    "longitude" => $field->value->externalData["longitude"]
                ),
                new Search\FieldType\GeoLocationField()
            ),
        );
    }

    /**
     * Get index field types for search backend
     *
     * @return \eZ\Publish\SPI\Search\FieldType[]
     */
    public function getIndexDefinition()
    {
        return array(
            'value_address' => new Search\FieldType\StringField(),
            'value_location' => new Search\FieldType\GeoLocationField()
        );
    }

    /**
     * Get name of the default field to be used for query and sort.
     *
     * As field types can index multiple fields (see MapLocation field type's
     * implementation of this interface), this method is used to define default
     * field for query and sort. Default field is typically used by Field
     * criterion and sort clause.
     *
     * @return string
     */
    public function getDefaultField()
    {
        return "value_address";
    }
}
