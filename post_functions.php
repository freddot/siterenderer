<?php

function str_to_blog_post_url($s) {
	$s = strtolower($s);
	return str_replace(" ", "_", $s);
}

// get files' contents' from dir
function getPosts($dir) {
	$result = array();
	if ($basedirhandle = opendir($dir)) {
		while (($filename = readdir($basedirhandle)) !== false) {
			$filepath = $dir . $filename;
			if (filetype($filepath) === "file") {
				$filehandle = fopen($filepath, "r");
				$post = fread($filehandle, filesize($filepath));
				$post .= "\n" . tinyTagStr("filename", $filename);
				if (!containsTinyTag($post, "time_modified")) {
					$post .= "\n" . tinyTagStr("time_modified", filemtime($filepath));
				}
				fclose($filehandle);
				$result[] = $post;
			}
		}
		closedir($basedirhandle);
		return $result;
	}
	return false;
}

// returns all project posts, sorted with time
function getProjectPosts() {
	$posts = getPosts("resources/projectposts/");
	
	// parse all posts
	foreach($posts as $k => $v) {
		$posts[$k] = parseTinyTags($v);
	}
	print_r($posts);
	
	// sort them
	$sorted = array();
	foreach($posts as $p) {
		if (count($sorted) === 0) {
			$sorted[] = $p;
		} else {
			$spliced = false;
			foreach($sorted as $key => $value) {
				if ($p["time"] > $value["time"]) {
					array_splice($sorted, $key, 0, array($p));
					$spliced = true;
					break;
				}
			}
			if (!$spliced) {
				$sorted[] = $p;
			}
		}
	}

	return $sorted;
}

// returns all posts in dir subject
function getBlogPosts($subject) {
	$posts = getPosts("resources/blogposts/" . $subject . "/");

	// parse all posts
	foreach($posts as $k => $v) {
		$posts[$k] = parseTinyTags($v);
	}
	
	return $posts;
}

?>
