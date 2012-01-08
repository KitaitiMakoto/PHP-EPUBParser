<?php
namespace EPUBParser\EPUB\Publication;
use EPUBParser\EPUB;

class Package
{
    protected $_doc;

    /**
     * @param string $filename
     * @return Publication\Package
     */
    public static function parse($filename)
    {
        if (! $source = file_get_contents($filename)) {
            throw new \RuntimeException("Couldn't read file");
        }
        return new self($source);
    }

    public function __construct($source)
    {
        $doc = new \DOMDocument;
        if (! $doc->loadXML($source)) {
            throw new \RuntimeException("Couldn't parse as XML document");
        }
        $doc->preserveWhiteSpace = false;
        $this->_doc = $doc;
    }

    /**
     * @return EPUB\Publication\Metadata
     */
    public function getMetadata()
    {
    }

    /**
     * @return EPUB\Publication\Manifest
     */
    public function getManifest()
    {
        
    }

    /**
     * @return EPUB\Publication\Spine
     */
    public function getSpine()
    {
    }

    public function getGuide()
    {
    }

    public function getBindings()
    {
    }
}
