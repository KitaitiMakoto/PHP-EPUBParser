<?php
namespace EPUBParser\EPUB\Publication\Package\Spine;
use EPUBParser\EPUB\Publication\Package\Spine;

class Itemref
{
    public function __construct(array $vars)
    {
        foreach (array('idref', 'linear', 'id', 'properties', 'item') as $name) {
            if (isset($name)) {
                $this->{'_' . $name} = $vars[$name];
            }
        }
    }

    public function getIdref()
    {
        return $this->_idref;
    }

    public function getLinear()
    {
        return $this->_linear;
    }

    public function isLinear()
    {
        return $this->getLinear();
    }

    public function geId()
    {
        return $this->_id;
    }

    public function getProperties()
    {
        return $this->_properties;
    }

    public function getItem()
    {
        return $this->_item;
    }
}
