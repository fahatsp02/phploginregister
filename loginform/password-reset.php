<?php
session_start();

$page_title = "Password Reset Form";
include('includes/header.php'); 
include('includes/navbar.php');
?>
<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

            <?php
            if(isset($_SESSION['status']))
            {
                ?>
                <div class="alart alart-success">
                    <h5><?= $_SESSION['status'];?></h5>
                </div>
                <?php 
                unset($_SESSION['status']);
            }
        ?>

                <div class="card">
                    <div class="card-header">
                        <h5>Reset Password</h5>
                    </div>
                    <div class="card-body">
                        <form action="password-resetcode.php" method="post">
                            <div class="form-group  mb-3">
                                <label for="">Email</label>
                                <input type="text" name="email" class="form-control" placeholder="Enter your Email">
                            </div>
                            <div class="form-group">
                                <button type="submit" name="password_reset_link" class="btn btn-primary">Send Password Reset Link</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>