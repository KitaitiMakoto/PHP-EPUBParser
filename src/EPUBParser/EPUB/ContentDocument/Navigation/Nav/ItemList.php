<?php
namespace EPUBParser\EPUB\ContentDocument\Navigation\Nav;
use EPUBParser\EPUB\ContentDocument\Navigation\Nav;

class ItemList extends Item
{
    private $_items;

    public function __construct(\DOMElement $li)
    {
        $this->_parse($span);
    }

    protected function _parse(\DOMElement $li)
    {
        $this->_parseLabel($li->firstChild);

        $ol = $li->firstChild->firstChild;
        if ($ol->tagName !== 'ol') {
            throw new \RuntimeException('ol element not found');
        }
        $this->_parseList($ol);
    }

    protected function _parseLabel(\DOMElement $span)
    {
        
    }

    protected function _parseList(\DOMElement $ol)
    {
        foreach ($ol->childNodes as $li) {
            if ($li->tagName !== 'li') {
                continue;
            }
            $item = $li->firstChild;
            switch ($item->tagName) {
            case 'a':
                $this->_items[] = new Leaf($item);
                break;
            case 'span':
                $this->_items[] = new ItemList($li);
                break;
            }
        }
    }
}
