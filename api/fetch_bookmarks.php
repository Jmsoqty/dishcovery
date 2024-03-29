<?php
include 'dbconfig.php';
session_start();

header('Content-Type: application/json');
$response = array();

$sql = "SELECT tbl_recipes.recipe_id, 
                tbl_recipes.recipe_name, 
                tbl_recipes.posted_by, 
                tbl_recipes.category, 
                tbl_recipes.ingredients, 
                tbl_recipes.instructions, 
                tbl_recipes.image, 
                tbl_recipes.posted_in, 
                tbl_recipes.isPublic, 
                tbl_recipes.date_updated, 
                tbl_users.prof_pic AS posted_by_image,
                tbl_users.name AS posted_by_name, 
                tbl_users.email AS posted_by_email
            FROM tbl_bookmarks
            INNER JOIN tbl_recipes ON tbl_bookmarks.recipe_id = tbl_recipes.recipe_id
            INNER JOIN tbl_users ON tbl_recipes.posted_by = tbl_users.email
            WHERE tbl_bookmarks.bookmark_by = '" . $_SESSION['email'] . "'";


$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Fetch the binary data for the image
            $binaryImageData = $row['posted_by_image'];

            // Remove the binary image data from the row array
            unset($row['posted_by_image']);

            // Fetch ingredients JSON string
            $ingredients = json_decode($row['ingredients'], true);

            // Format ingredients as 'qty pcs title'
            $formattedIngredients = array();
            foreach ($ingredients as $ingredient) {
                $formattedIngredients[] = $ingredient['qty'] . 'pcs ' . $ingredient['title'];
            }

            // Add the formatted ingredients to the response array
            $response['recipes'][] = array(
                'recipe_data' => $row,
                'formatted_ingredients' => $formattedIngredients,
                'image_data' => base64_encode($binaryImageData) // Convert binary data to base64 for JSON
            );
        }
        $result->close();
        $response['status'] = 'success';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'No Recipes found';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Error fetching recipes: ' . $conn->error;
}

$conn->close();

echo json_encode($response);
?>