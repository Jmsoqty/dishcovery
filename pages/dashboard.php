<?php include '../api/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/png" href="../assets/img/logo.png">
<title>Dishcovery | YFeed</title>

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

        <div class="d-flex justify-content-around">

            <img src="../assets/img/search.png" class="img-fluid me-2" id ="searchbar" width="35px">
            
            <input class="form-control w-100" type="text" id="search" placeholder="Search Dishcovery.." aria-label="default input example">

        </div>

        <div class="container border border-1 rounded my-3 p-3">
            <div class="d-flex justify-content-around">
                <img src="<?php echo $image_source; ?>" class="img-fluid me-2" width="50px">
                
                <button type="button" class="btn bg-none w-100 text-start border" data-bs-toggle="modal" data-bs-target="#modal1">
                    <img src="../assets/img/write.png" class="img-fluid me-2" title="Post Recipe">    
                    Do you have something to share, <?php echo $fullname; ?>?
                </button>

            </div>
        </div>

        <div id="recipeContainer" class="container"></div>
          
    </div>
  </div>
</div>



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

<!-- Modal -->
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
</div><div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
</div><div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

<script>
  $(document).ready(function() {
    // Function to handle adding ingredient rows
    $('.add-ingredient').click(function() {
      var newIngredientRow = `
        <div class="row ingredient-row">
          <div class="col-sm-4">
            <input type="number" class="form-control qty-input" placeholder="Qty" min="1" required>
          </div>
          <div class="col-sm-8">
            <input type="text" class="form-control title-input" placeholder="Ingredient Title" required>
          </div>
        </div>`;
      $('#ingredientContainer').append(newIngredientRow);
    });

    // Function to handle adding instruction steps
    $('.add-instruction').click(function() {
      var newInstructionStep = `
        <div class="row instruction-step">
          <div class="col-12">
            <input type="text" class="form-control instruction-input" placeholder="Instruction Step" required>
          </div>
        </div>`;
      $('#instructionContainer').append(newInstructionStep);
    });

    // Function to handle form submission
    $('#postRecipeBtn').click(function() {
      // Check if all required fields are filled
      if ($('#recipe_name').val() && $('#categorySelect').val() && $('#image').val()) {
        var formData = new FormData();
        var fileInput = $('#image')[0].files[0];
        formData.append('image', fileInput);
        formData.append('recipe_name', $('#recipe_name').val());
        formData.append('category_name', $('#categorySelect').val());

        var ingredients = [];
        $('.ingredient-row').each(function() {
          var qty = $(this).find('.qty-input').val();
          var title = $(this).find('.title-input').val();
          if (qty && title) {
            ingredients.push({ qty: qty, title: title });
          }
        });
        console.log("Ingredients:", ingredients); // Debugging

        formData.append('ingredients', JSON.stringify(ingredients));

        var instructions = [];
        $('.instruction-input').each(function() {
          var step = $(this).val();
          if (step) {
            instructions.push(step);
          }
        });
        console.log("Instructions:", instructions); // Debugging

        formData.append('instructions', JSON.stringify(instructions));

        // AJAX request to submit form data
        $.ajax({
          url: '../api/add_recipe.php',
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
          success: function(response) {
            console.log(response);
            alert("Recipe added successfully.");
            $('#modal1').modal('hide');
            $('#recipe_name').val('');
            $('#categorySelect').val('');
            $('.qty-input').val('');
            $('.title-input').val('');
            $('.instruction-input').val('');
            $('#image').val('');
            // Reset image preview to default
            $('.image-preview').attr('src', '../assets/img/questionmark.jpg');
          },
          error: function(xhr, status, error) {
            console.error(error);
          }
        });
      } else {
        alert("Please fill in all required fields.");
      }
    });

    // Update image preview when selecting a new image
    $('#image').change(function() {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('.image-preview').attr('src', e.target.result);
      }
      reader.readAsDataURL(this.files[0]);
    });

    var response; // Define response variable here

    $.ajax({
        url: '../api/fetch_recipes.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            response = data; // Assign response data to the variable
            if(response.status === 'success') {
                // Sort recipes by date_updated in descending order to display the most recent one first
                response.recipes.sort((a, b) => new Date(b.recipe_data.date_updated) - new Date(a.recipe_data.date_updated));

                renderRecipes(response.recipes); // Render all recipes initially
            } else {
                console.log(response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error fetching recipes:", error);
        }
    });

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
                                    <label class="fw-semibold">${recipe.recipe_data.posted_by_name}</label>
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
                                <button type="button" class="btn bg-none">
                                    <img src="../assets/img/bookmark.png" class="img-fluid" width="40px" title="Bookmark">
                                </button>`;
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

    // Function to filter recipes when the search image is clicked
    $('#searchbar').click(function() {
        var searchTerm = $('#search').val().toLowerCase(); // Get the search term from the input field and convert to lowercase

        // Filter recipes based on the search term
        var filteredRecipes = response.recipes.filter(function(recipe) {
            return recipe.recipe_data.recipe_name.toLowerCase().includes(searchTerm);
        });

        renderRecipes(filteredRecipes); // Render filtered recipes
    });

    function formatDate(dateString) {
        var date = new Date(dateString);
        var options = { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric' };
        return date.toLocaleDateString('en-US', options);
    }
  });
</script>





<div class="modal fade" id="modal2" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-5 shadow-lg">
      <div class="text-end p-3">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-3">
        <h3 class="text-center">JM's Recipe</h3>

        <hr>

        <div class="container my-3">
            <div class="d-flex justify-content-around">
              <div class="my-5">
                  <img src="../assets/img/default.png" class="img-fluid me-2 rounded-circle" width="50px">
              </div>
              <div class="w-100 rounded p-2">
                  <p>January 5, 2023 at 5:01pm</p>
                  
                  <h5 class="fw-bold">Juan Dela Cruz</h5>
  
                  <label>Thats amazing!</label>
              </div>

              <div class="text-center my-auto">
                  <img src="../assets/img/message.png" class="img-fluid">
                  <a href="#" class="fw-bold">Reply</a>
              </div>

            </div>

            <div class="d-flex justify-content-around">
                <div class="vr"></div>
                
                <div class="my-5">
                    <img src="../assets/img/default.png" class="img-fluid me-2 rounded-circle" width="50px">
                </div>
                <div class="rounded p-2">
                    <p>January 5, 2023 at 5:23pm</p>
                    
                    <h5 class="fw-bold">Jennifer Dizon</h5>
    
                    <label>I totally agree!</label>
                </div>

                <div class="text-center my-auto">
                    <img src="../assets/img/message.png" class="img-fluid"><br>
                    <a href="#" class="fw-bold">Reply</a>
                </div>
                
  
            </div>

        </div>

        <div class="d-flex justify-content-around">

            <input class="form-control w-100" type="text" placeholder="Write a comment…" aria-label="default input example">
            
            <a href=""><img src="../assets/img/send.svg" class="img-fluid ms-2" width="35px"></a>
            
        </div>

      </div>
      
    </div>
  </div>
</div>

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


