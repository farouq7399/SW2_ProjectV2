<?php

include 'classes/DB.php';



if(isset($_POST['login']))
{
  $username=$_POST['username'];
  $password=$_POST['password'];

        if (DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username)))
         {

            if (password_verify($password, DB::query('SELECT password FROM users WHERE username=:username', array(':username'=>$username))[0]['password']))
               {
                                echo 'Logged in!';
                                //random bytes as a token for cookies
                                $cstrong=true;
                                $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                                echo $token ;
                                #run query to get user id to use in next query
                                $user_id = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$username))[0]['id'];

                                #we need to store our roken in data base as every time it generate another one ...
                                DB::query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));
                                setcookie("SNID",$token,time()+60*60*24*7,'/',NULL,NULL,TRUE);
                }
              else  {  echo 'Incorrect Password!';  }

          }else {    echo 'User not registered!';  }
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
