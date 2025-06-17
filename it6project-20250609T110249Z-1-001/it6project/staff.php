<?php
require_once 'handlers/staff_handler.php';

$staff_handler = new StaffHandler();

// Process form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add new staff
    if (isset($_POST['add_staff'])) {
        if($staff_handler->addStaff(
            $_POST['first_name'],
            $_POST['last_name'],
            $_POST['role']
        )) {
            echo "<script>alert('Staff member added successfully');</script>";
        } else {
            echo "<script>alert('Error adding staff member');</script>";
        }
    }

    // Update staff
    if (isset($_POST['edit_staff'])) {
        if($staff_handler->updateStaff(
            $_POST['staff_id'],
            $_POST['first_name'],
            $_POST['last_name'],
            $_POST['role']
        )) {
            echo "<script>alert('Staff member updated successfully');</script>";
        } else {
            echo "<script>alert('Error updating staff member');</script>";
        }
    }

    // Delete staff
    if (isset($_POST['delete_staff'])) {
        if($staff_handler->deleteStaff($_POST['staff_id'])) {
            echo "<script>alert('Staff member deleted successfully');</script>";
        } else {
            echo "<script>alert('Error deleting staff member');</script>";
        }
    }
}

// Get all staff
$staff = $staff_handler->getAllStaff();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Staff Management</title>
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
                <li><a href="transactions.php"><i class="material-icons">payment</i><span>Transactions</span></a></li>
                <li class="active"><a href="staff.php"><i class="material-icons">engineering</i><span>Staff</span></a></li>
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
                    <h4 class="page-title">Staff Management</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Service</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Staff</li>
                    </ol>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Manage Staff</h5>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addStaffModal">
                                    <i class="material-icons">&#xE147;</i> Add New Staff
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Full Name</th>
                                                <th>Role</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($staff->num_rows > 0) {
                                                while($row = $staff->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row["StaffID"] . "</td>";
                                                    echo "<td>" . $row["FullName"] . "</td>";
                                                    echo "<td>" . $row["Role"] . "</td>";
                                                    echo "<td>
                                                        <a href='#' class='edit-staff' 
                                                            data-id='" . $row["StaffID"] . "'
                                                            data-toggle='modal' 
                                                            data-target='#editStaffModal'>
                                                            <i class='material-icons' data-toggle='tooltip' 
                                                            title='Edit'>&#xE254;</i>
                                                        </a>
                                                        <a href='#' class='delete-staff' 
                                                            data-id='" . $row["StaffID"] . "'
                                                            data-toggle='modal' 
                                                            data-target='#deleteStaffModal'>
                                                            <i class='material-icons' data-toggle='tooltip' 
                                                            title='Delete'>&#xE872;</i>
                                                        </a>
                                                    </td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='4'>No staff members found</td></tr>";
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

            <!-- Add Staff Modal -->
            <div class="modal fade" id="addStaffModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="modal-header">
                                <h4 class="modal-title">Add Staff Member</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Role</label>
                                    <select name="role" class="form-control" required>
                                        <option value="">Select Role</option>
                                        <option value="Technician">Technician</option>
                                        <option value="Cashier">Cashier</option>
                                        <option value="Manager">Manager</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="add_staff" class="btn btn-success">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Staff Modal -->
            <div class="modal fade" id="editStaffModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="modal-header">
                                <h4 class="modal-title">Edit Staff Member</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="staff_id" id="edit_staff_id">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" id="edit_first_name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" id="edit_last_name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Role</label>
                                    <select name="role" id="edit_role" class="form-control" required>
                                        <option value="">Select Role</option>
                                        <option value="Technician">Technician</option>
                                        <option value="Cashier">Cashier</option>
                                        <option value="Manager">Manager</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="edit_staff" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Delete Staff Modal -->
            <div class="modal fade" id="deleteStaffModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="modal-header">
                                <h4 class="modal-title">Delete Staff Member</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="staff_id" id="delete_staff_id">
                                <p>Are you sure you want to delete this staff member?</p>
                                <p class="text-warning"><small>This action cannot be undone.</small></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="delete_staff" class="btn btn-danger">Delete</button>
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

            // Set data for edit staff modal
            $('.edit-staff').click(function(){
                const staffId = $(this).data('id');
                $('#edit_staff_id').val(staffId);
                
                // Load staff details via AJAX
                $.ajax({
                    url: 'handlers/get_staff.php',
                    type: 'GET',
                    data: { staff_id: staffId },
                    dataType: 'json',
                    success: function(response) {
                        $('#edit_first_name').val(response.First_name);
                        $('#edit_last_name').val(response.Last_name);
                        $('#edit_role').val(response.Role);
                    }
                });
            });

            // Set data for delete staff modal
            $('.delete-staff').click(function(){
                $('#delete_staff_id').val($(this).data('id'));
            });
        });
    </script>
</body>
</html> 