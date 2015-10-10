<?php
//include the html parser
require 'library/simple_html_dom.php';

$html = file_get_html('http://www.nhl.com/ice/standings.htm?type=lea');

$standings = $html->find('table[class=standings]');

echo $html;