<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
    $title = str_replace("|","-", $_POST['title']);
    $category = $_POST['category'];
    $ingredients = str_replace("|","-", $_POST['ingredients']);
    $instructions = str_replace("|","-", $_POST['instructions']);

    $data = "$title|$category|$ingredients|$instructions\n";

    file_put_contents("recipes.txt", $data, FILE_APPEND);
    header("Location: index.php");
    exit();
}
?>
