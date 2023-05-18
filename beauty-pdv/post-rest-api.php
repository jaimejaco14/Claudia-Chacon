<?php 
function get_posts() {
    $posts = [
    "foo" => "bar",
    "bar" => "foo",
];
    header('Content-Type: application/json');
    echo json_encode($posts);
}
get_posts();





?>
