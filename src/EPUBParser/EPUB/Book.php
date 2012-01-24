<?php
namespace EPUBParser\EPUB;
use EPUBParser\EPUB;

class Book
{
    protected $_container;
    protected $_package;

    public function __construct($directory)
    {
        if (! $directory = realpath($directory)) {
            throw new \Exception("Directory not exist: $directory");
        }

        $container = $directory . '/' . EPUB\OCF\Container::FILEPATH;
        $this->_container = EPUB\OCF\Container::parse($container);

        $package = $directory . '/' . $this->_container->getPrimaryRootfile();
        $this->_package = EPUB\Publication\Package::parse($package);
    }

    public function getContainer()
    {
        return $this->_container;
    }

    public function getPackage()
    {
        return $this->_package;
    }

    /**
     * @param void|string|array
     */
    public function getResources($mediaTypes = null)
    {
        return $this->_package->getManifest()->getItems($mediaTypes);
    }

    public function getPagesOnSpine()
    {
        return $this->_package->getSpine()->getPages();
    }

    public function getCoverImage()
    {
        return $this->_package->getManifest()->getCoverImage();
    }

    public function getNavs()
    {
        return $this->_package->getManifest()->getNavs();
    }
}
