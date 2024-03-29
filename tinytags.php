<?php

function tinyTagStr($tagname, $str) {
    return "::" . $tagname . "::\n" . $str . "\n";
}

function containsTinyTag($tagname, $str) {
    return !!strpos($str, $tagname);
}

function parseTinyTags($str) {
	$result = array();
	$matches = preg_split("#(::[a-z_-]+::\n)#", $str, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
	$len = count($matches);
	for($i = 0; $i < $len; $i += 2) {
		$result[trim(str_replace("::", "", $matches[$i]))] = trim($matches[$i + 1]);
	}
	return $result;
}

function emitTinyTags($arr) {
    $result = "";
    foreach($arr as $key => $value) {
        $result .= tinyTagStr($key, $value);
    }
    return $result;
}


?>
