<?php
require_once 'dbConnect.php';
require_once 'Recipe.php';

$sql = "SELECT * FROM wdv341_recipes";
$recipeStmt = $conn->prepare($sql);
$recipeStmt->execute();
$recipes = [];

while ($row = $recipeStmt->fetch(PDO::FETCH_ASSOC)) {
    // Create a Recipe object for each row
    $recipe = new Recipe($row['id'], $row['recipeName'], $row['recipeImage'], $row['servings'], $row['prepTime'], $row['cookTime'], $row['difficulty'], $row['ingredients'], $row['instructions'], $row['sourceLink']);
    $recipes[] = $recipe; // Place into associative array
}


$conn = null; // Close database connection
