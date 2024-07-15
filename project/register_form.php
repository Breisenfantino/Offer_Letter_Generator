<?php

@include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = $_POST['password'];
   $cpass = $_POST['cpassword'];

   if(strlen($pass) < 8){
      $error[] = 'Password must be at least 8 characters!';
   } else {
      $pass = md5($pass);
      $cpass = md5($cpass);
      $select = " SELECT * FROM user_form WHERE email = '$email'";

      $result = mysqli_query($conn, $select);

      if(mysqli_num_rows($result) > 0){
         $error[] = 'User already exists!';
      } else {
         if($pass != $cpass){
            $error[] = 'Passwords do not match!';
         } else {
            $insert = "INSERT INTO user_form(name, email, password) VALUES('$name','$email','$pass')";
            mysqli_query($conn, $insert);
            header('location:login_form.php');
         }
      }
   }
};

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register Form</title>
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Register</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text" name="name" required placeholder="Enter your name">
      <input type="email" name="email" required placeholder="Enter your email">
      <input type="password" name="password" required placeholder="Enter your password">
      <input type="password" name="cpassword" required placeholder="Confirm your password">
      <input type="submit" name="submit" value="Register now" class="form-btn">
      <p>Already have an account? <a href="login_form.php">Login now</a></p>
   </form>

</div>

</body>
</html>
