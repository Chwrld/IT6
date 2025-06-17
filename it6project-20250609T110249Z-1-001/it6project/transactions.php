<?php
require_once 'handlers/transaction_handler.php';
require_once 'handlers/customer_handler.php';
require_once 'handlers/staff_handler.php';

$transaction_handler = new TransactionHandler();
$customer_handler = new CustomerHandler();
$staff_handler = new StaffHandler();

// Process payment update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_payment'])) {
    if($transaction_handler->updatePaymentStatus(
        $_POST['transaction_id'],
        $_POST['payment_status'],
        $_POST['received_by']
    )) {
        echo "<script>alert('Payment status updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating payment status');</script>";
    }
}

// Get all transactions
$transactions = $transaction_handler->getAllTransactions();

// Get all staff for dropdown
$staff = $staff_handler->getAllStaff();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Transactions</title>
    <link rel="shortcut Icon" href="img/Repair.png" type="image/x-icon">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <div class="body-overlay"></div>

        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><img src="img/Repair.png" class="img-fluid"/><span>Repair Service</span></h3>
            </div>
            <ul class="list-unstyled components">
                <li><a href="home.php"><i class="material-icons">dashboard</i><span>Dashboard</span></a></li>
                <li><a href="customer_info.php"><i class="material-icons">people</i><span>Customer Info</span></a></li>
                <li><a href="service_report.php"><i class="material-icons">description</i><span>Service report</span></a></li>
                <li><a href="parts.php"><i class="material-icons">build</i><span>Parts</span></a></li>
                <li class="active"><a href="transactions.php"><i class="material-icons">payment</i><span>Transactions</span></a></li>
                <li><a href="staff.php"><i class="material-icons">engineering</i><span>Staff</span></a></li>
            </ul>
        </nav>

        <div id="content">
            <!-- Top Navbar -->
            <div class="top-navbar">
                <div class="xp-topbar">
                    <div class="row"> 
                        <div class="col-2 col-md-1 col-lg-1 order-2 order-md-1 align-self-center">
                            <div class="xp-menubar">
                                <span class="material-icons text-white">signal_cellular_alt</span>
                            </div>
                        </div>
                        <div class="col-md-5 col-lg-3 order-3 order-md-2">
                            <div class="xp-searchbar">
                                <form>
                                    <div class="input-group">
                                        <input type="search" class="form-control" placeholder="Search">
                                        <div class="input-group-append">
                                            <button class="btn" type="submit" id="button-addon2">GO</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="xp-breadcrumbbar text-center">
                    <h4 class="page-title">Transactions</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Service</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Transactions</li>
                    </ol>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Transaction List</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Transaction ID</th>
                                                <th>Customer</th>
                                                <th>Appliance</th>
                                                <th>Parts Total</th>
                                                <th>Labor Total</th>
                                                <th>Total Amount</th>
                                                <th>Payment Status</th>
                                                <th>Payment Date</th>
                                                <th>Received By</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($transactions->num_rows > 0) {
                                                while($row = $transactions->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row["TransactionID"] . "</td>";
                                                    echo "<td>" . $row["CustomerName"] . "</td>";
                                                    echo "<td>" . $row["ApplianceName"] . "</td>";
                                                    echo "<td>₱" . number_format($row["Parts_Total"], 2) . "</td>";
                                                    echo "<td>₱" . number_format($row["Labor_Total"], 2) . "</td>";
                                                    echo "<td>₱" . number_format($row["Total_Amount"], 2) . "</td>";
                                                    echo "<td>" . $row["Payment_Status"] . "</td>";
                                                    echo "<td>" . ($row["Payment_Date"] ? $row["Payment_Date"] : "-") . "</td>";
                                                    echo "<td>" . ($row["StaffName"] ? $row["StaffName"] : "-") . "</td>";
                                                    echo "<td>";
                                                    if($row["Payment_Status"] == "Pending") {
                                                        echo "<a href='#' class='update-payment' 
                                                            data-id='" . $row["TransactionID"] . "'
                                                            data-toggle='modal' 
                                                            data-target='#updatePaymentModal'>
                                                            <i class='material-icons' data-toggle='tooltip' 
                                                            title='Update Payment'>payment</i>
                                                        </a>";
                                                    }
                                                    echo "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='10'>No transactions found</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Payment Modal -->
            <div class="modal fade" id="updatePaymentModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="modal-header">
                                <h4 class="modal-title">Update Payment Status</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="transaction_id" id="update_transaction_id">
                                <div class="form-group">
                                    <label>Payment Status</label>
                                    <select name="payment_status" class="form-control" required>
                                        <option value="Paid">Paid</option>
                                        <option value="Pending">Pending</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Received By</label>
                                    <select name="received_by" class="form-control" required>
                                        <option value="">Select Staff</option>
                                        <?php
                                        if ($staff->num_rows > 0) {
                                            while($row = $staff->fetch_assoc()) {
                                                echo "<option value='" . $row['StaffID'] . "'>" . 
                                                    $row['FullName'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="update_payment" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="footer-in">
                        <p class="mb-0">2025 Repair Service - Ranes, Angelo C., Palen, Andrew E., Omega, Angel Andrea B.</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/jquery-3.3.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            // Toggle sidebar
            $(".xp-menubar").on('click',function(){
                $('#sidebar').toggleClass('active');
                $('#content').toggleClass('active');
            });
            
            $(".xp-menubar,.body-overlay").on('click',function(){
                $('#sidebar,.body-overlay').toggleClass('show-nav');
            });

            // Set transaction ID for payment update
            $('.update-payment').click(function(){
                $('#update_transaction_id').val($(this).data('id'));
            });
        });
    </script>
</body>
</html> 