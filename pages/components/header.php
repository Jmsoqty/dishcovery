<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://www.paypal.com/sdk/js?client-id=AdmiBfK5VjxEmoqpDviFGPWMnbRl2EBBvDCCoP0yrn_65PPWDcq8FLWE9AY_1E_3zH-W7nOGJHh0-wt3&currency=USD"></script>
<header class="app-header">
  <nav class="navbar navbar-expand-lg navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item d-block d-xl-none">
        <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
          <i class="ti ti-menu-2"></i>
        </a>
      </li>
    </ul>
    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
      <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
        <div class="btn-group" style="margin-right: 20px;">
        <!-- <a class="nav-link nav-icon-hover cursor-pointer" title="Notifications" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="../assets/img/notification.png" alt="Notification" width="25" height="25" class="rounded-circle">
          <span class="badge bg-danger position-absolute top-0 start-100 translate-middle p-1" style="font-size: 0.75rem;">5</span>
        </a> -->
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" style="max-height: 400px; width: 400px; overflow-y: auto;">
        <li>
            <div class="dropdown-item">
                <div class="notification-content" title="notification 1">
                    <h4 class="notification-title">Title</h4>
                    <h5 class="notification-body">Message</h5>
                    <h6 class="notification-date" style="text-align: right;">Date & Time</h6>
                </div>
            </div>
        </li>
        <hr class="my-1">
        <li>
            <div class="dropdown-item">
                <div class="notification-content" title="notification 2">
                    <h4 class="notification-title">Title</h4>
                    <h5 class="notification-body">Message</h5>
                    <h6 class="notification-date" style="text-align: right;">Date & Time</h6>
                </div>
            </div>
        </li>
        <hr class="my-1">
        <li>
            <div class="dropdown-item">
                <div class="notification-content" title="notification 3">
                    <h4 class="notification-title">Title</h4>
                    <h5 class="notification-body">Message</h5>
                    <h6 class="notification-date" style="text-align: right;">Date & Time</h6>
                </div>
            </div>
        </li>
        <hr class="my-1">
        <li>
            <div class="dropdown-item">
                <div class="notification-content" title="notification 4">
                    <h4 class="notification-title">Title</h4>
                    <h5 class="notification-body">Message</h5>
                    <h6 class="notification-date" style="text-align: right;">Date & Time</h6>
                </div>
            </div>
        </li>
        </ul>
      </div>

      <div class="btn-group" style="margin-right: 20px;">
        <?php
          $email = $_SESSION['email'];

          $sql = "SELECT name, username, email, prof_pic FROM tbl_users WHERE email = ?";
          $stmt = $conn->prepare($sql);

          if (!$stmt) {
              die("Prepare failed: " . $conn->error);
          }

          $stmt->bind_param("s", $email);
          $result = $stmt->execute();

          if (!$result) {
              die("Execute failed: " . $stmt->error);
          }

          $stmt->bind_result($fullname, $username, $email, $prof_picture);
          $stmt->fetch();
          $stmt->close();

          if ($prof_picture !== null) {
              $base64_image = base64_encode($prof_picture);
              $image_source = "data:image/png;base64," . $base64_image;
          } else {
              $image_source = "../assets/img/default.png";
          }
          ?>

          <a class="nav-link nav-icon-hover cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false" title="More Settings">
              <img src="<?php echo $image_source; ?>" alt="Logo" width="35" height="35" class="rounded-circle">
          </a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up">
          <li>
            <button class="d-flex align-items-center gap-2 dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#update-modal">
              <i class="ti ti-mail fs-6"></i>
              <p class="mb-0 fs-5" title="Profile">My Account</p>
            </button>
          </li>
          <li>
            <button class="d-flex align-items-center gap-2 dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#ewallet-modal">
              <i class="ti ti-wallet fs-6"></i>
              <p class="mb-0 fs-5" title="E-Wallet">E-Wallet</p>
            </button>
          </li>
          <li>
            <a href="../api/logout.php" title="Logout" class="btn btn-outline-primary mx-3 mt-2 d-block"><i class="ti ti-logout me-2"></i> Logout</a>
          </li>
        </ul>
      </div>
  </nav>
