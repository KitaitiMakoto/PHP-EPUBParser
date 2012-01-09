<?php
namespace EPUBParser\EPUB\Publication\Package\Guide;
use EPUBParser\EPUB\Publication\Package\Guide;

class Reference
{
    protected $_href;
    protected $_type;
    protected $_title;

    public function __construct(array $vars)
    {
        foreach (array('href', 'type', 'title') as $name) {
            if (isset($vars[$name])) {
                $this->{'_' . $name} = $vars[$name];
            }
        }
    }

    public function getHref()
    {
        return $this->_href;
    }

    public function getType()
    {
        return $this->_type;
    }

    public function getTitle()
    {
        return $this->_title;
    }
}
