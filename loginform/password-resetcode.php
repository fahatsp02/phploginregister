<?php
session_start();
include('includes/dbcon.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require "vendor/autoload.php";

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

function send_password_reset($get_name,$get_email,$token)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail= new PHPMailer(true);                   //Enable verbose debug output
        $mail->isSMTP();      
                                              //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'fahatsp02@gmail.com';                     //SMTP username
        $mail->Password   = 'dqtp pqse yfxr fghp';                               //SMTP password
        $mail->SMTPSecure = "tls";            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('fahatsp02@gmail.com', $get_name);
        $mail->addAddress($get_email);     //Add a recipient
        
       
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Password Reset';
        $email_template = "
        <h2>You are receiving this mail beacause we recieved a passwowrd reset request for your account</h2>
        <br>
        <h5> Click on below link to reset your password</h5>
        <br>
        <a href='http://localhost/loginform/password-change.php?token=$token&email=$get_email'>link</a>";
        $mail->Body    = $email_template;
        
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}


if(isset($_POST['password_reset_link']))
{
    $email= mysqli_real_escape_string($conn, $_POST['email']);
    $token = md5(rand());

    $check_email = "SELECT email FROM users WHERE email='$email' LIMIT 1";
    $check_email_run = mysqli_query($conn, $check_email);
    if(mysqli_num_rows($check_email_run)>0){
        $row = mysqli_fetch_array($check_email_run);
        $get_name = $row['name'];
        $get_email = $row['email'];
        $update_token = "UPDATE users SET verify_tokan='$token' WHERE email ='$get_email' LIMIT 1";
        $update_token_run = mysqli_query($conn, $update_token);

        if($update_token_run){
            send_password_reset($get_name,$get_email,$token);
            $_SESSION['status'] = "We have emailed you a password reset link";
            header("Location: password-reset.php");
            exit(0);

        }else{ 
            $_SESSION['status'] = "Something went wrong #1";
            header("Location: password-reset.php");
            exit(0);
        }
        

    }else{
        $_SESSION['status'] = "No email found";
        header("Location: password-reset.php");
        exit(0);
    }
}

if(isset($_POST['password_update'])){
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $new_pass = mysqli_real_escape_string($conn,$_POST['new_pass']);
    $confirm_pass = mysqli_real_escape_string($conn,$_POST['confirm_pass']);

    $token = mysqli_real_escape_string($conn, $_POST['password_token']);

    if(!empty($token)){
        if(!empty($email) && !empty($new_pass) && !empty($confirm_pass)){

            //token valid or not
            $check_token = "SELECT verify_tokan FROM users WHERE verify_tokan='$token' LIMIT 1";
            $check_token_run = mysqli_query($conn, $check_token);

            if(mysqli_num_rows($check_token_run)>0){
                if($new_pass == $confirm_pass){
                    $update_pass = "UPDATE users SET password='$new_pass' WHERE verify_tokan='$token' LIMIT 1 ";
                    $update_pass_run = mysqli_query($conn,$update_pass);
                    if($update_pass_run){
                        $update_new_token = "UPDATE users SET password='$new_pass' WHERE verify_tokan='$token' LIMIT 1 ";
                        $update_new_token_run = mysqli_query($conn,$update_pass);
                        $_SESSION['status'] = "Password is succesfully updated!!";
                        header("Location: login.php");
                        exit(0);

                    }else{
                        $_SESSION['status'] = "Something Wrong !! Password is not updated.";
                header("Location: password-change.php?token=$token&email=$email");
                exit(0);


                    }

                }else{
                $_SESSION['status'] = "Password and confirm password do not match";
                header("Location: password-change.php?token=$token&email=$email");
                exit(0);

            }

            }else{
                $_SESSION['status'] = "Invalid token";
                header("Location: password-change.php?token=$token&email=$email");
                exit(0);

            }

        }
        else{
            $_SESSION['status'] = "All fields are mandatory";
            header("Location: password-change.php?token=$token&email=$email");
            exit(0);
    

        }

    }else{
        $_SESSION['status'] = "No token available";
        header("Location: password-reset.php");
        exit(0);

    }

}
