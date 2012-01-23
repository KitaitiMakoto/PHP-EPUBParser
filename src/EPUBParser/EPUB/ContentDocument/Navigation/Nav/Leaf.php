<?php
namespace EPUBParser\EPUB\ContentDocument\Navigation\Nav;
use EPUBParser\EPUB\ContentDocument\Navigation\Nav;

class Leaf extends Item
{
    private $_href;
    private $_item;

    public function __construct(\DOMElement $a)
    {
        $this->_parse($a);
    }

    protected function _parse(\DOMElement $a)
    {
        $this->_parseLabel($a);
        $this->_parseItem($a);
    }

    protected function _parseLabel(\DOMElement $a)
    {
        if ($label = $a->textContent) {
            $this->_label = $label;
            return $this->_label;
        }
        if ($label = $a->getAttribute('title')) {
            $this->_label = $label;
            return $this->_label;
        }
        $this->_label = '';
        return $this->_label;
    }

    protected function _parseItem()
    {
        throw new \Exception('Not implemented');
    }
}
