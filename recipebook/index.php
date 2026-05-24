<?php
$filterCategory = $_GET['category'] ?? '';
$search = strtolower($_GET['search'] ?? '');
$recipes = [];
if(file_exists("recipes.txt")){
    $lines = file("recipes.txt", FILE_IGNORE_NEW_LINES);
    foreach($lines as $index => $line){
        list($title,$category,$ingredients,$instructions) = explode("|",$line);
        if(($filterCategory=='' || $filterCategory==$category) && ($search=='' || strpos(strtolower($title),$search)!==false)){
            $recipes[] = ['index'=>$index,'title'=>$title,'category'=>$category,'ingredients'=>$ingredients,'instructions'=>$instructions];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>🍲 My Recipe Book</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<header>
<h1>🍲 My Recipe Book</h1>
</header>

<section class="form-section">
<h2>Add New Recipe</h2>
<form action="save.php" method="POST">
    <input type="text" name="title" placeholder="Recipe Title" required>
    <select name="category" required>
        <option value="">Select Category</option>
        <option value="Breakfast">Breakfast</option>
        <option value="Lunch">Lunch</option>
        <option value="Dinner">Dinner</option>
        <option value="Snack">Snack</option>
    </select>
    <textarea name="ingredients" placeholder="Ingredients" required></textarea>
    <textarea name="instructions" placeholder="Instructions" required></textarea>
    <button type="submit">Save Recipe</button>
</form>
</section>

<section class="recipes-section">
<h2>All Recipes</h2>

<!-- Search & Filter -->
<form method="GET" class="search-form">
    <input type="text" name="search" placeholder="Search by title..." value="<?= htmlspecialchars($search) ?>">
    <select name="category">
        <option value="">All Categories</option>
        <option value="Breakfast" <?= $filterCategory=='Breakfast'?'selected':'' ?>>Breakfast</option>
        <option value="Lunch" <?= $filterCategory=='Lunch'?'selected':'' ?>>Lunch</option>
        <option value="Dinner" <?= $filterCategory=='Dinner'?'selected':'' ?>>Dinner</option>
        <option value="Snack" <?= $filterCategory=='Snack'?'selected':'' ?>>Snack</option>
    </select>
    <button type="submit">Filter</button>
</form>

<?php
if($recipes){
    foreach($recipes as $r){
        echo "<div class='recipe-card'>
                <h3>".htmlspecialchars($r['title'])."</h3>
                <p class='category'>Category: ".htmlspecialchars($r['category'])."</p>
                <p><strong>Ingredients:</strong><br>".nl2br(htmlspecialchars($r['ingredients']))."</p>
                <p><strong>Instructions:</strong><br>".nl2br(htmlspecialchars($r['instructions']))."</p>
                <a href='edit.php?index={$r['index']}' class='edit-btn'>Edit</a>
                <a href='delete.php?index={$r['index']}' class='delete-btn'>Delete</a>
              </div>";
    }
}else{
    echo "<p>No recipes found.</p>";
}
?>
</section>

</body>
</html>
