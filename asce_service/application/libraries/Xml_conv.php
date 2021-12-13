<?php
class CI_Xml_Handle{
    var $xml='9780784412916.ch01.xml';
    function CI_Xml_Handle($xml_content)
    {
        $this->xml=$xml_content;
    }
    function XMLtoObject () {
        try {
            $xml_object = new SimpleXMLElement($this->xml);
            if ($xml_object == false) {
                return false;
            }
        }
        catch (Exception $e) {
            return false;
        }
        return $xml_object;
    }
} 