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
        <div class="d-flex justify-content-around">

            <img src="../assets/img/search.png" class="img-fluid me-2" id ="searchbar" width="35px">
            
            <input class="form-control w-100 me-4" type="text" id="search" placeholder="Search.." aria-label="default input example">
            
            <img src="../assets/img/add.png" class="img-fluid me-3" id ="create_group" width="35px" title="Create Group">
            
            <img src="../assets/img/join.png" class="img-fluid me-3" id ="join_group" width="35px" title="Join Group">

            <img src="../assets/img/dismissal.png" class="img-fluid me-3" id ="visit_group" width="35px" title="Visit Group">

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
