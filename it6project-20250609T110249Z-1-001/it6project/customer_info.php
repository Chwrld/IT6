<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Customers</title>
    <link rel="shortcut Icon" href="img/Repair.png" type="image/x-icon">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <?php
    require_once 'handlers/customer_handler.php';
    require_once 'handlers/appliance_handler.php';

    $customer_handler = new CustomerHandler();
    $appliance_handler = new ApplianceHandler();

    // Process form submissions
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Add new customer
        if (isset($_POST['add_customer'])) {
            if($customer_handler->addCustomer($_POST['first_name'], $_POST['last_name'], $_POST['address'], $_POST['phone_no'])) {
                echo "<script>alert('Customer added successfully');</script>";
            } else {
                echo "<script>alert('Error adding customer');</script>";
            }
        }

        // Update customer
        if (isset($_POST['edit_customer'])) {
            if($customer_handler->updateCustomer($_POST['customer_id'], $_POST['first_name'], $_POST['last_name'], $_POST['address'], $_POST['phone_no'])) {
                echo "<script>alert('Customer updated successfully');</script>";
            } else {
                echo "<script>alert('Error updating customer');</script>";
            }
        }

        // Delete customer
        if (isset($_POST['delete_customer'])) {
            if($customer_handler->deleteCustomer($_POST['customer_id'])) {
                echo "<script>alert('Customer deleted successfully');</script>";
            } else {
                echo "<script>alert('Error deleting customer');</script>";
            }
        }

        // Add new appliance
        if (isset($_POST['add_appliance'])) {
            if($appliance_handler->addAppliance(
                $_POST['customer_id'],
                $_POST['brand'],
                $_POST['product'],
                $_POST['model_no'],
                $_POST['serial_no'],
                $_POST['warranty_end'],
                $_POST['category'],
                $_POST['status']
            )) {
                echo "<script>alert('Appliance added successfully');</script>";
            } else {
                echo "<script>alert('Error adding appliance');</script>";
            }
        }

        // Update appliance
        if (isset($_POST['edit_appliance'])) {
            if($appliance_handler->updateAppliance(
                $_POST['appliance_id'],
                $_POST['brand'],
                $_POST['product'],
                $_POST['model_no'],
                $_POST['serial_no'],
                $_POST['warranty_end'],
                $_POST['category'],
                $_POST['status']
            )) {
                echo "<script>alert('Appliance updated successfully');</script>";
            } else {
                echo "<script>alert('Error updating appliance');</script>";
            }
        }

        // Delete appliance
        if (isset($_POST['delete_appliance'])) {
            if($appliance_handler->deleteAppliance($_POST['appliance_id'])) {
                echo "<script>alert('Appliance deleted successfully');</script>";
            } else {
                echo "<script>alert('Error deleting appliance');</script>";
            }
        }
    }

    // Get all customers
    $customers = $customer_handler->getAllCustomers();
    ?>

    <div class="wrapper">
        <div class="body-overlay"></div>

        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><img src="img/Repair.png" class="img-fluid"/><span>Repair Service</span></h3>
            </div>
            <ul class="list-unstyled components">
                <li><a href="home.php"><i class="material-icons">dashboard</i><span>Dashboard</span></a></li>
                <li class="active"><a href="customer_info.php"><i class="material-icons">people</i><span>Customer Info</span></a></li>
                <li><a href="service_report.php"><i class="material-icons">description</i><span>Service report</span></a></li>
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
                    <h4 class="page-title">Customers</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Service</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Customers</li>
                    </ol>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Manage Customers</h5>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addCustomerModal">
                                    <i class="material-icons">&#xE147;</i> Add New Customer
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Full Name</th>
                                                <th>Address</th>
                                                <th>Phone Number</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($customers->num_rows > 0) {
                                                while($row = $customers->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row["CustomerID"] . "</td>";
                                                    echo "<td>" . $row["FullName"] . "</td>";
                                                    echo "<td>" . $row["Address"] . "</td>";
                                                    echo "<td>" . $row["Phone_no"] . "</td>";
                                                    echo "<td>
                                                        <a href='#' class='view-appliances' data-id='" . $row["CustomerID"] . "' data-toggle='modal' data-target='#viewAppliancesModal'>
                                                            <i class='material-icons' data-toggle='tooltip' title='View Appliances'>devices_other</i>
                                                        </a>
                                                        <a href='#' class='edit-customer' data-id='" . $row["CustomerID"] . "' data-toggle='modal' data-target='#editCustomerModal'>
                                                            <i class='material-icons' data-toggle='tooltip' title='Edit'>&#xE254;</i>
                                                        </a>
                                                        <a href='#' class='delete-customer' data-id='" . $row["CustomerID"] . "' data-toggle='modal' data-target='#deleteCustomerModal'>
                                                            <i class='material-icons' data-toggle='tooltip' title='Delete'>&#xE872;</i>
                                                        </a>
                                                        <a href='#' class='add-appliance' data-id='" . $row["CustomerID"] . "' data-name='" . $row["FullName"] . "' data-toggle='modal' data-target='#addApplianceModal'>
                                                            <i class='material-icons' data-toggle='tooltip' title='Add Appliance'>add_circle</i>
                                                        </a>
                                                    </td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='5'>No customers found</td></tr>";
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
            
            <!-- Add Customer Modal -->
            <div class="modal fade" id="addCustomerModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="modal-header">
                                <h4 class="modal-title">Add Customer</h4>
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
                                    <label>Address</label>
                                    <textarea name="address" class="form-control" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="tel" name="phone_no" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="add_customer" class="btn btn-success">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Customer Modal -->
            <div class="modal fade" id="editCustomerModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="modal-header">
                                <h4 class="modal-title">Edit Customer</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="customer_id" id="edit_customer_id">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" id="edit_first_name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" id="edit_last_name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea name="address" id="edit_address" class="form-control" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="tel" name="phone_no" id="edit_phone_no" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="edit_customer" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Delete Customer Modal -->
            <div class="modal fade" id="deleteCustomerModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="modal-header">
                                <h4 class="modal-title">Delete Customer</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="customer_id" id="delete_customer_id">
                                <p>Are you sure you want to delete this customer?</p>
                                <p class="text-warning"><small>This action cannot be undone. All associated appliances will also be deleted.</small></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="delete_customer" class="btn btn-danger">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- View Appliances Modal -->
            <div class="modal fade" id="viewAppliancesModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Customer Appliances</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div id="appliances-container">
                                <!-- Appliances will be loaded here via AJAX -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Appliance Modal -->
            <div class="modal fade" id="addApplianceModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="modal-header">
                                <h4 class="modal-title">Add Appliance</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="customer_id" id="appliance_customer_id">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Customer</label>
                                            <input type="text" id="appliance_customer_name" class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Brand</label>
                                            <input type="text" name="brand" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Product</label>
                                            <input type="text" name="product" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Model Number</label>
                                            <input type="text" name="model_no" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Serial Number</label>
                                            <input type="text" name="serial_no" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Warranty End</label>
                                            <input type="date" name="warranty_end" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select name="category" class="form-control" required>
                                                <option value="">Select Category</option>
                                                <option value="Refrigerator">Refrigerator</option>
                                                <option value="Washing Machine">Washing Machine</option>
                                                <option value="Air Conditioner">Air Conditioner</option>
                                                <option value="Oven">Oven</option>
                                                <option value="Television">Television</option>
                                                <option value="Microwave">Microwave</option>
                                                <option value="Dishwasher">Dishwasher</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" class="form-control" required>
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                                <option value="Under Repair">Under Repair</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="add_appliance" class="btn btn-success">Add Appliance</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Appliance Modal -->
            <div class="modal fade" id="editApplianceModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="modal-header">
                                <h4 class="modal-title">Edit Appliance</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="appliance_id" id="edit_appliance_id">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Brand</label>
                                            <input type="text" name="brand" id="edit_brand" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Product</label>
                                            <input type="text" name="product" id="edit_product" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Model Number</label>
                                            <input type="text" name="model_no" id="edit_model_no" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Serial Number</label>
                                            <input type="text" name="serial_no" id="edit_serial_no" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Warranty End</label>
                                            <input type="date" name="warranty_end" id="edit_warranty_end" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select name="category" id="edit_category" class="form-control" required>
                                                <option value="">Select Category</option>
                                                <option value="Refrigerator">Refrigerator</option>
                                                <option value="Washing Machine">Washing Machine</option>
                                                <option value="Air Conditioner">Air Conditioner</option>
                                                <option value="Oven">Oven</option>
                                                <option value="Television">Television</option>
                                                <option value="Microwave">Microwave</option>
                                                <option value="Dishwasher">Dishwasher</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" id="edit_status" class="form-control" required>
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                                <option value="Under Repair">Under Repair</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="edit_appliance" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Delete Appliance Modal -->
            <div class="modal fade" id="deleteApplianceModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="modal-header">
                                <h4 class="modal-title">Delete Appliance</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="appliance_id" id="delete_appliance_id">
                                <p>Are you sure you want to delete this appliance?</p>
                                <p class="text-warning"><small>This action cannot be undone.</small></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="delete_appliance" class="btn btn-danger">Delete</button>
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

            // Set data for edit customer modal
            $('.edit-customer').click(function(){
                const customerId = $(this).data('id');
                
                // AJAX request to get customer details
                $.ajax({
                    url: 'handlers/get_customer.php',
                    type: 'GET',
                    data: { customer_id: customerId },
                    dataType: 'json',
                    success: function(response) {
                        $('#edit_customer_id').val(response.CustomerID);
                        $('#edit_first_name').val(response.First_name);
                        $('#edit_last_name').val(response.Last_name);
                        $('#edit_address').val(response.Address);
                        $('#edit_phone_no').val(response.Phone_no);
                    },
                    error: function() {
                        alert('Error loading customer details');
                    }
                });
            });

            // Set data for delete customer modal
            $('.delete-customer').click(function(){
                $('#delete_customer_id').val($(this).data('id'));
            });

            // Set data for add appliance modal
            $('.add-appliance').click(function(){
                $('#appliance_customer_id').val($(this).data('id'));
                $('#appliance_customer_name').val($(this).data('name'));
            });

            // View appliances functionality
            $('.view-appliances').click(function(){
                const customerId = $(this).data('id');
                
                // AJAX request to get customer's appliances
                $.ajax({
                    url: 'handlers/get_appliances.php',
                    type: 'GET',
                    data: { customer_id: customerId },
                    success: function(response) {
                        $('#appliances-container').html(response);
                        
                        // Set up event handlers for edit and delete appliance buttons
                        $('.edit-appliance-btn').click(function(){
                            $('#edit_appliance_id').val($(this).data('id'));
                            $('#edit_brand').val($(this).data('brand'));
                            $('#edit_product').val($(this).data('product'));
                            $('#edit_model_no').val($(this).data('model'));
                            $('#edit_serial_no').val($(this).data('serial'));
                            $('#edit_warranty_end').val($(this).data('warranty'));
                            $('#edit_category').val($(this).data('category'));
                            $('#edit_status').val($(this).data('status'));
                            
                            $('#viewAppliancesModal').modal('hide');
                            $('#editApplianceModal').modal('show');
                        });
                        
                        $('.delete-appliance-btn').click(function(){
                            $('#delete_appliance_id').val($(this).data('id'));
                            
                            $('#viewAppliancesModal').modal('hide');
                            $('#deleteApplianceModal').modal('show');
                        });
                    },
                    error: function() {
                        alert('Error loading appliances');
                    }
                });
            });
        });
    </script>
</body>
</html>