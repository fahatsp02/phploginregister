<?php 
$page_title = "Dashbord Page";
include('includes/header.php'); 
include('includes/navbar.php');
?>
<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
  header("location: login.php");
  exit;
}
?>
<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="card">
                    <div class="card-header">
                        <h4>User Dashbord</h4>
                    </div>
                    <div class="card-body">
                    
<div class="alert alert-success" role="alert">
  <h4 class="alert-heading">Welcome - <?php echo $_SESSION['email']?></h4>
  <p>Hello and welcome to my welcome page.</p>
  <hr>
  <p class="mb-0">Whenever you need to logout <a href="/loginform/logout.php"> Using this links</a></p>
                    </div>
                </div>
                

            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>