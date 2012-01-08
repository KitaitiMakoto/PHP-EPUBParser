<?php
namespace EPUBParser\EPUB\Publication\Package\Manifest;
use EPUBParser\EPUB\Publication\Package\Manifest;

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
        $this->_IRI = $this->_setIRI($baseDirectory);

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

    protected function _setIRI($basedir)
    {
        if ($rp = realpath($base)) {
            $this->_IRI = "{$rp}/{$this->_href}";
        } else {
            $uri = parse_url($basedir);
            if (! isset($uri['scheme'])) {
                throw new RuntimeException("Invalid IRI: $basedir");
            }
            $this->_IRI = $basedir;
        }
        return $this->_IRI;
    }
}
