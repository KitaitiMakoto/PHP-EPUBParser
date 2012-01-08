<?php
namespace EPUBParser\EPUB\Publication;
use EPUBParser\EPUB\Publication;

class Package
{
    const NAMESPACE_PREFIX = 'opf';
    const NAMESPACE_URI    = 'http://www.idpf.org/2007/opf';
    const XPATH_MANIFEST    = '/opf:package/opf:manifest';
    const XPATH_SPINE      = '/opf:package/opf:spine';

    protected $_metadata;
    protected $_manifest;
    protected $_spine;
    protected $_guide;
    protected $_bindings;

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
        $this->_parse($doc);
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
        return $this->_manifest;
    }

    /**
     * @return EPUB\Publication\Spine
     */
    public function getSpine()
    {
        return $this->_spine;
    }

    public function getGuide()
    {
    }

    public function getBindings()
    {
    }

    protected function _parse(\DOMDocument $doc)
    {
        $xpath = new \DOMXPath($doc);
        $xpath->registerNamespace(self::NAMESPACE_PREFIX, self::NAMESPACE_URI);

        // Process metadata
        $elem = $xpath->evaluate(self::XPATH_MANIFEST)->item(0);
        $this->_manifest = new Publication\Package\Manifest($elem);

        $elem = $xpath->evaluate(self::XPATH_SPINE)->item(0);
        $this->_spine = new Publication\Package\Spine($elem, $this->_manifest);
    }
}
