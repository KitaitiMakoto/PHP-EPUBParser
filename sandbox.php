<?php
require 'src/EPUB_Parser/EPUB/OCF/Container.php';
use EPUB_Parser\EPUB;

$filename = 'tests/fixtures/book/META-INF/container.xml';
// $container = EPUB_Parser\EPUB\OCF\Container::parse($filename);
$container = EPUB\OCF\Container::parse($filename);
echo $container->getPrimaryRootfile(), PHP_EOL;

require 'src/EPUB_Parser/EPUB/Publication/Package/Manifest.php';
require 'src/EPUB_Parser/EPUB/Publication/Package/Manifest/Item.php';
$filename = 'tests/fixtures/book/OPS/ルートファイル.opf';
$doc = new \DOMDocument;
$doc->loadXML(file_get_contents($filename));
$manifestElem = $doc->getElementsByTagName('manifest')->item(0);
$manifest = new EPUB\Publication\Package\Manifest($manifestElem);
foreach ($manifest->getItems() as $item) {
    if($item->getFallback()) {
        echo $item->getFallback()->getId(), PHP_EOL;
    }
}

/* $vars = array('id' => 'this is id', 'href' => 'path/to/item'); */
/* $item = new EPUB\Publication\Package\Manifest\Item($vars); */
/* echo $item->getIRI(), PHP_EOL; */

