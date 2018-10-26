<?php

include('db.php');

session_start();

$message = '';

if(isset($_SESSION['user_id']))
{
 header('location:index.php');
}

if(isset($_POST["register"]))
{
 $username = trim($_POST["username"]);
 $password = trim($_POST["password"]);
 $check_query = "
 SELECT * FROM login 
 WHERE username = :username
 ";
 $statement = $connect->prepare($check_query);
 $check_data = array(
  ':username'  => $username
 );
 if($statement->execute($check_data)) 
 {
  if($statement->rowCount() > 0)
  {
   $message .= '<p><label>Username already taken</label></p>';
  }
  else
  {
   if(empty($username))
   {
    $message .= '<p><label>Username is required</label></p>';
   }
   if(empty($password))
   {
    $message .= '<p><label>Password is required</label></p>';
   }
   else
   {
    if($password != $_POST['confirm_password'])
    {
     $message .= '<p><label>Password not match</label></p>';
    }
   }
   if($message == '')
   {
    $data = array(
     ':username'  => $username,
     ':password'  => password_hash($password, PASSWORD_DEFAULT)
    );

    $query = "
    INSERT INTO login 
    (username, password) 
    VALUES (:username, :password)
    ";
    $statement = $connect->prepare($query);
    if($statement->execute($data))
    {
     $message = "<label>Registration Completed</label>";
    }
   }
  }
 }
}

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>MIZCHAT</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="script.js/jquery.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </head>
  <body>
 <div class="container">
   <br>
<h3 ><i class="fas fa-align-center"></i>My Own Chat System</h3>
<br/>   

<div class="panel panel-default">
<div class="panel-heading "><h3 style="text-align:center ">Sign Up To Mizchat</h3>
</div>

<div class="card">
  <div class="card-body">
  <div class="card-header">
    <h5>Mizchat</h5>
  </div>


<div class="panel-body">
<p class="text-monospace text-danger"></p>
<form method="post">
<div class="form-group text-uppercase">
<label for="name">Username</label>
<input type="text" name="username" class="form-control" required>
</div>
<form method="post">
<div class="form-group text-uppercase">
<label for="name">Password</label>
<input type="password" name="password" class="form-control" required>
</div>
<div class="form-group text-uppercase">
<label for="name">confirm Password</label>
<input type="password" name="confirm_password" class="form-control" required>
</div>
<div class="form-group">
       <input type="submit" name="register" class="btn btn-outline-warning btn pull-right text-uppercase" value="Register" />
      </div>
      <div align="center"><a href="login.php"><button type="button" class="btn btn-outline-info btn-sm">Login</a>
      </div>
</form>
</div>
</div>

 
 </div>
</div>

 </div>
   </body>
</html>
