<?php
namespace EPUBParser\EPUB\Publication\Package;
use EPUBParser\EPUB\Publication\Package;

class Guide
{
    const XPATH_REFERENCE = '/opf:package/opf:guide/opf:reference';

    protected $_references;
    protected $_cover;

    public function __construct(\DOMElement $elem)
    {
        $this->_references = array();
        $this->_parse($elem);
    }

    public function getReferences()
    {
        return $this->_references;
    }

    /**
     * @return Guide\Reference Reference object which has type 'cover'
     */
    public function getCover()
    {
        foreach ($this->_references as $reference) {
            if ($reference->getType() === 'cover') {
                $this->_cover = $reference;
                break;
            }
        }
        return $this->_cover;
    }

    protected function _parse($elem)
    {
        $xpath = new \DOMXpath($elem->ownerDocument);
        $xpath->registerNamespace(Package::NAMESPACE_PREFIX, Package::NAMESPACE_URI);
        foreach ($xpath->evaluate(self::XPATH_REFERENCE) as $refElem) {
            $this->_references[] = new Guide\Reference(array(
                'href'  => $refElem->getAttribute('href'),
                'type'  => $refElem->getAttribute('type'),
                'title' => $refElem->getAttribute('title')
            ));
        }
    }
}
