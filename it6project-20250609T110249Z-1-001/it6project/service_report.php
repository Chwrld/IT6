<?php
require_once 'handlers/service_report_handler.php';
require_once 'handlers/customer_handler.php';
require_once 'handlers/appliance_handler.php';
require_once 'handlers/staff_handler.php';
require_once 'handlers/parts_handler.php';

$service_report_handler = new ServiceReportHandler();
$customer_handler = new CustomerHandler();
$appliance_handler = new ApplianceHandler();
$staff_handler = new StaffHandler();
$parts_handler = new PartsHandler();

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create_report'])) {
        $report_id = $service_report_handler->createServiceReport(
            $_POST['customer'],
            $_POST['appliance'],
            $_POST['technician'],
            $_POST['date_in'],
            $_POST['service_type'],
            $_POST['complaint'],
            $_POST['parts'] ?? [],
            $_POST['quantities'] ?? []
        );
        
        if ($report_id) {
            echo "<script>alert('Service report created successfully');</script>";
        } else {
            echo "<script>alert('Error creating service report');</script>";
        }
    }
    
    if (isset($_POST['update_status'])) {
        $success = $service_report_handler->updateServiceReport(
            $_POST['report_id'],
            $_POST['status'],
            $_POST['date_repaired'],
            $_POST['date_delivered'],
            $_POST['cost']
        );
        
        if ($success) {
            echo "<script>alert('Service report updated successfully');</script>";
        } else {
            echo "<script>alert('Error updating service report');</script>";
        }
    }
}

// Get all customers for dropdown
$customers = $customer_handler->getAllCustomers();

// Get technicians for dropdown
$technicians = $staff_handler->getTechnicians();

