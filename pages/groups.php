<?php include '../api/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/png" href="../assets/img/logo.png">
<title>Dishcovery | Groups</title>

<!-- Main Template -->
<link rel="stylesheet" href="../assets/css/styles.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
<?php include 'components/navigation.php'; ?>

<!--  Main wrapper -->
<div class="body-wrapper">
  
<!--  Header -->
<?php include 'components/header.php'; ?>
<div class="container-fluid">
        <div class="container border border-1 rounded text-center">
                <h1 id="title_of_page">Groups Page</h1>
        </div>

        <div class="d-flex justify-content-around">
            <img src="../assets/img/search.png" class="img-fluid me-2" id ="searchbar_main" width="35px">
            
            <input class="form-control w-100 me-4" type="text" id="search_input" placeholder="Search.." aria-label="default input example">
            
            <img src="../assets/img/add.png" class="img-fluid me-3" data-bs-toggle="modal" data-bs-target="#create" id ="create_group" width="35px" title="Create Group">
            
            <img src="../assets/img/join.png" class="img-fluid me-3" data-bs-toggle="modal" data-bs-target="#join" id ="join_group" width="35px" title="Join Group">

            <img src="../assets/img/person.png" class="img-fluid me-3" data-bs-toggle="modal" data-bs-target="#visit" id ="visit_group" width="35px" title="Visit Group">

            <img src="../assets/img/dismissal.png" class="img-fluid me-3" data-bs-toggle="modal" data-bs-target="#leave" id ="leave_group" width="35px" title="Leave Group">

        </div>
        
        <div class="container border border-1 rounded my-3 p-3" id="shared_recipe">
            
        </div>

        <div id="recipeContainer" class="container"></div>
    </div>
</div>

