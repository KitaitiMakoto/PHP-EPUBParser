<?php
namespace EPUBParser\EPUB\ContentDocument;
use EPUBParser\EPUB\ContentDocument;

class Navigation
{
    private $_navs;

    public function __construct(\EPUBParser\EPUB\Publication\Package\Manifest\Item $item)
    {
        $this->_navs = array();
        $this->_parse($item, $manifest);
    }

    public function getNavs()
    {
        return $this->_navs;
    }

    protected function _parse(\EPUBParser\EPUB\Publication\Package\Manifest\Item $item)
    {
        $file = $item->getIRI();
        $doc = new \DOMDocument;
        $doc->loadXML(file_get_contents($file));
        foreach ($doc->getElementsByTagName('nav') as $navElem) {
            try {
                $nav = new ContentDocument\Navigation\Nav($navElem, dirname($file));
                $this->_navs[] = $nav;
            } catch (\RuntimeException $e) {
                // trigger_error('Failed to parse nav element');
                // should be outputted to stderr
            }
        }
        return $this->_navs;
    }
}
