<?php
namespace EPUBParser\EPUB\Publication\Package;
use EPUBParser\EPUB\Publication\Package;

class Manifest
{
    const XPATH_ITEM       = '/opf:package/opf:manifest/opf:item';

    protected $_id;
    protected $_items;
    protected $_coverImage;

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

    public function getCoverImage()
    {
        if (! isset($this->_coverImage)) {
            foreach ($this->_items as $item) {
                if (in_array('cover-image', $item->getProperties())) {
                    $this->_coverImage = $item;
                    break;
                }
            }
        }
        return $this->_coverImage;
    }

    protected function _parse(\DOMElement $elem)
    {
        $xpath = new \DOMXpath($elem->ownerDocument);
        $xpath->registerNamespace(Package::NAMESPACE_PREFIX, Package::NAMESPACE_URI);
        $itemList = $xpath->evaluate(self::XPATH_ITEM);
        $fallbackMap = array();
        foreach ($itemList as $itemElem) {
            $id = $itemElem->getAttribute('id');
            $fallback = $itemElem->getAttribute('fallback');
            $properties = $itemElem->getAttribute('properties');
            $properties = preg_replace('/ +/', ' ', $properties);
            $properties = explode(' ', $properties);
            if ($properties === array('')) {
                $properties = array();
            }
            $item = new Manifest\Item(array(
                'id'           => $id,
                'href'         => $itemElem->getAttribute('href'),
                'mediaType'    => $itemElem->getAttribute('media-type'),
                'properties'   => $properties,
                'mediaOverlay' => $itemElem->getAttribute('media-overlay')
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
