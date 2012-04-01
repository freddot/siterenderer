<?php

/*
    TODO
        - newlines in html output within tags
*/

// include "tinytags.php";
include "post_functions.php";

$outputpath = "output/index.html";
$templatepath = "templates/projects.html";
$topmenupath = "templates/topmenu";


function formatTime($t) {
    return date("Y m d", (int) $t);
}

function renderProjectPost($project, $cssclass) {
    return "<div class=\"project_post\">" .
            "<div class=\"" . $cssclass . "title\">" . str_replace("\n", "", $project["title"]) . 
                "<div class=\"" . $cssclass . "time\">" . formatTime(str_replace("\n", "", $project["time"])) . "</div>" .
            "</div>" .
            "<div class=\"" . $cssclass . "body\">" . str_replace("\n", "<br/>", $project["body"]) . "</div>" .
        "</div>";
}

// create html for all posts
$projects = getProjectPosts();
$html = "";
foreach($projects as $project) {
    $html .= renderProjectPost($project, "project_");
}

// insert into template
if ($fh = fopen($templatepath, "r")) {
    if ($fc = fread($fh, filesize($templatepath))) {
        $html = str_replace("%contents%", $html, $fc);
    }
}

/*
// insert topmenu
if ($fh = fopen($topmenupath, "r")) {
    if ($fc = fread($fh, filesize($topmenupath))) {
        $html = str_replace("%topmenu%", $fc, $html);
    }
}
*/

// write to file
if ($fh = fopen($outputpath, "w")) {
    fwrite($fh, $html);
    fclose($fh);
} else {
    echo "could not open file $outputpath.\n";
}

?>
