<?php

echo "<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML//EN\">\n";
echo "<html>\n";
echo "    <head>\n";
echo "        <meta name=\"GENERATOR\" content=\"yiidoc http://www.yiiwiki.com\">\n";
echo "    </head>\n";
echo "    <body>\n";
foreach ($this->categories as $name => $category) {
foreach ($category['articles'] as $article) {
echo "            <ul>\n";
echo "                <li><object type=\"text/sitemap\">\n";
echo "                        <param name=\"Name\" value=\"{$article->title}\">\n";
echo "                        <param name=\"Local\" value=\"{$article->id}.html\">\n";
echo "                    </object>\n";
if ($article->hasTocs()):
echo "                    <ul>\n";
foreach ($article->getTocs() as $toc) {
echo "                        <li><object type=\"text/sitemap\">\n";
echo "                                <param name=\"Name\" value=\"" . CHtml::encode($toc->label) . "\">\n";
echo "                                <param name=\"Local\" value=\"{$toc->getChmUrl()}\">\n";
echo "                                </object>\n";
}
echo "                    </ul>\n";
endif;
echo "            </ul>\n";
}
}
echo "    </body>\n";
echo "</html>";