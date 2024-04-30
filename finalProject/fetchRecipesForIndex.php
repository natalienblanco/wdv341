<?php
require_once('admin/recipeManager/dbConnect.php');
require_once('admin/recipeManager/Recipe.php');

try {
    // Attempt to execute the SQL query
    $sql = "SELECT * FROM wdv341_recipes";
    $recipeStmt = $conn->prepare($sql);
    $recipeStmt->execute();

    // Fetch recipes and store in array
    $recipes = [];
    while ($row = $recipeStmt->fetch(PDO::FETCH_ASSOC)) {
        // Create Recipe object
        $recipe = new Recipe(
            $row['id'],
            $row['recipeName'],
            $row['recipeImage'],
            $row['servings'],
            $row['prepTime'],
            $row['cookTime'],
            $row['difficulty'],
            $row['ingredients'],
            $row['instructions'],
            $row['sourceLink']
        );
        $recipes[] = $recipe;
    }

    // Close DB connection
    $conn = null;

    // Return recipes as JSON
    header('Content-Type: application/json');
    echo json_encode($recipes);
} catch (PDOException $e) {
    // Log the error
    error_log("Database error: " . $e->getMessage());
    // Return an error response
    http_response_code(500); // Internal Server Error
    echo json_encode(array("error" => "Internal Server Error"));
}