<div class="modal fade" id="create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">  
    <div class="modal-content rounded-5 shadow-lg">
      <div class="text-end p-3">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h3 class="text-center">Create your group</h3>
        <hr>
        <input class="form-control text-center my-4 mt-2" type="text" id="group_name" placeholder="Group Name">
        <div class="text-center mt-2">
          <button type="button" id="create_group_button" class="btn btn-primary">Create Group</button>
        </div>
        
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="join" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content rounded-5 shadow-lg">
      <div class="modal-header border-bottom-0">
        <h3 class="modal-title text-center w-100" id="exampleModalLabel">Join a Group</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="search_group" placeholder="Search..." aria-label="Search for groups" aria-describedby="searchbar">
          <span class="input-group-text" id="searchbar"><img src="../assets/img/search.png" alt="Search" width="20"></span>
        </div>
        <hr>
        <h5 class="text-center">Available Groups</h5>
        <table class="table" id="group_table">
          <thead>
            <tr>
              <th scope="col">Community Name</th>
              <th scope="col">Number of Members</th>
              <th scope="col">Date Created</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $session_email = $_SESSION['email'];
            $sql = "SELECT 
            community_name,
            COUNT(*) AS number_of_members,
            MIN(date_created) AS date_created
            FROM 
                tbl_communities
            WHERE 
                community_name NOT IN (SELECT community_name FROM tbl_communities WHERE user_who_joined = '$session_email')
            GROUP BY 
                community_name";


            $result = $conn->query($sql);

            if (!$result) {
                echo "Error: " . $conn->error;
            } else {
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='text-center'>" . $row["community_name"] . "</td>";
                        echo "<td class='text-center'>" . $row["number_of_members"] . "</td>";
                        $formatted_date = date("F j, Y", strtotime($row["date_created"]));
                        echo "<td class='text-center'>" . $formatted_date . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='text-center'>No communities found</td></tr>";
                }
            }
            ?>
          </tbody>
        </table>
        <div id="no_community_found" class="text-center mt-3" style="display: none;">
          No Community Found
        </div>
        <div class="text-center mt-3">
          <button type="button" id="join_group_button" class="btn btn-primary">Join Group</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="visit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content rounded-5 shadow-lg">
      <div class="modal-header border-bottom-0">
        <h3 class="modal-title text-center w-100" id="exampleModalLabel">Visit a Group</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="search_joined_group" placeholder="Search..." aria-label="Search for groups" aria-describedby="searchbar">
          <span class="input-group-text" id="searchbar"><img src="../assets/img/search.png" alt="Search" width="20"></span>
        </div>
        <hr>
        <h5 class="text-center">Joined Groups</h5>
        <table class="table" id="group_table_joined">
          <thead>
            <tr>
              <th scope="col">Community Name</th>
              <th scope="col">Number of Members</th>
              <th scope="col">Date Created</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $session_email = $_SESSION['email'];
            $sql = "SELECT 
                        community_name,
                        COUNT(*) AS number_of_members,
                        MIN(date_created) AS date_created
                    FROM 
                        tbl_communities
                    WHERE 
                        community_name IN (SELECT community_name FROM tbl_communities WHERE user_who_joined = '$session_email')
                    GROUP BY 
                        community_name";

            $result = $conn->query($sql);

            if (!$result) {
                echo "Error: " . $conn->error;
            } else {
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='text-center'>" . $row["community_name"] . "</td>";
                        echo "<td class='text-center'>" . $row["number_of_members"] . "</td>";
                        $formatted_date = date("F j, Y", strtotime($row["date_created"]));
                        echo "<td class='text-center'>" . $formatted_date . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='text-center'>No communities found</td></tr>";
                }
            }
            ?>
          </tbody>
        </table>
        <div id="no_community_found_visit" class="text-center mt-3" style="display: none;">
          No Community Found
        </div>
        <div class="text-center mt-3">
          <button type="button" id="visit_group_button" class="btn btn-primary">Visit Group</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="leave" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content rounded-5 shadow-lg">
      <div class="modal-header border-bottom-0">
        <h3 class="modal-title text-center w-100" id="exampleModalLabel">Leave a Group</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="search_leave" placeholder="Search..." aria-label="Search for groups" aria-describedby="searchbar">
          <span class="input-group-text" id="searchbar"><img src="../assets/img/search.png" alt="Search" width="20"></span>
        </div>
        <hr>
        <h5 class="text-center">Joined Groups</h5>
        <table class="table" id="group_table_leave">
          <thead>
            <tr>
              <th scope="col">Community Name</th>
              <th scope="col">Number of Members</th>
              <th scope="col">Date Created</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $session_email = $_SESSION['email'];
            $sql = "SELECT 
                        community_name,
                        COUNT(*) AS number_of_members,
                        MIN(date_created) AS date_created
                    FROM 
                        tbl_communities
                    WHERE 
                        community_name IN (SELECT community_name FROM tbl_communities WHERE user_who_joined = '$session_email')
                    GROUP BY 
                        community_name";

            $result = $conn->query($sql);

            if (!$result) {
                echo "Error: " . $conn->error;
            } else {
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='text-center'>" . $row["community_name"] . "</td>";
                        echo "<td class='text-center'>" . $row["number_of_members"] . "</td>";
                        $formatted_date = date("F j, Y", strtotime($row["date_created"]));
                        echo "<td class='text-center'>" . $formatted_date . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='text-center'>No communities found</td></tr>";
                }
            }
            ?>
          </tbody>
        </table>
        <div id="no_community_found_leave" class="text-center mt-3" style="display: none;">
          No Community Found
        </div>
        <div class="text-center mt-3">
          <button type="button" id="leave_group_button" class="btn btn-primary">Leave Group</button>
        </div>
      </div>
    </div>
  </div>
</div>




