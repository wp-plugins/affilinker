<?php
							@$d->loadHTML('<?xml encoding="UTF-8">'.$content);

							foreach ($d->childNodes as $item)
							if ($item->nodeType == XML_PI_NODE)
							$d->removeChild($item);
							$d->encoding = 'UTF-8';

							$x = new DOMXpath($d);

							$aff_query_result =	$x->query("//text()[
							   contains(.,'".$key."')
							   and not(ancestor::h1) 
							   and not(ancestor::h2) 
							   and not(ancestor::h3) 
							   and not(ancestor::h4) 
							   and not(ancestor::h5) 
							   and not(ancestor::h6)
							   and not(ancestor::a)
							   and not(ancestor::img)]");
?>
