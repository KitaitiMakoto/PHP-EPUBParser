<?php
namespace EPUBParser\EPUB\Publication;
use EPUBParser\EPUB\Publication;

class Package
{
    const NAMESPACE_PREFIX = 'opf';
    const NAMESPACE_URI    = 'http://www.idpf.org/2007/opf';
    const XPATH_MANIFEST   = '/opf:package/opf:manifest';
    const XPATH_SPINE      = '/opf:package/opf:spine';
    const XPATH_GUIDE      = '/opf:package/opf:guide';

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
        return new self($filename);
    }

    public function __construct($filename)
    {
        if (! $source = file_get_contents($filename)) {
            throw new \RuntimeException("Couldn't read file");
        }
        $doc = new \DOMDocument;
        if (! $doc->loadXML($source)) {
            throw new \RuntimeException("Couldn't parse as XML document");
        }
        $doc->preserveWhiteSpace = false;
        $this->_parse($doc, dirname($filename));
    }

    /**
     * @return EPUB\Publication\Metadata
     */
    public function getMetadata()
    {
        throw new Exception('Not implemented yet');
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
        return $this->_guide;
    }

    public function getBindings()
    {
        throw new Exception('Not implemented yet.');
    }

    protected function _parse(\DOMDocument $doc, $dirname)
    {
        $xpath = new \DOMXPath($doc);
        $xpath->registerNamespace(self::NAMESPACE_PREFIX, self::NAMESPACE_URI);

        // To do: Process metadata
        $elem = $xpath->evaluate(self::XPATH_MANIFEST)->item(0);
        $this->_manifest = new Publication\Package\Manifest($elem, $dirname);

        $elem = $xpath->evaluate(self::XPATH_SPINE)->item(0);
        $this->_spine = new Publication\Package\Spine($elem, $this->_manifest);

        $elem = $xpath->evaluate(self::XPATH_GUIDE)->item(0);
        if ($elem) {
            $this->_guide = new Publication\Package\Guide($elem);
        }
    }
}
