<?php

namespace seregazhuk\SmsIntel;

use DOMDocument;
use DOMElement;

class XMLFormatter
{

    public static function convertParamsToXml(array $params)
    {
        $dom = new \DOMDocument();
        $dataNode = $dom->createElement('data');
        $dom->appendChild($dataNode);

        foreach ($params as $key => $value) {
            if ($key == 'to') {
                self::appendPhonesNodes($dom, $dataNode, $value);
            } else {
                $node = $dom->createElement($key, $value);
                $dataNode->appendChild($node);
            }

        }

        return trim($dom->saveXml($dom, LIBXML_NOEMPTYTAG));
    }

    /**
     * @param DOMDocument $dom
     * @param DOMElement $dataNode
     * @param array $phones
     */
    protected static function appendPhonesNodes(DOMDocument $dom, DOMElement $dataNode, array $phones)
    {
        foreach ($phones as $phone) {
            $phoneNode = $dom->createElement('to');
            $phoneNode->setAttribute('number', $phone);

            $dataNode->appendChild($phoneNode);
        }
    }
}