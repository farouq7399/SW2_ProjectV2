<?php

include 'classes/DB.php';



if(isset($_POST['login']))
{
  //we use our username or email and password to open access the site
  $username=$_POST['username'];
  $password=$_POST['password'];

     //now we access the database to verify our cardentinals
        if (DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username)))
         {
        //this if verifies our password to see if it matches the one in our database
            if (password_verify($password, DB::query('SELECT password FROM users WHERE username=:username', array(':username'=>$username))[0]['password']))
               {
                 //if matches echo logged in
                                echo 'Logged in!';
                                //random bytes as a token for cookies
                                //we cannot pass a true in function it has to be a variable
                                $cstrong=true;
                                //bintohex to change format our token and openssl creates random token
                                $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                                //echo $token ; we wont echo token anymore
                                #run query to get user id to use in next query
                                $user_id = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$username))[0]['id'];

                                //to insert token into the DB
                                //sha1 function hashes the token
                                DB::query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));
                                //social network id SNID then we pass the token without hashing then the current time then itll be valid for one week only
                                //'/' means its availble for any location
                                //null means availbe for any domain and any type of connection
                                setcookie("SNID",$token, time() + 60*60*24*7, '/', NULL ,TURE, TRUE);
                }
                //else its worng pass
              else  {  echo 'Incorrect Password!';  }
   //else its wrong username
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
