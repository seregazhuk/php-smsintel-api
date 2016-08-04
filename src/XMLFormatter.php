<?php

namespace seregazhuk\SmsIntel;

use DOMElement;
use DOMDocument;

class XMLFormatter
{
    /**
     * @var array
     */
    protected $params;

    /**
     * @var DOMDocument
     */
    protected $dom;

    /**
     * @var DOMElement
     */
    protected $dataNode;

    public function __construct(array $params)
    {
        $this->params = $params;
    }
    /**
     * @return string
     */
    public function toXml()
    {
        return $this
            ->initDom()
            ->createParamsNodes()
            ->getXml();
    }

    /**
     * @return string
     */
    protected function getXml()
    {
        return trim($this->dom->saveXml($this->dom, LIBXML_NOEMPTYTAG));
    }

    /**
     * @return $this
     */
    protected function initDom()
    {
        $this->dom = new \DOMDocument();
        $this->dataNode = $this->dom->createElement('data');
        $this->dom->appendChild($this->dataNode);

        return $this;
    }

    /**
     * @return $this
     */
    protected function createParamsNodes()
    {
        foreach ($this->params as $key => $value) {
            $this->createParamNode($key, $value);
        }

        return $this;
    }

    /**
     * @param array $phones
     */
    protected function appendPhonesNodes(array $phones)
    {
        foreach ($phones as $phone) {
            $phoneNode = $this->dom->createElement('to');
            $phoneNode->setAttribute('number', $phone);

            $this->dataNode->appendChild($phoneNode);
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    protected function createParamNode($key, $value)
    {
        if ($key == 'to') {
            $this->appendPhonesNodes($value);
            return;
        }

        $node = $this->dom->createElement($key, $value);
        $this->dataNode->appendChild($node);
    }
}
