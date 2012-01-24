<?php
/* require 'src/EPUBParser/EPUB/Book.php'; */

/* require 'src/EPUBParser/EPUB/OCF/Container.php'; */

/* require 'src/EPUBParser/EPUB/Publication/Package.php'; */
/* require 'src/EPUBParser/EPUB/Publication/Package/Manifest.php'; */
/* require 'src/EPUBParser/EPUB/Publication/Package/Manifest/Item.php'; */
/* require 'src/EPUBParser/EPUB/Publication/Package/Spine.php'; */
/* require 'src/EPUBParser/EPUB/Publication/Package/Spine/Itemref.php'; */
/* require 'src/EPUBParser/EPUB/Publication/Package/Guide.php'; */
/* require 'src/EPUBParser/EPUB/Publication/Package/Guide/Reference.php'; */

require 'src/EPUBParser/EPUB/ContentDocument.php';
require 'src/EPUBParser/EPUB/ContentDocument/Navigation.php';
require 'src/EPUBParser/EPUB/ContentDocument/Navigation/Nav.php';
require 'src/EPUBParser/EPUB/ContentDocument/Navigation/Nav/Item.php';
require 'src/EPUBParser/EPUB/ContentDocument/Navigation/Nav/Leaf.php';
require 'src/EPUBParser/EPUB/ContentDocument/Navigation/Nav/ItemList.php';

use EPUBParser\EPUB;

/* $book = new EPUB\Book('tests/fixtures/book'); */
/* foreach ($book->getPackage()->getManifest()->getItems() as $item) { */
/*     echo $item->getId(), ': ', $item->getHref(), PHP_EOL; */
/*     print_r($item->getProperties()); */
/* } */
/* foreach ($book->getPackage()->getSpine()->getItemrefs() as $itemref) { */
/*     print_r($itemref->getProperties()); */
/* } */

/* $items = $book->getPackage()->getManifest()->getItems(); */
/* $itemrefs = $book->getPackage()->getSpine()->getItemrefs(); */
/* $pages = array_map(function($itemref) {return $itemref->getItem();}, $itemrefs); */
/* var_dump($items); */
/* var_dump($pages); */
/* $rest = array_udiff($items, $pages, function($item1, $item2) { */
/*         $id1 = $item1->getId(); */
/*         $id2 = $item2->getId(); */
/*         return $id1 === $id2 ? 0 */
/*                              : $id1 > $id2 ? 1 : -1; */
/*     }); */
/* var_dump($rest); */
/* var_dump($book->getPackage()->getManifest()->getCoverImage()); */
/* var_dump($book->getPackage()->getGuide()->getCover()); */

$navfile = 'tests/fixtures/book/OPS/nav.xhtml';
$doc = new \DOMDocument;
$doc->loadXML(file_get_contents($navfile));
$navelem = $doc->getElementsByTagName('nav')->item(0);
$nav = new EPUB\ContentDocument\Navigation\Nav($navelem, dirname($navfile));
var_dump($nav);