<?php
if(!file_exists("recipes.txt")) exit("No recipes found.");

$recipes = file("recipes.txt", FILE_IGNORE_NEW_LINES);
$index = $_GET['index'] ?? '';
if(!isset($recipes[$index])) exit("Invalid recipe.");

if($_SERVER['REQUEST_METHOD']=='POST'){
    $title = str_replace("|","-", $_POST['title']);
    $category = $_POST['category'];
    $ingredients = str_replace("|","-", $_POST['ingredients']);
    $instructions = str_replace("|","-", $_POST['instructions']);
    $recipes[$index] = "$title|$category|$ingredients|$instructions";
    file_put_contents("recipes.txt", implode("\n",$recipes)."\n");
    header("Location: index.php");
    exit();
}

list($title,$category,$ingredients,$instructions) = explode("|",$recipes[$index]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Recipe</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<header>
<h1>Edit Recipe</h1>
</header>
<section class="form-section">
<form method="POST">
<input type="text" name="title" value="<?= htmlspecialchars($title) ?>" required>
<select name="category" required>
    <option value="Breakfast" <?= $category=='Breakfast'?'selected':'' ?>>Breakfast</option>
    <option value="Lunch" <?= $category=='Lunch'?'selected':'' ?>>Lunch</option>
    <option value="Dinner" <?= $category=='Dinner'?'selected':'' ?>>Dinner</option>
    <option value="Snack" <?= $category=='Snack'?'selected':'' ?>>Snack</option>
</select>
<textarea name="ingredients" required><?= htmlspecialchars($ingredients) ?></textarea>
<textarea name="instructions" required><?= htmlspecialchars($instructions) ?></textarea>
<button type="submit">Update Recipe</button>
</form>
<a href="index.php">Back</a>
</section>
</body>
</html>