<div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">  
    <div class="modal-content rounded-5 shadow-lg">
      <div class="text-end p-3">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-3">
        <h3 class="text-center">Share your dish now!</h3>
        <input class="form-control text-center my-2" type="text" id="recipe_name" placeholder="Title">
        <select id="categorySelect" class="form-select my-2" aria-label="Default select example">
          <option selected disabled>Choose Category</option>
          <?php
          // Fetch categories from database and populate the select options
          $sql = "SELECT category_name FROM tbl_categories";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                  echo "<option value='" . $row["category_name"] . "'>" . $row["category_name"] . "</option>";
              }
          } else {
              echo "<option>No categories found</option>";
          }
          ?>
        </select>
        <div class="row">
          <div class="col-12 col-md-6">
            <h3>Ingredients</h3>
            <div id="ingredientContainer">
              <!-- Ingredients will be dynamically added here -->
            </div>

            <div class="text-end my-2">
              <button type="button" class="btn btn-sm btn-outline-primary add-ingredient w-100">+ Add more</button>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <h3>Instructions</h3>
            <div id="instructionContainer">
              <!-- Instructions will be dynamically added here -->
            </div>
            <div class="text-end my-2">
              <button type="button" class="btn btn-sm btn-outline-primary add-instruction w-100">+ Add more</button>
            </div>
          </div>
        </div>

        <hr>

        <div class="row">
          <div class="col text-center">
            <h3>Final Output</h3>
            <div class="shadow border border-opacity-50 mt-2" style="width: 200px; height: 200px; margin: 0 auto; text-align: center; display: flex; align-items: center; justify-content: center;">
              <img src="../assets/img/questionmark.jpg" style="width: 180px; height: 180px;" class="image-preview">
            </div>
            <input type="file" id="image" accept="image/*" class="form-control form-control-sm mt-4 mb-3 profile-image-input">
          </div>
        </div>

        <div class="text-center mt-2">
          <button type="button" id="postRecipeBtn" class="btn btn-primary">Post Recipe</button>
        </div>
        
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editRecipeModal" tabindex="-1" aria-labelledby="editRecipeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRecipeModalLabel">Edit Recipe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editRecipeForm">
                    <div class="mb-3">
                        <label for="editRecipeName" class="form-label">Recipe Name</label>
                        <input type="text" class="form-control" id="editRecipeName" name="recipeName" required>
                    </div>
                    <!-- Container for ingredients -->
                    <div id="editIngredientContainer">
                        <!-- Ingredients will be dynamically added here -->
                    </div>
                    <div class="text-end my-2">
                        <button type="button" class="btn btn-sm btn-outline-primary add-ingredient-edit w-100">+ Add more</button>
                    </div>
                    <!-- Container for instructions -->
                    <div id="editInstructionContainer">
                        <!-- Instructions will be dynamically added here -->
                    </div>
                    <div class="text-end my-2">
                        <button type="button" class="btn btn-sm btn-outline-primary add-instruction-edit w-100">+ Add more</button>
                    </div>
                    <!-- Input field for image -->
                    <div class="row">
                        <div class="col text-center">
                            <h3>Final Output</h3>
                            <div class="shadow border border-opacity-50 mt-2" style="width: 200px; height: 200px; margin: 0 auto; text-align: center; display: flex; align-items: center; justify-content: center;">
                                <img id="editRecipeImagePreview" src="../assets/img/questionmark.jpg" style="width: 180px; height: 180px;" class="image-preview-edit">
                            </div>
                            <input type="file" id="image-edit" accept="image/*" class="form-control form-control-sm mt-4 mb-3 profile-image-input-edit">
                        </div>
                    </div>
                    <!-- Hidden input field for recipe ID -->
                    <input type="hidden" id="editRecipeId" name="recipeId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="editRecipeBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="wallet-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="wallet-modal-label">E-Wallet Balance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-floating mb-3">
                    <h1 class="text-center" id="balance">$<?php echo $current_balance; ?></h1>
                    <label for="balance">Current Balance</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="donation" step="0.01" min="1" max="100000" placeholder="Insert your desired amount">
                    <label for="donation">Send Funds</label>
                </div>
                <div id="paypal-button-container"></div>
            </div>
        </div>
    </div>
</div>

<script>
    function setPostedBy(button) {
        var postedBy = button.getAttribute('data-posted');
        document.getElementById('wallet-modal').setAttribute('data-posted', postedBy);
    }

    paypal.Buttons({
        createOrder: function(data, actions) {
            var amount = document.getElementById('donation').value;
            var currentBalance = parseFloat(document.getElementById('balance').innerText.replace('$', ''));

            if (currentBalance < amount) {
                alert('Your current balance is insufficient. Please top up more.');
                return actions.reject();
            }

            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: amount,
                        currency_code: 'USD'
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            var postedBy = document.getElementById('wallet-modal').getAttribute('data-posted');
            var amount = document.getElementById('donation').value;
            var transactionId = data.orderID;
            return actions.order.capture().then(function(details) {
                $.ajax({
                    type: "POST",
                    url: "../api/donate.php",
                    data: {
                        payment: amount,
                        posted_by: postedBy,
                        transaction_id: transactionId
                    },
                    success: function(response) {
                        alert('Donated Successfully, please reload the page.');
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred, please try again later');
                        console.error(error);
                    }
                });
            });
        },
        onCancel: function(data) {
            alert('Payment cancelled');
        },
        onError: function(err) {
            alert('Please top up more, try again later');
            console.error(err);
        }
    }).render('#paypal-button-container');
