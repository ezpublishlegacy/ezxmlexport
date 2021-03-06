<?php
/**
 * File containing the eZObjectRelationXMLExport class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @package ezxmlexport
 *
 */

/*
 * Complex type for this datatype
 *  <!-- object relation -->
 *  <xs:complexType name="ezobjectrelation">
 *     <xs:sequence>
 *         <xs:element name="object_id" type="xs:integer"/>
 *     </xs:sequence>
 *  </xs:complexType>
 */

class eZObjectRelationXMLExport extends eZXMLExportDatatype
{
    public function definition()
    {
        return '<!-- object relation -->
                <xs:complexType name="ezobjectrelation" minOccurs="0">
                    <xs:sequence>
                        <xs:element name="object_id" type="xs:integer"/>
                    </xs:sequence>
                </xs:complexType>';
    }

    protected function defaultValue()
    {
        return false;
    }

    protected function toXMLSchema()
    {
        return '<xs:complexType>
                    <xs:complexContent>
                        <xs:extension base="ezobjectrelation"/>
                    </xs:complexContent>
                </xs:complexType>';
    }

    protected function toXML()
    {
        $relatedObject = $this->contentObjectAttribute->content();

        if( !$relatedObject )
            return '<object_id/>';

        return '<object_id>'
               . $relatedObject->attribute( 'id' )
               . '</object_id>';
    }
}
?>