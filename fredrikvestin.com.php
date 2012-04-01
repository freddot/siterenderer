<?php

/*
    TODO
        - newlines in html output within tags
*/

include "siterenderer.php";
include "post_functions.php";


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

// insert posts
$html = insertIntoTemplate($html, "contents", "templates/projects.html");

// insert topmenu
// $html = insertIntoTemplate($html, "topmenu", "templates/topmenu");

// write to file
outputToFile($html, "output/index.html");

?>