</script>

<script>
  $(document).ready(function() {
    $('.add-ingredient').click(function() {
        var newIngredientRow = `
            <div class="row ingredient-row mb-2">
                <div class="col-sm-4">
                    <input type="number" class="form-control qty-input" placeholder="Qty" min="1" required>
                </div>
                <div class="col-sm-8">
                    <input type="text" class="form-control title-input" placeholder="Ingredient Title" required>
                </div>
            </div>`;
        $('#ingredientContainer').append(newIngredientRow);
    });

    $('.add-instruction').click(function() {
        var newInstructionStep = `
            <div class="row instruction-step mb-2">
                <div class="col-12">
                    <input type="text" class="form-control instruction-input" placeholder="Instruction Step" required>
                </div>
            </div>`;
        $('#instructionContainer').append(newInstructionStep);
    });

    $('.add-ingredient-edit').click(function() {
            var newIngredientRow = `
                <div class="row ingredient-row mb-2">
                    <div class="col-sm-4">
                        <input type="number" class="form-control qty-input" placeholder="Qty" min="1" required>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control title-input" placeholder="Ingredient Title" required>
                    </div>
                </div>`;
            $('#editIngredientContainer').append(newIngredientRow);
        });

        $('.add-instruction-edit').click(function() {
            var newInstructionStep = `
                <div class="row instruction-step mb-2">
                    <div class="col-12">
                        <input type="text" class="form-control instruction-input" placeholder="Instruction Step" required>
                    </div>
                </div>`;
            $('#editInstructionContainer').append(newInstructionStep);
        });
});
</script>