</header>
<!--  Header End -->

<div class="modal fade" id="update-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="update-modal-label">Update My Account</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="shadow border border-opacity-50 mt-2" style="width: 200px; height: 200px; margin: 0 auto; text-align: center; display: flex; align-items: center; justify-content: center;">
          <img src="<?php echo $image_source; ?>" style="width: 180px; height: 180px;" class="profile-image-preview">
        </div>
        <input type="file" name="profile_image" id="profile_image" accept="image/*" class="form-control form-control-sm mt-4 mb-3 profile-image-input">
        <div class="form-floating mb-3">
          <input type="text" class="form-control" name="fullname" id="fullname" value="">
          <label for="fullname">Full Name: <?php echo $fullname; ?></label>
        </div>
        <div class="form-floating mb-3">
          <input type="text" class="form-control" name="username" id="username" value="">
          <label for="username">Username: <?php echo $username; ?></label>
        </div>
        <div class="form-floating mb-3">
          <input type="email" class="form-control" id="email" name="email" value="">
          <label for="email">Email: <?php echo $email; ?></label>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" id="password" name="password" minlength="6">
          <label for="password">Password</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="ti ti-x fs-3"></i> Close</button>
        <button type="button" class="btn btn-primary" id="update-button"><i class="ti ti-edit fs-3"></i> Update</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="ewallet-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ewallet-modal-label">E-Wallet Balance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-floating mb-3">
                    <h1 class="text-center" name="balance" id="balance">$
                    <?php 
                    $current_balance = '0.00';

                    $sql = "SELECT ewallet_value FROM tbl_users WHERE email = '$email'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo $current_balance = $row['ewallet_value'];
                    }
                    ?></h1>
                    <label for="balance">Current Balance</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="payment" name="payment" step="0.01" min="1" max="100000" placeholder="Insert your desired amount">
                    <label for="payment">Top-up</label>
                </div>
                <div id="paypal-button-container-1"></div>
            </div>
        </div>
    </div>
</div>

<script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                var amount = $('#payment').val();
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
                return actions.order.capture().then(function(details) {
                    var amount = $('#payment').val();
                    var transactionId = data.orderID;
                    $.ajax({
                        type: "POST",
                        url: "../api/topup.php",
                        data: { 
                            payment: amount,
                            transaction_id: transactionId
                        },
                        success: function(response) {
                            alert('Top-up successful. Please reload the page.');
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
                alert('An error occurred, please try again later');
                console.error(err);
            }
        }).render('#paypal-button-container-1');
    </script>



<script>
$(document).ready(function() {
  $('.profile-image-input').on('change', function() {
    const file = this.files[0];
    const profileImagePreview = $('.profile-image-preview')[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        profileImagePreview.src = e.target.result;
      }
      reader.readAsDataURL(file);
    } else {
      profileImagePreview.src = '<?php echo $image_source; ?>';
    }
  });

  $('#update-button').on('click', function() {
    const fullname = $('#fullname').val();
    const profileImage = $('#profile_image').prop('files')[0];
    const username = $('#username').val();
    const email = $('#email').val();
    const password = $('#password').val();

    const formData = new FormData();
    formData.append('fullname', fullname);
    formData.append('profile_image', profileImage);
    formData.append('username', username);
    formData.append('email', email);
    formData.append('password', password);

    $.ajax({
      url: '../api/update_profile.php',
      type: 'POST',
      processData: false,
      contentType: false,
      data: formData,
      dataType: 'json',
      beforeSend: function() {
        // You can add loading spinner or any pre-processing here
      },
      success: function(data) {
        if (data.success) {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: data.message,
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: data.message,
          });
        }
      },
      error: function(error) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'An error occurred while processing your request.',
        });
        console.error('Error:', error);
      }
    });
  });
});
</script>

