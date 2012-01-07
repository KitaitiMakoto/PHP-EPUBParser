<?php
namespace EPUB_Parser\EPUB\OCF;
use EPUB_Parser\EPUB;

class Container
{
    const FILEPATH         = 'META-INF/container.xml';
    const NAMESPACE_PREFIX = 'container';
    const NAMESPACE_URI    = 'urn:oasis:names:tc:opendocument:xmlns:container';
    const XPATH_ROOTFILE   = '/container:container/container:rootfiles/container:rootfile';

    protected $_doc;
    protected $_rootfiles;
    protected $_primaryRootfile;

    /**
     * @param string $file filepath
     * @return Container
     * @exception RuntimeException
     */
    public static function parse($file = self::FILEPATH)
    {
        if (! $source = file_get_contents($file)) {
            throw new \RuntimeException("Counldn't read from $file");
        }
        return new self($source);
    }

    /**
     * @param string $source
     */
    public function __construct($source)
    {
        $doc = new \DOMDocument;
        if (! $doc->loadXML($source)) {
            throw new \RuntimeException("Couldn't parse as XML document");
        }
        $doc->preserveWhiteSpace = false;
        $this->_doc = $doc;
    }

    public function getRootfiles()
    {
        if (! isset($this->_rootfiles)) {
            $xpath = new \DOMXPath($this->_doc);
            $xpath->registerNamespace(self::NAMESPACE_PREFIX, self::NAMESPACE_URI);
            if (! $this->_rootfiles = $xpath->evaluate(self::XPATH_ROOTFILE)) {
                throw new \RuntimeException("Couldn't find rootfile");
            }
        }
        return $this->_rootfiles;
    }

    public function getPrimaryRootfile()
    {
        if (! isset($this->_primaryRootfile)) {
            if (! isset($this->_rootfiles)) {
                $this->getRootfiles();
            }
            $this->_primaryRootfile = $this->_rootfiles->item(0)->getAttribute('full-path');
        }
        return $this->_primaryRootfile;
    }
}
