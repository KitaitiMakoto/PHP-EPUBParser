<?php
namespace EPUBParser\EPUB\Publication\Package\Manifest;
use EPUBParser\EPUB\Publication\Package\Manifest;

class Item
{
    protected $_id;
    protected $_href;
    protected $_mediaType;
    protected $_fallback;
    protected $_properties;
    protected $_mediaOverlay;
    protected $_IRI;
    protected $_IRIIsRelative;

    /**
     * @param array $vars
     * @param string $baseDirectory Directory name to which the root file belongs
     */
    public function __construct(array $vars, $baseDirectory)
    {
        if (! $dir = realpath($baseDirectory)) {
            throw new \RuntimeException("Directory not exist: $baseDirectory");
        }
        foreach (array('id', 'href', 'mediaType', 'properties', 'mediaOverlay') as $name) {
            if (isset($vars[$name])) {
                $this->{'_' . $name} = $vars[$name];
            }
        }
        $this->_IRI = $this->_setIRI($dir);

    }

    public function getId()
    {
        return $this->_id;
    }

    public function getHref()
    {
        return $this->_href;
    }

    public function getMediaType()
    {
        return $this->_mediaType;
    }

    /**
     * @return Manifest\Item
     */
    public function getFallback()
    {
        return $this->_fallback;
    }

    public function getProperties()
    {
        return $this->_properties;
    }

    public function getMediaOvelay()
    {
        return $this->_mediaOverlay;
    }

    public function _setFallback(Manifest\Item $fallback)
    {
        $this->_fallback = $fallback;
        return $this;
    }

    public function getIRI()
    {
        return $this->_IRI;
    }

    public function IRIIsRelative()
    {
        return $this->_IRIIsRelative;
    }

    /**
     * To do: Check recursive fallback chain
     * To do: Accept SplDoublyLinkedList and check not using in_array
     *
     * @param string|array $mediaTypes Media type like 'application/xhtml+xml' or array('image/png', 'image/jpeg')
     */
    public function followFallbackUntil($mediaTypes)
    {
        if (! is_array($mediaTypes)) {
            $mediaTypes = array($mediaTypes);
        }
        if (in_array($this->_mediaType, $mediaTypes)) {
            return $this;
        }
        if (is_null($this->_fallback)) {
            return null;
        }
        return $this->_fallback->followFallbackUntil($mediaTypes);
    }

    protected function _setIRI($basedir)
    {
        if ($rp = realpath($basedir)) {
            $realpath = realpath("{$rp}/{$this->_href}");
            if (strpos($realpath, $rp) !== 0) {
                throw new RuntimeException("Invalid href: {$tihs->_href}");
            }
            $this->_IRI = $realpath;
            $this->_IRIIsRelative = true;
        } else {
            $uri = parse_url($basedir);
            if (! isset($uri['scheme'])) {
                throw new RuntimeException("Invalid IRI: $basedir");
            }
            $this->_IRIIsRelative = false;
            $this->_IRI = $basedir;
        }
        return $this->_IRI;
    }
}
