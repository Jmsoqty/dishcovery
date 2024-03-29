<?php include '../api/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/png" href="../assets/img/logo.png">
<title>Dishcovery | Bookmarks</title>

<!-- Main Template -->
<link rel="stylesheet" href="../assets/css/styles.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
<?php include 'components/navigation.php'; ?>

<!--  Main wrapper -->
<div class="body-wrapper">
    <!-- Header -->
    <?php include 'components/header.php'; ?>

    <div class="container-fluid">
        <div class="d-flex justify-content-around">
            <img src="../assets/img/search.png" class="img-fluid me-2" id="searchbar" width="35px">
            <input class="form-control w-100" type="text" id="search" placeholder="Search Dishcovery.." aria-label="default input example">
        </div>

        <div class="container border border-1 rounded my-3 p-3 text-center">
            <h3>Bookmarked Recipes</h3>
        </div>
    </div>

    <div id="recipeContainer" class="container"></div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var response; // Define response variable here

        $.ajax({
            url: '../api/fetch_bookmarks.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                response = data; // Assign response data to the variable
                if(response.status === 'success') {
                    renderRecipes(response.recipes); // Render all recipes initially
                } else {
                    console.log(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching recipes:", error);
            }
        });

        function filterRecipes(category) {
            var filteredRecipes = response.recipes.filter(function(recipe) {
                return recipe.recipe_data.category === category;
            });
            renderRecipes(filteredRecipes);
        }

        function renderRecipes(recipes) {
            $('#recipeContainer').empty(); // Clear existing recipes

            $.each(recipes, function(index, recipe) {
                var userEmail = '<?php echo $_SESSION['email']; ?>';

                var recipeHtml = `
                    <div class="container border border-1 rounded my-3 p-3">
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <div class="d-flex justify-content-around">
                                    <img src="data:image/jpeg;base64,${recipe.image_data || '../assets/img/default.png'}" class="img-fluid w-25">
                                    <div class="my-auto">
                                        <label class="fw-semibold" id="posted_by">${recipe.recipe_data.posted_by_name}</label>
                                        <p>${formatDate(recipe.recipe_data.date_updated)}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 text-center my-auto">
                                <h3>${recipe.recipe_data.recipe_name}</h3>
                            </div>
                            <div class="col-lg-4 my-auto">
                                <div class="d-flex justify-content-evenly">
                                    <button type="button" class="btn bg-none click-button" data-index="${index}">
                                        <img src="../assets/img/click.png" class="img-fluid" title="Ingredients">
                                    </button>
                                    <button type="button" class="btn bg-none">
                                        <img src="../assets/img/heart.png" class="img-fluid" title="Donate">
                                    </button>`;
                // Check if the email is the same as the session email
                if (userEmail !== recipe.recipe_data.posted_by) {
                    recipeHtml += `
                                    <button type="button" class="btn bg-none bookmark-button" data-index="${index}" data-bookmarked="${recipe.bookmarked}">
                                        <img src="${recipe.bookmarked ? '../assets/img/bookmarked.png' : '../assets/img/bookmark.png'}" class="img-fluid bookmark-icon" width="40px" title="${recipe.bookmarked ? 'Bookmarked' : 'Bookmark'}">
                                    </button>

                                    <!-- Include a hidden input field to store recipe_id -->
                                    <input type="hidden" class="recipe-id" value="${recipe.recipe_data.recipe_id}">
                                    `;
                }

                recipeHtml += `</div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="p-2 border border-1 rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                    <h5>Instructions:</h5>`;
                var instructions = JSON.parse(recipe.recipe_data.instructions); // Parse the instructions string into an array
                $.each(instructions, function(i, instruction) {
                    recipeHtml += `<label>Step ${i + 1}: ${instruction}</label><br>`;
                });
                recipeHtml += `</div></div>
                            <div class="col-12 col-lg-6">
                                <img src="data:image/jpeg;base64,${recipe.recipe_data.image}" style="width: 450px; height: 300px;" class="img-fluid border border-1 rounded">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-around">
                        <img src="../assets/img/comment.png" type="button" class="img-fluid my-auto" width="50px" data-bs-toggle="modal" data-bs-target="#modal2">
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Write a comment">
                            <button class="btn btn-outline-light" type="button">
                                <img src="../assets/img/send.svg" class="img-fluid" width="25px">
                            </button>
                        </div>
                    </div>`;

                $('#recipeContainer').append(recipeHtml);
            });
        }

        $(document).on('click', '.click-button', function() {
            var index = $(this).data('index');
            var ingredientsList = response.recipes[index].formatted_ingredients;

            $('#ingredientsTable tbody').empty();

            var ingredients = ingredientsList.map(function(ingredientString) {
                var parts = ingredientString.split(' ');
                var quantity = parts.shift();
                var unit = parts.shift();
                var title = parts.join(' ');
                return {
                    qty: quantity,
                    unit: unit,
                    title: title
                };
            });

            ingredients.forEach(function(ingredient) {
                var ingredientQuantity = ingredient.qty.trim();
                var ingredientUnit = ingredient.unit.trim();
                var ingredientName = ingredient.title.trim();

                $('#ingredientsTable tbody').append('<tr><td>' + ingredientQuantity + '</td><td>'+ ingredientUnit + ' ' + ingredientName + '</td></tr>');
            });

            $('#ingredientsModal').modal('show');
        });

        function formatDate(dateString) {
            var date = new Date(dateString);
            var options = { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric' };
            return date.toLocaleDateString('en-US', options);
        }

        // Function to check bookmark status for each recipe
        function checkBookmarkStatus() {
            $('.bookmark-button').each(function() {
                var index = $(this).data('index');
                var recipeId = $('.recipe-id').eq(index).val();
                var bookmarkButton = $(this);

                // AJAX request to check if the recipe is bookmarked
                $.ajax({
                    url: '../api/isBookmarked.php',
                    method: 'POST',
                    data: { recipe_id: recipeId },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.isBookmarked) {
                            bookmarkButton.find('.bookmark-icon').attr('src', '../assets/img/bookmarked.png');
                            bookmarkButton.data('bookmarked', true);
                        } else {
                            bookmarkButton.find('.bookmark-icon').attr('src', '../assets/img/bookmark.png');
                            bookmarkButton.data('bookmarked', false);
                        }
                        
                        // Add event listener to toggle bookmark on click
                        bookmarkButton.off('click').on('click', function() {
                            var isBookmarked = bookmarkButton.data('bookmarked');
                            if (isBookmarked) {
                                removeBookmark(recipeId);
                            } else {
                                addBookmark(recipeId);
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
            });
        }

        // Check bookmark status when the page loads
        $(document).ready(function() {
            checkBookmarkStatus();

            // Set up a timer to refresh bookmark status every 1 minute (adjust as needed)
            setInterval(checkBookmarkStatus, 500); // 60000 milliseconds = 1 minute
        });

        // Function to add bookmark
        function addBookmark(recipeId) {
            $.ajax({
                url: '../api/add_bookmark.php',
                type: 'POST',
                data: { recipe_id: recipeId},
                success: function(response) {
                    // Optionally update UI to reflect bookmark added
                },
                error: function(xhr, status, error) {
                    console.error("Error adding bookmark:", error);
                }
            });
        }

        // Function to remove bookmark with confirmation dialog and reload page
        function removeBookmark(recipeId) {
            // Show confirmation dialog
            var confirmation = confirm("Do you want to remove this bookmark?");
            if (confirmation) {
                // If user confirms, remove the bookmark
                $.ajax({
                    url: '../api/remove_bookmark.php',
                    type: 'POST',
                    data: { recipe_id: recipeId },
                    success: function(response) {
                        // Reload the page
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error("Error removing bookmark:", error);
                    }
                });
            }
        }

    });
</script>


<!-- Additional Scripts -->
<script src="../assets/libs/jquery/dist/jquery.min.js"></script>
<script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/sidebarmenu.js"></script>
<script src="../assets/js/app.min.js"></script>
<script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
<script src="../assets/libs/simplebar/dist/simplebar.js"></script>
<script src="../assets/js/dashboard.js"></script>

</body>

</html>
