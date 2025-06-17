<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Appliances - Repair Service</title>
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
    <li><a href="customer.php"><i class="material-icons">people</i><span>Customers</span></a></li>
    <li><a href="service_report.php"><i class="material-icons">description</i><span>Service report</span></a></li>
    <li class="active"><a href="appliances.php"><i class="material-icons">devices_other</i><span>Appliances</span></a></li>
    <li><a href="parts.php"><i class="material-icons">build</i><span>Parts</span></a></li>
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
    <h4 class="page-title">Appliances</h4>
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Service</a></li>
    <li class="breadcrumb-item active" aria-current="page">Appliances</li>
    </ol>
    </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
    <div class="row">
    <div class="col-md-12">
    <div class="card">
    <div class="card-header">
    <h5 class="card-title">Manage Appliances</h5>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addApplianceModal">
    <i class="material-icons">&#xE147;</i> Add New Appliance
    </button>
    </div>

    <div class="card-body">
    <div class="table-responsive">
    <table class="table table-striped">

    <thead>
    <tr>
    <th>ID</th>
    <th>Customer</th>
    <th>Brand</th>
    <th>Model No.</th>
    <th>Serial No.</th>
    <th>Category</th>
    <th>Warranty End</th>
    <th>Status</th>
    <th>Actions</th>
    </tr>
    </thead>
    <tbody>

    <!-- Sample Data -->
    <tr>
    <td>1</td>
    <td>John Doe</td>
    <td>Samsung</td>
    <td>RT34M5535BS</td>
    <td>SER123456</td>
    <td>Refrigerator</td>
    <td>2025-12-31</td>
    <td><span class="badge badge-success">Active</span></td>
    <td>

    <a href="#editApplianceModal" class="edit" data-toggle="modal">
    <i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i>
    </a>
    <a href="#deleteApplianceModal" class="delete" data-toggle="modal">
    <i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i>
    </a>
    </td>
    </tr>
    </tbody>
    </table>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>

    <!-- Add Appliance Modal -->
    <div class="modal fade" id="addApplianceModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">

    <form>
    <div class="modal-header">                               
    <h4 class="modal-title">Add Appliance</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>

    <div class="modal-body">
    <div class="row">
    <div class="col-md-6">
    <div class="form-group">
    <label>Search Customer</label>
    <select class="form-control" required>
    <option value="">Select Customer</option>
    <!-- Populate customers dynamically -->
    </select>
    </div>

    <div class="form-group">
    <label>Brand</label>
    <input type="text" class="form-control" required>
    </div>

    <div class="form-group">
    <label>Model Number</label>
    <input type="text" class="form-control" required>
    </div>
    </div>

    <div class="col-md-6">
    <div class="form-group">
    <label>Serial Number</label>
    <input type="text" class="form-control" required>
    </div>

    <div class="form-group">
    <label>Warranty End</label>
    <input type="date" class="form-control">
    </div>

    <div class="form-group">
    <label>Category</label>
    <select class="form-control" required>
    <option value="">Select Category</option>
    <option>Refrigerator</option>
    <option>Washing Machine</option>
    <option>Air Conditioner</option>
    <option>Oven</option>
    </select>
    </div>

    <div class="form-group">
    <label>Status</label>
    <select class="form-control" required>
    <option value="active">Active</option>
    <option value="inactive">Inactive</option>
    <option value="repairing">Under Repair</option>
    </select>
    </div>
    </div>
    </div>
    </div>

    <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-success">Add Appliance</button>
    </div>
    </form>
    </div>
    </div>
    </div>

   <!-- Edit Appliance Modal -->
<div id="editApplianceModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h4 class="modal-title">Edit Appliance</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Customer</label>
                        <input type="text" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Brand</label>
                        <input type="text" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Model Number</label>
                        <input type="text" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Serial Number</label>
                        <input type="text" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Category Appliance</label>
                        <input type="text" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Warranty End</label>
                        <input type="date" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <!-- Delete Modal -->
    <div class="modal fade" id="deleteApplianceModal">
    <div class="modal-dialog">
    <div class="modal-content">
    <form>
    <div class="modal-header">
    <h4 class="modal-title">Delete Appliance</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>

    <div class="modal-body">
    <p>Are you sure you want to delete this appliance?</p>
    <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>

    <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-danger">Delete</button>
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
            $(".xp-menubar").on('click',function(){
                $('#sidebar').toggleClass('active');
                $('#content').toggleClass('active');
            });
            
            $(".xp-menubar,.body-overlay").on('click',function(){
                $('#sidebar,.body-overlay').toggleClass('show-nav');
            });
        });
    </script>
    </body>
    </html>