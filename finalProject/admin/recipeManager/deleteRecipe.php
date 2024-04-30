<?php
if (isset($_GET['id'])) {
    $recipeId = $_GET['id'];
    try {
        require_once 'dbConnect.php';

        // Prepare and execute the delete statement
        $stmt = $conn->prepare("DELETE FROM wdv341_recipes WHERE id = :recipeId");
        $stmt->bindParam(':recipeId', $recipeId);

        // Check if the user has confirmed the deletion
        if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
            if ($stmt->execute()) {
                // Recipe deleted successfully, display success message
                echo '<script>';
                echo 'alert("Recipe deleted successfully.");';
                echo 'window.location.href = "manageRecipes.php";';
                echo '</script>';
                exit();
            } else {
                // Handle deletion failure
                echo "Error deleting recipe.";
            }
        } else {
            // Display confirmation dialog before redirecting
            echo '<script>';
            echo 'if(confirm("Are you sure you want to delete this recipe?")) {';
            // If user confirms, redirect with confirmation flag
            echo '  window.location.href = "deleteRecipe.php?id=' . $recipeId . '&confirm=true";';
            echo '} else {';
            // If user cancels, redirect to manageRecipes.php
            echo '  window.location.href = "manageRecipes.php";';
            echo '}';
            echo '</script>';
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
} else {
    // Redirect to error page if recipe ID is not provided in the URL
    header("Location: error.php");
    exit();
}
