<?php
if(isset($_GET['index']) && file_exists("recipes.txt")){
    $recipes = file("recipes.txt", FILE_IGNORE_NEW_LINES);
    $index = (int)$_GET['index'];
    if(isset($recipes[$index])){
        unset($recipes[$index]);
        file_put_contents("recipes.txt", implode("\n",$recipes)."\n");
    }
}
header("Location: index.php");
exit();
?>
