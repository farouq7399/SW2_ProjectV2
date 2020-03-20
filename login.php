<?php

include 'classes/DB.php';



if(isset($_POST['login'])){
  $username=$_POST['username'];
  $password=$_POST['password'];

  if (DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {

                if (password_verify($password, DB::query('SELECT password FROM users WHERE username=:username', array(':username'=>$username))[0]['password'])) {
                        echo 'Logged in!';
                } else {
                        echo 'Incorrect Password!';
                }

        } else {
                echo 'User not registered!';
        }
      }

 ?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login to your account</title>
  </head>
  <body>
      <h1>Login form</h1>
      <form class="" action="login.php" method="post">
          <input type="text" name="username" value=""><p/>
          <input type="password" name="password" value=""><p/>
          <input type="submit" name="login" value="login">
      </form>
  </body>
</html>
