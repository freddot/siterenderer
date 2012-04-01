<?php

include "tinytags.php";

function echoErrorMessage($msg) {
    echo "Siterenderer error - " . $msg . "\n";
}

function getContentsOfFile($filepath) {
    if ($fh = fopen($filepath, "r")) {
        if ($fc = fread($fh, filesize($filepath))) {
            return $fc;
        }
    }
}

function insertIntoTemplate($content, $tagname, $template) {
    return str_replace("::" . $tagname . "::", $content, $template);
}

function outputToFile($contents, $path) {
    if ($fh = fopen($path, "w")) {
        fwrite($fh, $contents);
        fclose($fh);
    } else {
        echoErrorMessage("could not open file $path");
    }
}

?>
