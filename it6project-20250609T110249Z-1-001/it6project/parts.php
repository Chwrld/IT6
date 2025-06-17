<?php
require_once 'handlers/parts_handler.php';

$parts_handler = new PartsHandler();

// Process form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add new part
    if (isset($_POST['add_part'])) {
        if($parts_handler->addPart(
            $_POST['part_no'],
            $_POST['description'],
            $_POST['price']
        )) {
            echo "<script>alert('Part added successfully');</script>";
        } else {
            echo "<script>alert('Error adding part');</script>";
        }
    }

    // Update part
    if (isset($_POST['edit_part'])) {
        if($parts_handler->updatePart(
            $_POST['part_id'],
            $_POST['part_no'],
            $_POST['description'],
            $_POST['price']
        )) {
            echo "<script>alert('Part updated successfully');</script>";
        } else {
            echo "<script>alert('Error updating part');</script>";
        }
    }

    // Delete part
    if (isset($_POST['delete_part'])) {
        if($parts_handler->deletePart($_POST['part_id'])) {
            echo "<script>alert('Part deleted successfully');</script>";
        } else {
            echo "<script>alert('Error deleting part');</script>";
        }
    }
}

// Get all parts
$parts = $parts_handler->getAllParts();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Parts - Repair Service</title>
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
                <li class="active"><a href="parts.php"><i class="material-icons">build</i><span>Parts</span></a></li>
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
                    <h4 class="page-title">Parts</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Service</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Parts</li>
                    </ol>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Manage Parts</h5>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addPartModal">
                                    <i class="material-icons">&#xE147;</i> Add New Part
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Part Number</th>
                                                <th>Description</th>
                                                <th>Price</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($parts->num_rows > 0) {
                                                while($row = $parts->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row["PartID"] . "</td>";
                                                    echo "<td>" . $row["Part_No"] . "</td>";
                                                    echo "<td>" . $row["Description"] . "</td>";
                                                    echo "<td>₱" . number_format($row["Price"], 2) . "</td>";
                                                    echo "<td>
                                                        <a href='#' class='edit-part' 
                                                            data-id='" . $row["PartID"] . "'
                                                            data-toggle='modal' 
                                                            data-target='#editPartModal'>
                                                            <i class='material-icons' data-toggle='tooltip' 
                                                            title='Edit'>&#xE254;</i>
                                                        </a>
                                                        <a href='#' class='delete-part' 
                                                            data-id='" . $row["PartID"] . "'
                                                            data-toggle='modal' 
                                                            data-target='#deletePartModal'>
                                                            <i class='material-icons' data-toggle='tooltip' 
                                                            title='Delete'>&#xE872;</i>
                                                        </a>
                                                    </td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='5'>No parts found</td></tr>";
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

            <!-- Add Part Modal -->
            <div class="modal fade" id="addPartModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="modal-header">
                                <h4 class="modal-title">Add New Part</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Part Number</label>
                                    <input type="text" name="part_no" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" rows="3" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="number" name="price" class="form-control" step="0.01" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="add_part" class="btn btn-success">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Part Modal -->
            <div class="modal fade" id="editPartModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="modal-header">
                                <h4 class="modal-title">Edit Part</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="part_id" id="edit_part_id">
                                <div class="form-group">
                                    <label>Part Number</label>
                                    <input type="text" name="part_no" id="edit_part_no" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" id="edit_description" class="form-control" rows="3" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="number" name="price" id="edit_price" class="form-control" step="0.01" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="edit_part" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Delete Part Modal -->
            <div class="modal fade" id="deletePartModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="modal-header">
                                <h4 class="modal-title">Delete Part</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="part_id" id="delete_part_id">
                                <p>Are you sure you want to delete this part?</p>
                                <p class="text-warning"><small>This action cannot be undone.</small></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="delete_part" class="btn btn-danger">Delete</button>
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

            // Set data for edit part modal
            $('.edit-part').click(function(){
                const partId = $(this).data('id');
                $('#edit_part_id').val(partId);
                
                // Load part details via AJAX
                $.ajax({
                    url: 'handlers/get_part.php',
                    type: 'GET',
                    data: { part_id: partId },
                    dataType: 'json',
                    success: function(response) {
                        $('#edit_part_no').val(response.Part_No);
                        $('#edit_description').val(response.Description);
                        $('#edit_price').val(response.Price);
                    }
                });
            });

            // Set data for delete part modal
            $('.delete-part').click(function(){
                $('#delete_part_id').val($(this).data('id'));
            });
        });
    </script>
</body>
</html>