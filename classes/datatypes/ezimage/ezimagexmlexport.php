<?php
/**
 * File containing the eZImageXMLExport class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @package ezxmlexport
 *
 */

/*
 * Complex type for this datatype
 *  <!-- image -->
 *  <xs:complexType name="ezimage">
 *      <xs:simpleContent>
 *          <xs:extension base="xs:string"/>
 *      </xs:simpleContent>
 *  </xs:complexType>
 */

class eZImageXMLExport extends eZXMLExportDatatype
{
    public function definition()
    {
        return '<!-- image -->
                <xs:complexType name="ezimage">
                    <xs:simpleContent>
                        <xs:extension base="xs:string"/>
                    </xs:simpleContent>
                </xs:complexType>';
    }

    protected function defaultValue()
    {
        return false;
    }

    protected function toXMLSchema()
    {
        return '<xs:complexType>
                    <xs:simpleContent>
                        <xs:extension base="ezimage"/>
                    </xs:simpleContent>
                </xs:complexType>';
    }

    protected function toXML()
    {
        $attributeContents = $this->contentObjectAttribute->content();
        $originalImage     = $attributeContents->attribute('original');

        $imageURL = $originalImage['url'];

        if( eZINI::instance( 'ezxmlexport.ini' )->variable( 'ExportSettings', 'UseRemoteFiles' ) != 'enabled' )
            return $imageURL;

        if( PHP_SAPI == 'cli' )
        {
            $ini = eZINI::instance( 'site.ini' );
            $siteURL = trim( $ini->variable( 'SiteSettings', 'SiteURL' ) );

            // removes trailing slash
            $lastPos = strlen( $siteURL ) - 1;
            if( $siteURL[ $lastPos ] == '/' )
            {
                $siteURL = substr( $siteURL, 0, -1 );
            }

            $imageURL = 'http://' . $siteURL . '/' . $imageURL;
        }
        else
        {
            // ezroot
            eZURI::transformURI( $imageURL, false, 'full' );
        }

        return $imageURL;
    }
}
?>
