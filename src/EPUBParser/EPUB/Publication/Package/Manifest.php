<?php
namespace EPUBParser\EPUB\Publication\Package;
use EPUBParser\EPUB\Publication\Package;

class Manifest
{
    const NAMESPACE_PREFIX = 'opf';
    const NAMESPACE_URI    = 'http://www.idpf.org/2007/opf';
    const XPATH_ITEM       = '/opf:package/opf:manifest/opf:item';

    protected $_id;
    protected $_items;

    public function __construct(\DOMElement $elem)
    {
        $this->_items = array();
        $this->_parse($elem);
    }

    public function getItems()
    {
        return $this->_items;
    }

    public function getItem($id)
    {
        return $this->_items[$id];
    }

    protected function _parse(\DOMElement $elem)
    {
        $xpath = new \DOMXpath($elem->ownerDocument);
        $xpath->registerNamespace(self::NAMESPACE_PREFIX, self::NAMESPACE_URI);
        $itemList = $xpath->evaluate(self::XPATH_ITEM);
        $fallbackMap = array();
        foreach ($itemList as $itemElem) {
            $id = $itemElem->getAttribute('id');
            $fallback = $itemElem->getAttribute('fallback');
            $item = new Manifest\Item(array(
                'id'        => $id,
                'href'      => $itemElem->getAttribute('href'),
                'meidaType' => $itemElem->getAttribute('media-type')
            ));
            if ($fallback !== '') {
                $fallbackMap[$id] = $fallback;
            }
            $this->_items[$id] = $item;
        }
        foreach ($fallbackMap as $fromId => $fallbackId) {
            $this->_items[$fromId]->_setFallback($this->_items[$fallbackId]);
        }
    }
}
