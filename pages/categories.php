<?php include '../api/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/png" href="../assets/img/logo.png">
<title>Dishcovery | Categories</title>

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

        <div class="container border border-1 rounded text-center">
            <h1 id="categoryTitle">Categories</h1>
        </div>

        <div class="d-flex justify-content-around">
            <img src="../assets/img/search.png" class="img-fluid me-2" id="searchbar" width="35px">
            <input class="form-control w-100" type="text" id="search" placeholder="Search Dishcovery.." aria-label="default input example">
        </div>

        <div class="container border border-1 rounded my-3 p-3 text-center">
            <button type="button" class="btn btn-primary mb-2">Main Dishes</button>
            <button type="button" class="btn btn-primary mb-2">Side Dishes</button>
            <button type="button" class="btn btn-primary mb-2">Bread and Pastries</button>
            <button type="button" class="btn btn-primary mb-2">Regional Dishes</button>
            <button type="button" class="btn btn-primary mb-2">Street Food and Snacks</button>
            <button type="button" class="btn btn-primary mb-2">Exotic Dishes</button>
            <button type="button" class="btn btn-primary mb-2">Foreign Influences</button>
            <button type="button" class="btn btn-primary mb-2">International Dishes</button>
            <button type="button" class="btn btn-primary mb-2">Desserts</button>
        </div>
    </div>

    <div id="recipeContainer" class="container"></div>
</div>

<div class="modal fade" id="modal2" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-5 shadow-lg">
            <div class="text-end p-3">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <h3 class="text-center modal-recipe-title"></h3>

                <hr>

                <!-- Placeholder for comments -->
                <div class="comments-container" style="max-height: 500px; overflow-y: auto;"></div>

                <div class="d-flex justify-content-around">
                    <input id="commentInputModal" class="form-control w-75 me-2 comment-input-modal" type="text" placeholder="Write a comment…" aria-label="default input example">
                    <button id="addCommentBtnModal" class="btn btn-outline-primary add-comment-btn-modal">Send</button>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var buttons = document.querySelectorAll(".btn-primary");
    var categoryTitle = document.getElementById("categoryTitle");

    // Check if category is stored in localStorage
    var storedCategory = localStorage.getItem('selectedCategory');

    // If stored category exists, set the category title and render recipes
    if (storedCategory) {
        categoryTitle.textContent = storedCategory;
        filterRecipes(storedCategory);
    }

    buttons.forEach(function(button) {
        button.addEventListener("click", function() {
            var category = this.textContent.trim();
            categoryTitle.textContent = category;
            filterRecipes(category);

            // Store the clicked category in localStorage
            localStorage.setItem('selectedCategory', category);
        });
    });

    function filterRecipes(category) {
        var filteredRecipes = response.recipes.filter(function(recipe) {
            return recipe.recipe_data.category === category;
        });
        renderRecipes(filteredRecipes);
    }
});
</script>

