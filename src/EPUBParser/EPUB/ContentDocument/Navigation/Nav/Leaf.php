<?php
namespace EPUBParser\EPUB\ContentDocument\Navigation\Nav;
use EPUBParser\EPUB\ContentDocument\Navigation\Nav;

class Leaf extends Item
{
    private $_label;
    private $_href;

    public function __construct(\DOMElement $a)
    {
        $this->_parse($a);
    }

    public function getLabel()
    {
        return $this->_label;
    }

    public function getHref()
    {
        return $this->_href;
    }

    protected function _parse(\DOMElement $a)
    {
        if ($label = $a->textContent) {
            $this->_label = $label;
        } elseif ($label = $a->getAttribute('title')) {
            $this->_label = $label;
        } else {
            $this->_label = '';
        }
        $this->_href = $a->getAttribute('href');
    }
}