// Get all parts for dropdown
$parts = $parts_handler->getAllParts();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Service Report</title>
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
                <li class="active"><a href="service_report.php"><i class="material-icons">description</i><span>Service report</span></a></li>
                <li><a href="parts.php"><i class="material-icons">build</i><span>Parts</span></a></li>
                <li><a href="transactions.php"><i class="material-icons">payment</i><span>Transactions</span></a></li>
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
                    <h4 class="page-title">Service Report</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Service</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Service Report</li>
                    </ol>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Service Report Form</h5>
                            </div>
                            <div class="card-body">
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <!-- First Row -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Customer</label>
                                                <select name="customer" class="form-control" required>
                                                    <option value="">Select Customer</option>
                                                    <?php
                                                    if ($customers->num_rows > 0) {
                                                        while($row = $customers->fetch_assoc()) {
                                                            echo "<option value='" . $row['CustomerID'] . "'>" . 
                                                                $row['FullName'] . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Appliance</label>
                                                <select name="appliance" class="form-control" required>
                                                    <option value="">Select Appliance</option>
                                                    <!-- Will be populated via AJAX -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Service Type</label>
                                                <select name="service_type" class="form-control" required>
                                                    <option value="">Select Service Type</option>
                                                    <option value="Repair">Repair</option>
                                                    <option value="Maintenance">Maintenance</option>
                                                    <option value="Installation">Installation</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Second Row -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="status" class="form-control" required>
                                                    <option value="">Select Status</option>
                                                    <option value="Pending">Pending</option>
                                                    <option value="In Progress">In Progress</option>
                                                    <option value="Completed">Completed</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Date IN</label>
                                                <input type="date" name="date_in" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Technician</label>
                                                <select name="technician" class="form-control" required>
                                                    <option value="">Select Technician</option>
                                                    <?php
                                                    if ($technicians->num_rows > 0) {
                                                        while($row = $technicians->fetch_assoc()) {
                                                            echo "<option value='" . $row['StaffID'] . "'>" . 
                                                                $row['First_name'] . " " . $row['Last_name'] . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Parts Selection Section -->
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <h5>Parts Used</h5>
                                            <div id="parts-container">
                                                <div class="row parts-row mb-2">
                                                    <div class="col-md-5">
                                                        <select name="parts[]" class="form-control part-select">
                                                            <option value="">Select Part</option>
                                                            <?php
                                                            if ($parts->num_rows > 0) {
                                                                while($row = $parts->fetch_assoc()) {
                                                                    echo "<option value='" . $row['PartID'] . "' data-price='" . $row['Price'] . "'>" . 
                                                                        $row['Part_No'] . " - " . $row['Description'] . " ($" . $row['Price'] . ")</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="number" name="quantities[]" class="form-control quantity-input" placeholder="Quantity" min="1">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control subtotal" readonly>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="button" class="btn btn-danger remove-part"><i class="material-icons">delete</i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-primary mt-2" id="add-part">
                                                <i class="material-icons">add</i> Add Part
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Complaint/Problem</label>
                                                <textarea name="complaint" class="form-control" rows="3" required></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Third Row -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Date Repaired</label>
                                                <input type="date" name="date_repaired" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Date Delivered</label>
                                                <input type="date" name="date_delivered" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Cost</label>
                                                <input type="number" name="cost" class="form-control" step="0.01">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form Actions -->
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <button type="button" class="btn btn-secondary">Cancel</button>
                                            <button type="submit" name="create_report" class="btn btn-success">Submit Report</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service Reports List -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Service Reports</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Report ID</th>
                                                <th>Customer</th>
                                                <th>Appliance</th>
                                                <th>Service Type</th>
                                                <th>Status</th>
                                                <th>Date In</th>
                                                <th>Date Repaired</th>
                                                <th>Cost</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $reports = $service_report_handler->getAllServiceReports();
                                            if ($reports->num_rows > 0) {
                                                while($row = $reports->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row["ReportID"] . "</td>";
                                                    echo "<td>" . $row["CustomerName"] . "</td>";
                                                    echo "<td>" . $row["ApplianceName"] . "</td>";
                                                    echo "<td>" . $row["Service_type"] . "</td>";
                                                    echo "<td>" . $row["Status"] . "</td>";
                                                    echo "<td>" . $row["Date_In"] . "</td>";
                                                    echo "<td>" . ($row["Date_Repaired"] ? $row["Date_Repaired"] : "-") . "</td>";
                                                    echo "<td>₱" . ($row["Cost"] ? number_format($row["Cost"], 2) : "0.00") . "</td>";
                                                    echo "<td>
                                                        <a href='#' class='edit-report' 
                                                            data-id='" . $row["ReportID"] . "'
                                                            data-toggle='modal' 
                                                            data-target='#editReportModal'>
                                                            <i class='material-icons'>edit</i>
                                                        </a>
                                                    </td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='9'>No service reports found</td></tr>";
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

            <!-- Edit Report Modal -->
            <div class="modal fade" id="editReportModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="modal-header">
                                <h4 class="modal-title">Update Service Report</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="report_id" id="edit_report_id">
                                <!-- Add form fields similar to the create form -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" id="edit_status" class="form-control" required>
                                                <option value="Pending">Pending</option>
                                                <option value="In Progress">In Progress</option>
                                                <option value="Completed">Completed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Cost</label>
                                            <input type="number" name="cost" id="edit_cost" class="form-control" step="0.01">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date Repaired</label>
                                            <input type="date" name="date_repaired" id="edit_date_repaired" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date Delivered</label>
                                            <input type="date" name="date_delivered" id="edit_date_delivered" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="update_status" class="btn btn-primary">Update</button>
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
        $(document).ready(function() {
            // Toggle Sidebar
            $(".xp-menubar").on('click',function() {
                $("#sidebar").toggleClass('active');
                $("#content").toggleClass('active');
            });

            // Customer Change Event
            $('select[name="customer"]').change(function() {
                var customerId = $(this).val();
                if(customerId) {
                    $.ajax({
                        url: 'handlers/get_customer_appliances.php',
                        type: 'POST',
                        data: {customer_id: customerId},
                        success: function(data) {
                            $('select[name="appliance"]').html(data);
                        }
                    });
                }
            });

            // Parts Management
            $('#add-part').click(function() {
                var newRow = $('.parts-row').first().clone();
                newRow.find('select').val('');
                newRow.find('input').val('');
                $('#parts-container').append(newRow);
            });

            $(document).on('click', '.remove-part', function() {
                if($('.parts-row').length > 1) {
                    $(this).closest('.parts-row').remove();
                }
            });

            $(document).on('change', '.part-select, .quantity-input', function() {
                var row = $(this).closest('.parts-row');
                var partSelect = row.find('.part-select');
                var quantity = row.find('.quantity-input').val();
                var price = partSelect.find(':selected').data('price');

                if(quantity && price) {
                    var subtotal = quantity * price;
                    row.find('.subtotal').val('$' + subtotal.toFixed(2));
                } else {
                    row.find('.subtotal').val('');
                }
            });

            // Set data for edit report modal
            $('.edit-report').click(function(){
                const reportId = $(this).data('id');
                $('#edit_report_id').val(reportId);
                
                // Load report details via AJAX
                $.ajax({
                    url: 'handlers/get_service_report.php',
                    type: 'GET',
                    data: { report_id: reportId },
                    dataType: 'json',
                    success: function(response) {
                        $('#edit_status').val(response.Status);
                        $('#edit_cost').val(response.Cost);
                        $('#edit_date_repaired').val(response.Date_Repaired);
                        $('#edit_date_delivered').val(response.Date_Delivered);
                    }
                });
            });
        });
    </script>
</body>
</html>