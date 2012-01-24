<?php
/**
 * EPUBParser\Main
 *
 * PHP version 5
 *
 * @category  Yourcategory
 * @package   EPUBParser
 * @author    Your Name <handle@php.net>
 * @copyright 2012 Your Name
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version   SVN: $Id$
 * @link      http://svn.php.net/repository/pear2/PEAR2_EPUBParser
 */

/**
 * Main class for PEAR2_EPUBParser
 *
 * @category  Yourcategory
 * @package   EPUBParser
 * @author    Your Name <handle@php.net>
 * @copyright 2012 Your Name
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link      http://svn.php.net/repository/pear2/PEAR2_EPUBParser
 */
namespace EPUBParser;
class Main
{
}

require_once __DIR__ . '/EPUB/Book.php';
require_once __DIR__ . '/EPUB/OCF/Container.php';
require_once __DIR__ . '/EPUB/Publication/Package.php';
require_once __DIR__ . '/EPUB/Publication/Package/Metadata.php';
require_once __DIR__ . '/EPUB/Publication/Package/Manifest.php';
require_once __DIR__ . '/EPUB/Publication/Package/Manifest/Item.php';
require_once __DIR__ . '/EPUB/Publication/Package/Spine.php';
require_once __DIR__ . '/EPUB/Publication/Package/Spine/Itemref.php';
require_once __DIR__ . '/EPUB/Publication/Package/Guide.php';
require_once __DIR__ . '/EPUB/Publication/Package/Guide/Reference.php';
