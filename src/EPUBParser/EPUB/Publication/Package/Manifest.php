<?php
namespace EPUB_Parser\EPUB\Publication\Package;
use EPUB_Parser\EPUB\Publication\Package;

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

    protected function _parse(\DOMElement $elem)
    {
        $xpath = new \DOMXpath($elem->ownerDocument);
        $xpath->registerNamespace(self::NAMESPACE_PREFIX, self::NAMESPACE_URI);
        $itemList = $xpath->evaluate(self::XPATH_ITEM);
        var_dump($itemList->item(0));
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
