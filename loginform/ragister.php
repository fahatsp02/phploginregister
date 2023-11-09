<?php 
$page_title = "Registration Form";
include('includes/header.php'); 
include('includes/navbar.php');
?>
<?php
$showAlert = false;
$showError= false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
include('includes/dbcon.php');
$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];
$exists=false;
if(($password == $confirm_password) && $exists==false){
    $sql ="INSERT INTO `users` (`name`, `email`, `password`, `verify_tokan`, `created_at`) VALUES 
    ('$name', '$email', '$password', 'verify_tokan',CURRENT_TIMESTAMP())";
    $result = mysqli_query($conn, $sql);
    if($result){
        $showAlert = true;
    }
  }
    else{
      $showError = "Password do not match";
    }


}
?>
<?php
if($showAlert){
echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Your account is created and you can login.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
}
if($showError){
  echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong>'.$showError.'
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
  }
?>
<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Registration form</h5>
                    </div>
                    <div class="card-body">
                        <form action="ragister.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="">Name</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group  mb-3">
                                <label for="">Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="form-group  mb-3">
                                <label for="">Password</label>
                                <input type="text" name="password" class="form-control">
                            </div>
                            <div class="form-group  mb-3">
                                <label for="">Confirm Password</label>
                                <input type="text" name="confirm_password" class="form-control">
                            </div>
                            <div class="form-group">
                                <button type="submit" name="register_btn" class="btn btn-primary">Register</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>