<?php
namespace EPUBParser\EPUB\ContentDocument\Navigation\Nav;
use EPUBParser\EPUB\ContentDocument\Navigation\Nav;

class ItemList extends Item
{
    private $_items;

    public function __construct(\DOMElement $li)
    {
        $this->_parse($li);
    }

    public function getItems()
    {
        return $this->_items;
    }

    protected function _parse(\DOMElement $li)
    {
        foreach ($li->childNodes as $ch) {
            if ($ch->tagName === 'span') {
                $this->_parseLabel($ch);
                continue;
            }
            if ($ch->tagName === 'ol') {
                $this->_parseList($ch);
                continue;
            }
        }
    }

    protected function _parseLabel(\DOMElement $span)
    {
        $this->_label = $span->textContent;
        return $this->_label;
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
