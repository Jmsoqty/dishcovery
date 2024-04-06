<?php include '../api/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/png" href="../assets/img/logo.png">
<title>Dishcovery | History</title>

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
      <div class="container border border-1 rounded text-center mb-2">
            <h1>Transaction History</h1>
        </div>

        <div class="d-flex justify-content-around">

          <img src="../assets/img/search.png" class="img-fluid me-2" id="searchbar" width="35px">
          <input class="form-control w-100" type="text" id="search" placeholder="Search Transaction.." aria-label="default input example">


          </div>
    
      </div>

    <div class="container">
            <div class="row">
                <div class="col">
                    <table id="historyTable" class="table table-hover">
                        <thead class="thead-dark text-center">
                            <tr>
                                <th scope="col">Transaction ID</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Sent by</th>
                                <th scope="col">Sent to</th>
                                <th scope="col">Date & Time</th>
                            </tr>
                        </thead>
                        <tbody id="historyBody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

<script>
    function populateTable() {
        var email = '<?php echo $_SESSION['email']; ?>';

        $.ajax({
            url: '../api/fetch_transactions.php',
            type: 'POST',
            dataType: 'json',
            data: { email: email },
            success: function(data) {
                if (data.status === 'success') {
                    const historyBody = $('#historyBody');
                    historyBody.empty();

                    $.each(data, function(index, row) {
                        if (index !== 'status') {
                            const tr = $('<tr>').append(
                                $('<td class="text-center">').text(row.transaction_id),
                                $('<td class="text-center">').text(row.amount_php),
                                $('<td class="text-center">').text(row.sent_by),
                                $('<td class="text-center">').text(row.sent_to),
                                $('<td class="text-center">').text(row.date_sent)
                            );
                            historyBody.append(tr);
                        }
                    });
                } else {
                    $('#historyBody').html('<tr><td class="text-center" colspan="6">' + data.message + '</td></tr>');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error fetching data:', textStatus, errorThrown);
            }
        });
    }

    $(document).ready(function() {
        populateTable();

        $('#search').on('input', function() {
            var searchValue = $(this).val().toLowerCase();
            $('#historyBody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
            });
        });
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