<script>
    var response;

    $.ajax({
        url: '../api/fetch_recipes.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            response = data;
            if (response.status === 'success') {
                response.recipes.sort((a, b) => new Date(b.recipe_data.date_updated) - new Date(a.recipe_data.date_updated));
                renderRecipes(response.recipes);
            } else {
                $('#recipeContainer').append('<div class="d-flex justify-content-center align-items-center" style="height: 100%;"><div style="max-height: 350px; max-width: 350px;"><img src="../assets/img/NO POSTED.png" class="img-fluid"></div></div>');
            }
        },
        error: function(xhr, status, error) {
            console.error("Error fetching recipes:", error);
        }
    });

    function renderRecipes(recipes) {
        $('#recipeContainer').empty();

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
                                
                                `;

            if (userEmail !== recipe.recipe_data.posted_by) {
                recipeHtml += `
                                    <button type="button" class="btn bg-none">
                                        <img src="../assets/img/heart.png" class="img-fluid" title="Donate">
                                    </button>
                                    <button type="button" class="btn bg-none bookmark-button" data-index="${index}" data-bookmarked="${recipe.bookmarked}">
                                        <img src="${recipe.bookmarked ? '../assets/img/bookmarked.png' : '../assets/img/bookmark.png'}" class="img-fluid bookmark-icon" width="40px" title="${recipe.bookmarked ? 'Bookmarked' : 'Bookmark'}">
                                    </button>
                                    <input type="hidden" class="recipe-id" value="${recipe.recipe_data.recipe_id}">
                                    `;
            }
            if (userEmail === recipe.recipe_data.posted_by) {
                recipeHtml += `
                                    <button type="button" class="btn bg-none edit-recipe-btn" data-bs-toggle="modal" data-bs-target="#editRecipeModal">
                                        <img src="../assets/img/pencil.svg" style="width:40px; height: 40px;" class="img-fluid" title="Edit Recipe">
                                    </button>
                                    <button type="button" class="btn bg-none delete-recipe-btn" data-index="${index}" data-recipe-id="${recipe.recipe_data.recipe_id}">
                                        <img src="../assets/img/delete.png" style="width:40px; height: 40px;" class="img-fluid" title="Delete Recipe">
                                    </button>
                                    <input type="hidden" class="recipe-id" value="${recipe.recipe_data.recipe_id}"><input type="hidden" class="recipe-id" value="${recipe.recipe_data.recipe_id}">
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
            var instructions = JSON.parse(recipe.recipe_data.instructions);
            $.each(instructions, function(i, instruction) {
                recipeHtml += `<label>Step ${i + 1}: ${instruction}</label><br>`;
            });
            recipeHtml += `</div></div>
                        <div class="col-12 col-lg-6">
                            <img src="data:image/jpeg;base64,${recipe.recipe_data.image}" style="width: 450px; height: 300px;" class="img-fluid border border-1 rounded">
                        </div>
                    </div>
                </div>
                <div class="recipecomment d-flex justify-content-around" data-recipe-id="${recipe.recipe_data.recipe_id}" data-posted-by="${recipe.recipe_data.posted_by_name}">
                <img src="../assets/img/comment.png" class="img-fluid" width="50px" data-bs-toggle="modal" data-bs-target="#modal2" data-recipe-id="${recipe.recipe_data.recipe_id}">
                    <div class="input-group">
                        <input class="form-control comment-input" type="text" placeholder="Write a comment">
                        <button class="btn btn-outline-light add-comment-btn" type="button">
                            <img src="../assets/img/send.svg" class="img-fluid" width="25px">
                        </button>
                    </div>
                </div>`;

            $('#recipeContainer').append(recipeHtml);
            $('.add-comment-btn').off('click').on('click', function() {
                var recipeId = $(this).closest('.recipecomment').data('recipe-id');
                var commentInput = $(this).siblings('.comment-input');
                var commentDescription = commentInput.val();
            });
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

   $(document).on('click', '.delete-recipe-btn', function() {
    var recipeId = $(this).closest('.container').find('.recipe-id').val();

    if (confirm("Are you sure you want to delete this recipe?")) {
        $.ajax({
            url: '../api/delete_recipe.php',
            type: 'POST',
            dataType: 'json',
            data: {
                recipeId: recipeId
            },
            success: function(response) {
                if (response.status === 'success') {
                    location.reload();
                } else {
                    console.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error deleting recipe:", error);
            }
        });
    }
});

</script>

<script>
    $('#searchbar').click(function() {
        var searchTerm = $('#search').val().toLowerCase();

        var filteredRecipes = response.recipes.filter(function(recipe) {
            return recipe.recipe_data.recipe_name.toLowerCase().includes(searchTerm);
        });

        renderRecipes(filteredRecipes);
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
</script>

<script>
    // Function to add bookmark
    function addBookmark(recipeId) {
        $.ajax({
            url: '../api/add_bookmark.php',
            type: 'POST',
            data: { recipe_id: recipeId},
            success: function(response) {
            },
            error: function(xhr, status, error) {
                console.error("Error adding bookmark:", error);
            }
        });
    }

    // Function to remove bookmark
    function removeBookmark(recipeId) {
        $.ajax({
            url: '../api/remove_bookmark.php',
            type: 'POST',
            data: { recipe_id: recipeId},
            success: function(response) {
            },
            error: function(xhr, status, error) {
                console.error("Error removing bookmark:", error);
            }
        });
    }
</script>

<script>
    $(document).on('click', '.add-comment-btn', function() {
    var recipeId = $(this).closest('.recipecomment').data('recipe-id');
    var commentInput = $(this).siblings('.comment-input');

    if (commentInput.length > 0) {
        var commentDescription = commentInput.val();

        if (commentDescription.trim() !== '') {
            var formData = new FormData();
            formData.append('recipe_id', recipeId);
            formData.append('comment_description', commentDescription);

            $.ajax({
                url: '../api/add_comment.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    alert("Comment added successfully.");
                    commentInput.val('');
                },
                error: function(xhr, status, error) {
                    console.error("Error adding comment:", error);
                }
            });
        } else {
            alert("Please enter a non-empty comment.");
        }
    } else {
        console.error("Comment input element not found.");
    }
});
</script>

<script>
$(document).on('click', '.recipecomment img[data-bs-toggle="modal"]', function() {
    var button = $(this);
    var recipeId = button.closest('.recipecomment').data('recipe-id');

    // Fetch comments for the recipe
    fetchComments(recipeId);

    // Set the modal title
    var modalTitle = $('#modal2').find('.modal-recipe-title');
    var postedByName = button.closest('.recipecomment').data('posted-by');
    modalTitle.text(postedByName + "'s Recipe");

    var addCommentBtnModal = $('#modal2').find('.add-comment-btn-modal');
    var commentInputModal = $('#modal2').find('.comment-input-modal');

    addCommentBtnModal.off('click').on('click', function() {
        var commentDescription = commentInputModal.val();
        if (commentDescription.trim() !== '') {
            addComment(recipeId, commentDescription);
        } else {
            alert("Please enter a non-empty comment.");
        }
    });

    // Show the modal
    $('#modal2').modal('show');  
});


// Function to fetch comments for a recipe
function fetchComments(recipeId) {
    $.ajax({
        url: '../api/fetch_comments.php',
        type: 'GET',
        data: { recipe_id: recipeId },
        dataType: 'json',
        success: function(data) {
            var commentsContainer = $('.comments-container');
            commentsContainer.empty();

            if (data.status === 'success') {
                var comments = data.comments;
                if (Array.isArray(comments) && comments.length > 0) {
                    $.each(comments, function(index, comment) {
                        var formattedDate = formatDate(comment.date_created);
                        var sessionEmail = '<?php echo $_SESSION["email"]; ?>';
                        var showIcons = sessionEmail === comment.comment_by;
                        var pencilIcon = showIcons ? '<img src="../assets/img/pencil.svg" class="edit-comment img-fluid" data-comment-id="' + comment.comment_id + '" style="width: 25px; height: 25px; vertical-align: middle; margin-right: 10px;">' : '';
                        var trashIcon = showIcons ? '<img src="../assets/img/trash.svg" class="delete-comment img-fluid" data-comment-id="' + comment.comment_id + '" style="width: 50px; height: 50px; vertical-align: middle;">' : '';
                        var commentHtml = `
                            <div class="container">
                                <div class="d-flex justify-content-around align-items-center">
                                    <div>
                                        <img src="data:image/jpeg;base64,${comment.prof_pic}" class="img-fluid me-2 rounded-circle" width="50px">
                                    </div>
                                    <div class="w-100 rounded p-2">
                                        <p>${formattedDate}</p>
                                        <h5 class="fw-bold">${comment.name}</h5>
                                        <label class="comment-description">${comment.comment_description}</label>
                                        <input type="text" class="form-control edit-input mb-2" style="display: none;">
                                        <button class="btn btn-primary btn-sm save-edit" style="display: none;">Save</button>
                                        <button class="btn btn-secondary btn-sm cancel-edit" style="display: none;">Cancel</button>
                                    </div>
                                    <div class="text-center my-auto">
                                        ${pencilIcon}
                                    </div>
                                    <div class="text-center my-auto">
                                        ${trashIcon}
                                    </div>
                                </div>
                            </div>
                            <hr>
                    `;
                        commentsContainer.append(commentHtml);
                    });

                    $('.edit-comment').click(function() {
                        var parent = $(this).closest('.container');
                        parent.find('.comment-description').hide();
                        parent.find('.edit-input').val(parent.find('.comment-description').text()).show().focus();
                        parent.find('.save-edit').show();
                        parent.find('.cancel-edit').show();
                    });

                    $('.delete-comment').click(function() {
                        if (confirm("Are you sure you want to delete this comment?")) {
                            var commentId = $(this).data('comment-id');
                            $.ajax({
                                url: '../api/delete_comment.php',
                                method: 'POST',
                                data: { action: 'delete_comment', comment_id: commentId },
                                dataType: 'json',
                                success: function(response) {
                                    if (response.status === 'success') {
                                        // Refresh comments after deletion
                                        fetchComments(recipeId);
                                    } else {
                                        alert('Error deleting comment: ' + response.message);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error("Error deleting comment:", error);
                                }
                            });
                        }
                    });
                    
                    $('.cancel-edit').click(function() {
                        var parent = $(this).closest('.container');
                        parent.find('.comment-description').show();
                        parent.find('.edit-input').hide();
                        parent.find('.btn-group').hide();
                        parent.find('.save-edit').hide();
                        parent.find('.cancel-edit').hide();
                    });

                    $('.save-edit').click(function() {
                        var parent = $(this).closest('.container');
                        var commentId = parent.find('.edit-comment').data('comment-id');
                        var newComment = parent.find('.edit-input').val();
                        $.ajax({
                            url: '../api/edit_comment.php',
                            method: 'POST',
                            data: { action: 'edit_comment', comment_id: commentId, new_comment: newComment },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    // Refresh comments after editing
                                    fetchComments(recipeId);
                                } else {
                                    alert('Error editing comment: ' + response.message);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("Error editing comment:", error);
                            }
                        });
                    });
                } else {
                    commentsContainer.append('<center><p>No comments found.</p></center>');
                }
            } else if (data && data.status === 'error' && data.message === 'No comments found for this recipe') {
                commentsContainer.append('<center><p>No comments found for this recipe.</p></center>');
            } else {
                console.error("Empty response or API error:", data);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error fetching comments:", error);
        }
    });
}

// Function to add a comment for a recipe
function addComment(recipeId, commentDescription) {
    var formData = new FormData();
    formData.append('recipe_id', recipeId);
    formData.append('comment_description', commentDescription);

    $.ajax({
        url: '../api/add_comment.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            alert("Comment added successfully.");
            fetchComments(recipeId); // Refresh comments after adding a new comment
            $('.comment-input-modal').val(''); // Clear the comment input field
        },
        error: function(xhr, status, error) {
            console.error("Error adding comment:", error);
        }
    });
}
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

<div class="modal fade" id="ingredientsModal" tabindex="-1" aria-labelledby="ingredientsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: auto;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ingredientsModalLabel">Ingredients</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height:500px; overflow: auto;">
                <table id="ingredientsTable" class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Quantity</th>
                            <th>Ingredients</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

