<?php
namespace EPUBParser\EPUB\Publication\Package;
use EPUBParser\EPUB\Publication\Package;

class Spine
{
    const XPATH_ITEMREF    = '/opf:package/opf:spine/opf:itemref';

    protected $_id;
    protected $_toc;
    protected $_pageProgressionDirection;
    protected $_itemrefs;

    public function __construct(\DOMElement $elem, Package\Manifest $manifest)
    {
        $this->_itemrefs = array();
        $this->_parseSpine($elem);
        $this->_parseItemrefs($elem, $manifest);
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getToc()
    {
        return $this->_toc;
    }

    public function getPageProgressionDirection()
    {
        return $this->_pageProgressionDirection;
    }

    public function getItemref($index)
    {
        return $this->_itemrefs[$index];
    }

    public function getItemrefs()
    {
        return $this->_itemrefs;
    }

    public function getPages()
    {
        return array_map(function($itemref) {return $itemref->getItem();}, $this->_itemrefs);
    }

    protected function _parseSpine(\DOMElement $elem)
    {
        if ($id = $elem->getAttribute('id')) {
            $this->_id = $id;
        }
        if ($toc = $elem->getAttribute('toc')) {
            $this->_toc = $toc;
        }
        if ($ppd = $elem->getAttribute('page-progression-direction')) {
            $this->_pageProgressionDirection = $ppd;
        }
    }

    protected function _parseItemrefs(\DOMElement $elem, Manifest $manifest)
    {
        $xpath = new \DOMXPath($elem->ownerDocument);
        $xpath->registerNamespace(Package::NAMESPACE_PREFIX, Package::NAMESPACE_URI);
        foreach ($xpath->evaluate(self::XPATH_ITEMREF) as $itemrefElem) {
            $idref = $itemrefElem->getAttribute('idref');
            $vars = array(
                'idref' => $idref,
                'item'  => $manifest->getItem($idref)
            );
            if ($linear = $itemrefElem->getAttribute('linear')) {
                $vars['linear'] = ($linear !== 'no');
            }
            if ($id = $itemrefElem->getAttribute('id')) {
                $vars['id'] = $id;
            }
            $properties = $itemrefElem->getAttribute('properties');
            $properties = preg_replace('/ +/', ' ', $properties);
            $properties = explode(' ', $properties);
            if ($properties === array('')) {
                $properties = array();
            }
            $vars['properties'] = $properties;
            $this->_itemrefs[] = new Spine\Itemref($vars);
        }
    }
}
