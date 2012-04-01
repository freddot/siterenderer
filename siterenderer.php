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


// blog-like-posts functions
function getPosts($dir) {
	$result = array();
	if ($basedirhandle = opendir($dir)) {
		while (($filename = readdir($basedirhandle)) !== false) {
			$filepath = $dir . $filename;
			if (filetype($filepath) === "file") {
				$filehandle = fopen($filepath, "r");
				$post = fread($filehandle, filesize($filepath));
				$post .= "\n" . tinyTagStr("filename", $filename);
        		$post .= "\n" . tinyTagStr("time_modified", filemtime($filepath));
				fclose($filehandle);
				$result[] = $post;
			}
		}
		closedir($basedirhandle);
		return $result;
	}
	return false;
}


?>
