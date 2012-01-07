<?php
namespace EPUB_Parser\EPUB\Publication\Package\Manifest;
use EPUB_Parser\EPUB\Publication\Package\Manifest;

class Item
{
    protected $_id;
    protected $_href;
    protected $_mediaType;
    protected $_fallback;
    protected $_IRI;

    /**
     * @param array $vars
     * @param string $baseDirectory Directory name to which the root file belongs
     */
    public function __construct(array $vars, $baseDirectory)
    {
        if (! $dir = realpath($baseDirectory)) {
            throw new \RuntimeException("Directory not exist: $baseDirectory");
        }
        foreach (array('id', 'href', 'mediaType') as $name) {
            if (isset($vars[$name])) {
                $this->{'_' . $name} = $vars[$name];
            }
        }
        if (! isset($this->_IRI)) {
            $this->_IRI = $dir . '/' . $this->_href;
        }

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

    public function _setFallback(Manifest\Item $fallback)
    {
        $this->_fallback = $fallback;
        return $this;
    }

    public function getIRI()
    {
        return $this->_IRI;
    }
}
