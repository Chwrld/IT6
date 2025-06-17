<?php
require_once 'handlers/transaction_handler.php';
require_once 'handlers/service_report_handler.php';

$transaction_handler = new TransactionHandler();
$service_report_handler = new ServiceReportHandler();

// Get transactions
$transactions = $transaction_handler->getAllTransactions();
$pending_transactions = $transaction_handler->getPendingTransactions();

// Calculate totals
$total_earnings = 0;
$pending_amount = 0;
$completed_repairs = 0;
$pending_repairs = 0;

if ($transactions->num_rows > 0) {
    while($row = $transactions->fetch_assoc()) {
        if ($row['Payment_Status'] == 'Paid') {
            $total_earnings += $row['Total_Amount'];
        } else {
            $pending_amount += $row['Total_Amount'];
        }
    }
}

// Get service reports for counts
$service_reports = $service_report_handler->getAllServiceReports();
if ($service_reports->num_rows > 0) {
    while($row = $service_reports->fetch_assoc()) {
        if ($row['Status'] == 'Completed') {
            $completed_repairs++;
        } else if ($row['Status'] == 'Pending') {
            $pending_repairs++;
        }
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <title>Dashboard</title>
        <link rel="shortcut Icon" href="img/Repair.png" type="image/x-icon">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/custom.css">	
	      <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Icons"rel="stylesheet">
        </head>
        <body>
  
        <div class="wrapper">
        <div class="body-overlay"></div>
		

		     <!-- Sidebar  -->
        <nav id="sidebar">
        <div class="sidebar-header">
        <h3><img src="img/Repair.png" class="img-fluid"/><span>Repair Service</span></h3>
        </div>

        <ul class="list-unstyled components">
        <li  class="active">
        <a href="home.php" class="dashboard"><i class="material-icons">dashboard</i>
		    <span>Dashboard</span></a>
        </li>

        <ul class="list-unstyled components">
        <li><a href="customer_info.php" class="Service report"><i class="material-icons">people</i>
        <span>Customer Info</span></a>
        </li></ul>
		
        <ul class="list-unstyled components">
        <li><a href="service_report.php" class="Service report"><i class="material-icons">description</i>
		    <span>Service report</span></a>
        </li></ul>
         

        <ul class="list-unstyled components">
        <li><a href="parts.php" class="Service report"><i class="material-icons">build</i>
        <span>Parts</span></a>
        </li></ul>

        <li>
            <a href="transactions.php"><i class="material-icons">payment</i><span>Transactions</span></a>
        </li>

        <li><a href="staff.php"><i class="material-icons">engineering</i><span>Staff</span></a></li>
        </nav>
		
		    <!--------page-content---------------->
        

		    <!--top--navbar----design--------->
        <div id="content">
		    <div class="top-navbar">
		    <div class="xp-topbar"> 

        <!-- Start XP Row -->
        <div class="row"> 

        <!-- Start XP Col -->
        <div class="col-2 col-md-1 col-lg-1 order-2 order-md-1 align-self-center">
        <div class="xp-menubar">
        <span class="material-icons text-white">signal_cellular_alt</span>
        </div></div> 
        <!-- End XP Col -->

        <!-- Start XP Col -->
        <div class="col-md-5 col-lg-3 order-3 order-md-2">
        <div class="xp-searchbar">
        <form>
        <div class="input-group">
        <input type="search" class="form-control"placeholder="Search">
        <div class="input-group-append">
        <button class="btn" type="submit" 
				id="button-addon2">GO</button>
        </div>
        </div>
        </form>
        </div>
        </div>      
        </div> 
        </div>

        <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Dashboard</h4>  
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Service</a></li>
        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>                
        </div>			
		    </div>
		   
		    <!--------main-content------------->
		    <div class="main-content">
        <div class="row">
            
        <div class="col-md-12">
        <div class="table-wrapper">
        <div class="table-title">
        <div class="row">
        <div class="col-sm-6 p-0 d-flex justify-content-lg-start justify-content-center">
        <h2 class="ml-lg-2">Manage Reports</h2>
        </div>

        <div class="col-sm-6 p-0 d-flex justify-content-lg-end justify-content-center">
        <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal">
        <i class="material-icons">&#xE147;</i> <span>Add New Employee</span></a>
        <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal">
        <i class="material-icons">&#xE15C;</i> <span>Delete</span></a>
        </div>
        </div>
        </div>

        <table class="table table-striped table-hover">
        <thead>
        <tr>
        <th>
        <span class="custom-checkbox">
        <input type="checkbox" id="selectAll">
        <label for="selectAll"></label>
        </span>
        </th>

        <th>Name</th>
        <th>Appliances</th>
        <th>Address</th>
        <th>Phone Number</th>
        <th>Parts used</th>
        <th>Labor Cost</th>
        <th>Total Parts</th>
        <th>Total Amount</th>
        <th>Actions</th>
        </tr>
        </thead>

        <tbody>
        <tr>
        <td>
        <span class="custom-checkbox">
        <input type="checkbox" id="checkbox1" name="options[]" value="1">
        <label for="checkbox1"></label>
        </span>
        </td>

        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
        <a href="#editEmployeeModal" class="edit" data-toggle="modal">
        <i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
        <a href="#deleteEmployeeModal" class="delete" data-toggle="modal">
        <i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
        </td>
        </tr>

        <tr>
        <td>
        <span class="custom-checkbox">
        <input type="checkbox" id="checkbox2" 
        name="options[]" value="1">
        <label for="checkbox2"></label>
        </span>
        </td>

        <td>Dominique Perrier</td>
        <td>Rice Cookers</td>
        <td>Obere Str. 57, Berlin, Germany</td>
        <td>(313) 555-5735</td>
        <td>(313) 555-5735</td>
        <td>P200.00</td>
        <td>P300.00</td>
        <td>P500.00</td>
        <td>
        <a href="#editEmployeeModal" class="edit" data-toggle="modal">
        <i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
        <a href="#deleteEmployeeModal" class="delete" data-toggle="modal">
        <i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
        </td>
        </tr>

        <tr>
        <td>
        <span class="custom-checkbox">
        <input type="checkbox" id="checkbox3"name="options[]" value="1">
        <label for="checkbox3"></label>
        </span>
        </td>

        <td>Maria Anders</td>
        <td>Washing Machines</td>
        <td>25, rue Lauriston, Paris, France</td>
        <td>(503) 555-9931</td>
        <td>(503) 555-9931</td>
        <td>P2000.00</td>
        <td>P3000.00</td>
        <td>P5000.00</td>
        <td>
        <a href="#editEmployeeModal" class="edit" data-toggle="modal">
        <i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
        <a href="#deleteEmployeeModal" class="delete" data-toggle="modal">
        <i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
        </td>
        </tr>

        <tr>
        <td>
        <span class="custom-checkbox">
			  <input type="checkbox" id="checkbox4" name="options[]" value="1">
	      <label for="checkbox4"></label>
			  </span>
        </td>

        <td>Fran Wilson</td>
        <td>Air Conditioner</td>
        <td>C/ Araquil, 67, Madrid, Spain</td>
        <td>(204) 619-5731</td>
        <td>(204) 619-5731</td>
        <td>P200.00</td>
        <td>P1000.00</td>
        <td>P1200.00</td>
        <td>
        <a href="#editEmployeeModal" class="edit" data-toggle="modal">
			  <i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
        <a href="#deleteEmployeeModal" class="delete" data-toggle="modal">
			  <i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
        </td>
        </tr>

        <tr>
        <td>
        <span class="custom-checkbox">
			  <input type="checkbox" id="checkbox5" 
			  name="options[]" value="1">
			  <label for="checkbox5"></label>
			  </span>
        </td>

        <td>Martin Blank</td>
        <td>Electric Fans</td>
        <td>Via Monte Bianco 34, Turin, Italy</td>
        <td>(480) 631-2097</td>
        <td>(480) 631-2097</td>
        <td>P2000.00</td>
        <td>P1000.00</td>
        <td>P3000.00</td>

        <td>
        <a href="#editEmployeeModal" class="edit" data-toggle="modal">
		  	<i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
        <a href="#deleteEmployeeModal" class="delete" data-toggle="modal">
			  <i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
        </td>
        </tr>
        </tbody>
        </table>

        <div class="clearfix">
        <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
        <ul class="pagination">
        <li class="page-item disabled"><a href="#">Previous</a></li>
        <li class="page-item active"><a href="#" class="page-link">1</a></li>
        <li class="page-item"><a href="#" class="page-link">2</a></li>
        <li class="page-item"><a href="#" class="page-link">3</a></li>
        <li class="page-item"><a href="#" class="page-link">4</a></li>
        <li class="page-item"><a href="#" class="page-link">5</a></li>
        <li class="page-item"><a href="#" class="page-link">Next</a></li>
        </ul>
        </div>
        </div>
        </div>

        <!-- Edit Modal HTML -->
        <div id="addEmployeeModal" class="modal fade">
        <div class="modal-dialog">
        <div class="modal-content">
        <form>
        <div class="modal-header">
        <h4 class="modal-title">Add Employee</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>

        <div class="modal-body">
        <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" required>
        </div>

        <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control" required>
        </div>

        <div class="form-group">
        <label>Address</label>
        <textarea class="form-control" required></textarea>
        </div>

        <div class="form-group">
        <label>Phone</label>
        <input type="text" class="form-control" required>
        </div>

        <div class="form-group">
        <label>Parts Used</label>
        <input type="text" class="form-control" required>
        </div>

        <div class="form-group">
        <label>Labor Cost</label>
        <input type="text" class="form-control" required>
        </div>

        <div class="form-group">
        <label>Total Parts</label>
        <input type="text" class="form-control" required>
        </div>

        <div class="form-group">
        <label>Total Amount</label>
        <input type="text" class="form-control" required>
        </div>

        </div>
        <div class="modal-footer">
        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
        <input type="submit" class="btn btn-success" value="Add">
        </div>
        </form>
        </div>
        </div>
        </div>

        <!-- Edit Modal HTML -->
        <div id="editEmployeeModal" class="modal fade">
        <div class="modal-dialog">
        <div class="modal-content">
        <form>
        <div class="modal-header">
        <h4 class="modal-title">Edit Employee</h4>
        <button type="button" class="close" data-dismiss="modal"aria-hidden="true">&times;</button>
        </div>

        <div class="modal-body">
        <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" required>
        </div>

        <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control" required>
        </div>

        <div class="form-group">
        <label>Address</label>
        <textarea class="form-control" required></textarea>
        </div>

        <div class="form-group">
        <label>Phone</label>
        <input type="text" class="form-control" required>
        </div>
        </div>

        <div class="modal-footer">
        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
        <input type="submit" class="btn btn-info" value="Save">
        </div>
        </form>
        </div>
        </div>
        </div>

        <!-- Delete Modal HTML -->
        <div id="deleteEmployeeModal" class="modal fade">
        <div class="modal-dialog">
        <div class="modal-content">
        <form>
        <div class="modal-header">
        <h4 class="modal-title">Delete Employee</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>

        <div class="modal-body">
        <p>Are you sure you want to delete these Records?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
        </div>

        <div class="modal-footer">
        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
        <input type="submit" class="btn btn-danger" value="Delete">
        </div>
        </form>
        </div>
	      </div>
        </div>
			  </div>
        </div>

			  <!---footer---->			 			 
		    <footer class="footer">
			  <div class="container-fluid">
				<div class="footer-in">
        <p class="mb-0">2025 Repair Service - Ranes, Angelo C., Palen, Andrew E., Omega, Angel Andrea B.</p>
        </div>
				</div>
			  </footer>
        </div>
        </div>
        <!----------html code compleate----------->
 
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
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


