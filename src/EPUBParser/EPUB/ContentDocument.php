<?php
namespace EPUBParser\EPUB;
use EPUBParser\EPUB;

class ContentDocument
{
    const XHTML_NAMESPACE_PREFIX = 'xhtml';
    const XHTML_NAMESPACE_URI    = 'http://www.w3.org/1999/xhtml';
    const EPUB_NAMESPACE_PREFIX  = 'epub';
    const EPUB_NAMESPACE_URI     = 'http://www.idpf.org/2007/ops';

    private $_book;
    private $_navs;

    public function __construct(EPUB\Book $book)
    {
        $this->_book = $book;
        $this->_navs = array();
        $this->_parse();
    }

    public function getBook()
    {
        return $this->_book;
    }

    public function getNav($type)
    {
        if (! $type) {
            throw new \InvalidArgumentException('$type is required');
        }
        foreach ($this->_book->getNavs() as $navInfo) {
            if (in_array($type, $navInfo->getProperties())) {

                throw new \Exception('Not implemented');

                return $this->_navs[$type];
            }
        }
    }

    protected function _parse()
    {
    }
}