<script>
    $('#image').change(function() {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.image-preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });

    $('#image-edit').change(function() {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.image-preview-edit').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });
</script>

<script>
    $('#postRecipeBtn').click(function() {
        if ($('#recipe_name').val() && $('#categorySelect').val() && $('#image').val()) {
            var formData = new FormData();
            var fileInput = $('#image')[0].files[0];
            formData.append('image', fileInput);
            formData.append('recipe_name', $('#recipe_name').val());
            formData.append('category_name', $('#categorySelect').val());

            var urlParams = new URLSearchParams(window.location.search);
            var community = urlParams.get('community');
            formData.append('community_name', community);

            var ingredients = [];
            $('.ingredient-row').each(function() {
                var qty = $(this).find('.qty-input').val();
                var title = $(this).find('.title-input').val();
                if (qty && title) {
                    ingredients.push({ qty: qty, title: title });
                }
            });
            formData.append('ingredients', JSON.stringify(ingredients));

            var instructions = [];
            $('.instruction-input').each(function() {
                var step = $(this).val();
                if (step) {
                    instructions.push(step);
                }
            });
            formData.append('instructions', JSON.stringify(instructions));

            $.ajax({
                url: '../api/add_recipe_to_group.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    alert("Recipe added successfully.");
                    $('#modal1').modal('hide');
                    $('#recipe_name').val('');
                    $('#categorySelect').val('');
                    $('.qty-input').val('');
                    $('.title-input').val('');
                    $('.instruction-input').val('');
                    $('#image').val('');
                    $('.image-preview').attr('src', '../assets/img/questionmark.jpg');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            alert("Please fill in all required fields.");
        }
    });
</script>

<script>
    var response;

    function getUrlParameter(name) {
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(window.location.href);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }

    var community = getUrlParameter('community');

    $.ajax({
        url: '../api/fetch_recipes_from_groups.php?community=' + community,
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
                                <img src="data:image/jpeg;base64,${recipe.image_data || '../assets/img/default.png'}" class="img-fluid w-25" style="width: 100px; height: 80px;">
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
                                    <button type="button" class="btn bg-none" data-bs-toggle="modal" data-bs-target="#wallet-modal" data-index="${index}" data-posted="${recipe.recipe_data.posted_by}" onclick="setPostedBy(this)">
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
$(document).ready(function() {
  $("#create_group_button").click(function() {
    var groupName = $("#group_name").val();
    $.ajax({
      url: '../api/create_group.php',
      method: 'POST',
      data: { group_name: groupName },
      success: function(response) {
        console.log(response);
        if (response.startsWith('Error')) {
          alert(response);
        } else {
          alert(response);
          location.reload();
        }
      },
      error: function(xhr, status, error) {
        alert('Error: ' + error);
        console.error('Error:', error);
      }
    });
  });
});
</script>

<style>
  .selected {
    background-color: #f0f0f0;
  }
</style>

<script>
  $(document).ready(function() {
    $('#search_group').on('keyup', function() {
      var searchText = $(this).val().toLowerCase();
      var noCommunityFound = true;
      $('#group_table tbody tr').each(function() {
        var rowText = $(this).text().toLowerCase();
        var rowVisible = rowText.indexOf(searchText) > -1;
        $(this).toggle(rowVisible);
        if (rowVisible) {
          noCommunityFound = false;
        }
      });
      $('#no_community_found').toggle(noCommunityFound);
    });

    $('#join_group_button').click(function() {
      var selectedRow = $('#group_table tbody tr.selected');
      if (selectedRow.length > 0) {
        var communityName = selectedRow.find('td:eq(0)').text();
        joinGroup(communityName);
      }
    });

    $('#group_table tbody').on('click', 'tr', function() {
      $('#group_table tbody tr.selected').removeClass('selected');
      $(this).addClass('selected');
    });

    function joinGroup(communityName) {
      $.ajax({
        type: 'POST',
        url: '../api/join_group.php',
        data: {group_name: communityName},
        success: function(response) {
          alert(response);
          location.reload();
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
          alert('Error joining group. Please try again.'); 
        }
      });
    }
  });
</script>

<script>
  $(document).ready(function() {
    $('#search_leave').on('keyup', function() {
      var searchText = $(this).val().toLowerCase();
      var noCommunityFound = true;
      $('#group_table_leave tbody tr').each(function() {
        var rowText = $(this).text().toLowerCase();
        var rowVisible = rowText.indexOf(searchText) > -1;
        $(this).toggle(rowVisible);
        if (rowVisible) {
          noCommunityFound = false;
        }
      });
      $('#no_community_found_leave').toggle(noCommunityFound);
    });

    $('#leave_group_button').click(function() {
      var selectedRow = $('#group_table_leave tbody tr.selected');
      if (selectedRow.length > 0) {
        var communityName = selectedRow.find('td:eq(0)').text();
        leaveGroup(communityName);
      }
    });

    $('#group_table_leave tbody').on('click', 'tr', function() {
      $('#group_table_leave tbody tr.selected').removeClass('selected');
      $(this).addClass('selected');
    });

    function leaveGroup(communityName) {
        $.ajax({
            type: 'POST',
            url: '../api/leave_group.php',
            data: {group_name: communityName},
            success: function(response) {
                alert(response);
                var currentUrl = new URL(window.location.href);
                var currentCommunityParam = currentUrl.searchParams.get('community');

                if (currentCommunityParam && currentCommunityParam === communityName) {
                    currentUrl.searchParams.delete('community');
                    window.history.pushState({}, document.title, currentUrl.toString());
                }
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Error leaving group. Please try again.'); 
            }
        });
    }
  });
</script>


<script>
  $(document).ready(function() {
    function getCommunityFromUrl() {
      var urlParams = new URLSearchParams(window.location.search);
      return urlParams.get('community');
    }

    function loadContentFromCommunity(community) {
      if (community) {
        var titleElement = document.getElementById('title_of_page');
        titleElement.textContent = community;

        var imageSource = "<?php echo $image_source; ?>";
        var fullname = "<?php echo $fullname; ?>";
        var content = `
          <div class="d-flex justify-content-around">
            <img src="${imageSource}" class="img-fluid me-2" style="width: 70px; height: 70px;">
            <button type="button" class="btn bg-none w-100 text-start border" data-bs-toggle="modal" data-bs-target="#modal1">
              <img src="../assets/img/write.png" class="img-fluid me-2" title="Post Recipe">    
              Do you have something to share, ${fullname}?
            </button>
          </div>
        `;
        $('#shared_recipe').html(content);
      }
    }

    var community = getCommunityFromUrl();
    loadContentFromCommunity(community);

     $('#search_joined_group').on('keyup', function() {
      var searchText = $(this).val().toLowerCase();
      var noCommunityFound = true;
      $('#group_table_joined tbody tr').each(function() {
        var rowText = $(this).text().toLowerCase();
        var rowVisible = rowText.indexOf(searchText) > -1;
        $(this).toggle(rowVisible);
        if (rowVisible) {
          noCommunityFound = false;
        }
      });
      $('#no_community_found_visit').toggle(noCommunityFound);
    });

    $('#visit_group_button').click(function() {
      var selectedRow = $('#group_table_joined tbody tr.selected');
      if (selectedRow.length > 0) {
        var communityName = selectedRow.find('td:eq(0)').text();
        visitGroup(communityName);
      }
    });

    $('#group_table_joined tbody').on('click', 'tr', function() {
      $('#group_table_joined tbody tr.selected').removeClass('selected');
      $(this).addClass('selected');
      
      $('#shared_recipe').empty();
    });

    function visitGroup(communityName) {
      alert('Visiting ' + communityName);
      var imageSource = "<?php echo $image_source; ?>";
      var fullname = "<?php echo $fullname; ?>";
      
      var content = `
        <div class="d-flex justify-content-around">
          <img src="${imageSource}" class="img-fluid me-2" width="50px">
          <button type="button" class="btn bg-none w-100 text-start border" data-bs-toggle="modal" data-bs-target="#modal1">
            <img src="../assets/img/write.png" class="img-fluid me-2" title="Post Recipe">    
            Do you have something to share, ${fullname}?
          </button>
        </div>
      `;
      
      $('#shared_recipe').append(content);
      
      var currentUrl = window.location.href;
      var urlWithoutParams = currentUrl.split('?')[0];
      var updatedUrl = urlWithoutParams + '?community=' + encodeURIComponent(communityName);
      window.history.pushState({}, document.title, updatedUrl);
      

      loadContentFromCommunity(communityName);
      location.reload();

      
    }
  });
</script>

<script>
    $('#searchbar_main').click(function() {
        var searchTerm = $('#search_input').val().toLowerCase();

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

    function checkBookmarkStatus() {
        $('.bookmark-button').each(function() {
            var index = $(this).data('index');
            var recipeId = $('.recipe-id').eq(index).val();
            var bookmarkButton = $(this);

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
</script>

<script>
    $(document).ready(function() {
        checkBookmarkStatus();
        setInterval(checkBookmarkStatus, 500);
    });

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
                                        <img src="data:image/jpeg;base64,${comment.prof_pic}" class="img-fluid me-2 rounded-circle" style="width: 100px; height: 80px;" >
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

<script>
function populateEditRecipeModal(recipe) {
    var imageBase64 = recipe.recipe_data.image;
    var imageElement = document.getElementById('editRecipeImagePreview');
    imageElement.src = 'data:image/jpeg;base64,' + imageBase64;

    $('#editRecipeName').val(recipe.recipe_data.recipe_name);
    var ingredients = JSON.parse(recipe.recipe_data.ingredients);

    $('#editIngredientContainer').empty();
    if (Array.isArray(ingredients)) {
        ingredients.forEach(function(ingredient) {
            var ingredientRow = `
                <div class="row ingredient-row mb-2">
                    <div class="col-sm-4">
                        <input type="number" class="form-control qty-input" placeholder="Qty" min="1" required value="${ingredient.qty}">
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control title-input" placeholder="Ingredient Title" required value="${ingredient.title}">
                    </div>
                </div>`;
            $('#editIngredientContainer').append(ingredientRow);
        });
    } else {
        console.error("Ingredients data is not in the expected format:", ingredients);
    }

    var instructions = JSON.parse(recipe.recipe_data.instructions);

    $('#editInstructionContainer').empty();
    if (Array.isArray(instructions)) {
        instructions.forEach(function(instruction, index) {
            var instructionStep = `
                <div class="row instruction-step mb-2">
                    <div class="col-12">
                        <input type="text" class="form-control instruction-input" placeholder="Instruction Step" required value="${instruction}">
                    </div>
                </div>`;
            $('#editInstructionContainer').append(instructionStep);
        });
    } else {
        console.error("Instructions data is not in the expected format:", instructions);
    }

    $('#editRecipeId').val(recipe.recipe_data.recipe_id);
}

$(document).on('click', '.edit-recipe-btn', function() {
    var index = $(this).closest('.container').index();
    var recipe = response.recipes[index];
    populateEditRecipeModal(recipe);
    $('#editRecipeModal').modal('show');
});

$('#editRecipeBtn').click(function() {
    var formData = new FormData();
    var fileInput = $('#image-edit')[0].files[0];
    formData.append('image', fileInput);
    formData.append('recipe_id', $('#editRecipeId').val());
    formData.append('recipe_name', $('#editRecipeName').val());
    formData.append('ingredients', JSON.stringify(getIngredientsData()));
    formData.append('instructions', JSON.stringify(getInstructionsData()));

    $.ajax({
        url: '../api/edit_recipe.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            console.log(response);
            $('#editRecipeModal').modal('hide');
            location.reload();
        },
        error: function(xhr, status, error) {
            console.error("Error editing recipe:", error);
        }
    });
});

function getIngredientsData() {
    var ingredientsData = [];
    $('.ingredient-row').each(function() {
        var qty = $(this).find('.qty-input').val();
        var title = $(this).find('.title-input').val();
        ingredientsData.push({ qty: qty, title: title });
    });
    return ingredientsData;
}

function getInstructionsData() {
    var instructionsData = [];
    $('.instruction-step').each(function() {
        var instruction = $(this).find('.instruction-input').val();
        instructionsData.push(instruction);
    });
    return instructionsData;
}

</script><script>
function populateEditRecipeModal(recipe) {
    var imageBase64 = recipe.recipe_data.image;
    var imageElement = document.getElementById('editRecipeImagePreview');
    imageElement.src = 'data:image/jpeg;base64,' + imageBase64;

    $('#editRecipeName').val(recipe.recipe_data.recipe_name);
    var ingredients = JSON.parse(recipe.recipe_data.ingredients);

    $('#editIngredientContainer').empty();
    if (Array.isArray(ingredients)) {
        ingredients.forEach(function(ingredient) {
            var ingredientRow = `
                <div class="row ingredient-row mb-2">
                    <div class="col-sm-4">
                        <input type="number" class="form-control qty-input" placeholder="Qty" min="1" required value="${ingredient.qty}">
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control title-input" placeholder="Ingredient Title" required value="${ingredient.title}">
                    </div>
                </div>`;
            $('#editIngredientContainer').append(ingredientRow);
        });
    } else {
        console.error("Ingredients data is not in the expected format:", ingredients);
    }

    var instructions = JSON.parse(recipe.recipe_data.instructions);

    $('#editInstructionContainer').empty();
    if (Array.isArray(instructions)) {
        instructions.forEach(function(instruction, index) {
            var instructionStep = `
                <div class="row instruction-step mb-2">
                    <div class="col-12">
                        <input type="text" class="form-control instruction-input" placeholder="Instruction Step" required value="${instruction}">
                    </div>
                </div>`;
            $('#editInstructionContainer').append(instructionStep);
        });
    } else {
        console.error("Instructions data is not in the expected format:", instructions);
    }

    $('#editRecipeId').val(recipe.recipe_data.recipe_id);
}

$(document).on('click', '.edit-recipe-btn', function() {
    var index = $(this).closest('.container').index();
    var recipe = response.recipes[index];
    populateEditRecipeModal(recipe);
    $('#editRecipeModal').modal('show');
});

$('#editRecipeBtn').click(function() {
    var formData = new FormData();
    var fileInput = $('#image-edit')[0].files[0];
    formData.append('image', fileInput);
    formData.append('recipe_id', $('#editRecipeId').val());
    formData.append('recipe_name', $('#editRecipeName').val());
    formData.append('ingredients', JSON.stringify(getIngredientsData()));
    formData.append('instructions', JSON.stringify(getInstructionsData()));

    $.ajax({
        url: '../api/edit_recipe.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            console.log(response);
            $('#editRecipeModal').modal('hide');
            location.reload();
        },
        error: function(xhr, status, error) {
            console.error("Error editing recipe:", error);
        }
    });
});

function getIngredientsData() {
    var ingredientsData = [];
    $('.ingredient-row').each(function() {
        var qty = $(this).find('.qty-input').val();
        var title = $(this).find('.title-input').val();
        ingredientsData.push({ qty: qty, title: title });
    });
    return ingredientsData;
}

function getInstructionsData() {
    var instructionsData = [];
    $('.instruction-step').each(function() {
        var instruction = $(this).find('.instruction-input').val();
        instructionsData.push(instruction);
    });
    return instructionsData;
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