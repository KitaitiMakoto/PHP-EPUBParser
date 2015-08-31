<?php
namespace EPUBParser\EPUB\Publication\Package;
use EPUBParser\EPUB\Publication\Package;

class Metadata
{
    const DUBLINCORE_PREFIX = 'dc';
    const DUBLINCORE_URI    = 'http://purl.org/dc/elements/1.1/';

    const XPATH_TITLE       = '/opf:package/opf:metadata/dc:title';
    const XPATH_CREATOR     = '/opf:package/opf:metadata/dc:creator';
    const XPATH_DESCRIPTION = '/opf:package/opf:metadata/dc:description';
    const XPATH_SUBJECT     = '/opf:package/opf:metadata/dc:subject';

    const XPATH_META        = '/opf:package/opf:metadata/opf:meta';

    private $_title;
    private $_creator;
    private $_description;
    private $_subjects;

    public function __construct(\DOMElement $elem)
    {
        $this->_subjects = array();
        $this->_parse($elem);
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function getCreator()
    {
        return $this->_creator;
    }

    public function getDescription()
    {
        return $this->_description;
    }

    public function getSubjects()
    {
        return $this->_subjects;
    }

    protected function _parse(\DOMElement $elem)
    {
        $xpath = new \DOMXPath($elem->ownerDocument);
        $xpath->registerNamespace(Package::NAMESPACE_PREFIX, Package::NAMESPACE_URI);
        $xpath->registerNamespace(self::DUBLINCORE_PREFIX, self::DUBLINCORE_URI);
        
        $titles = $xpath->evaluate(self::XPATH_TITLE);
        $creators = $xpath->evaluate(self::XPATH_CREATOR);
        $descriptions = $xpath->evaluate(self::XPATH_DESCRIPTION);

        if ($titles && $titles->length) {
            $this->_title = $titles->item(0)->textContent;
        }
        if ($creators && $creators->length) {
            $this->_creator = $creators->item(0)->textContent;
        }
        if ($descriptions && $descriptions->length) {
            $this->_description = $descriptions->item(0)->textContent;
        }
        foreach ($xpath->evaluate(self::XPATH_SUBJECT) as $subject) {
            $this->_subjects[] = $subject->textContent;
        }
    }
}

