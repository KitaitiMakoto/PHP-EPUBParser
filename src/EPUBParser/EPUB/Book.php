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
}
