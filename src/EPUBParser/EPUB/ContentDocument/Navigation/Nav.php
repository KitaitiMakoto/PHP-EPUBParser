<?php
namespace EPUBParser\EPUB\ContentDocument\Navigation;
use EPUBParser\EPUB\ContentDocument\Navigation;

class Nav
{
    private $_basedir; // used to resolve relative IRI
    private $_heading;
    private $_type;
    private $_items;

    public function __construct(\DOMElement $nav, $basedir)
    {
        $this->_basedir = $basedir;
        $this->_parse($nav);
    }

    protected function _parse(\DOMElement $nav)
    {
        $xpath = new \DOMXPath($nav->ownerDocument);
        $xpath->registerNamespace(\EPUBParser\EPUB\ContentDocument::XHTML_NAMESPACE_PREFIX, \EPUBParser\EPUB\ContentDocument::XHTML_NAMESPACE_URI);
        $xpath->registerNamespace(\EPUBParser\EPUB\ContentDocument::EPUB_NAMESPACE_PREFIX, \EPUBParser\EPUB\ContentDocument::EPUB_NAMESPACE_URI);
        $this->_parseHeading($nav, $xpath);
        $this->_parseType($nav);
        $ol = $xpath->evaluate('xhtml:ol', $nav)->item(0);
        $this->_parseList($ol);
    }

    protected function _parseHeading(\DOMElement $nav, \DOMXPath $xpath)
    {
        $headings = $xpath->evaluate('xhtml:h1|xhtml:h2|xhtml:h3|xhtml:h4|xhtml:h5|xhtml:h6', $nav);
        if ($headings->length === 0) {
            $this->_heading = '';
        } else {
            $this->_heading = $headings->item(0)->textContent;
        }
        return $this->_heading;
    }

    protected function _parseType(\DOMElement $nav)
    {
        $this->_type = $nav->getAttributeNS(\EPUBParser\EPUB\ContentDocument::EPUB_NAMESPACE_URI, 'type');
        return $this->_type;
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
                $this->_items[] = new Nav\Leaf($item);
                break;
            case 'span':
                $this->_items[] = new Nav\ItemList($li);
                break;
            }
        }
    }
}
