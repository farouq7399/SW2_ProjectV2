<?php
include('classes/DB.php');

 //to say once button pressed (create account button) then return our variables to the database
if (isset($_POST['createaccount'])) {
   $username=$_POST['username'];
   $password=$_POST['password'];
   $email=$_POST['email'];

 // to see if the username is doesnt exist or does

    if(!DB::query('SELECT username FROM users WHERE username=:username',array(':username' => $username ))){
// we said our username cant be more than 32 chars or less then 3 chars
    		if(strlen($username)>=3 && strlen($username) <= 32){
          //to say username cant have more than these things down there no special chars no nothing
				 if ((preg_match('/[a-zA-z0-9_]+/', $username))) {
           //to filter our email address
					 if(strlen($password)>= 6 && strlen($password) <=60){
             //our password must be less than 60 and more than 6 mix of numbers emails and special chars
					 	if(filter_var($email,FILTER_VALIDATE_EMAIL)){

      //now we see if email is a duplicate
           if (!DB::query('SELECT email FROM users WHERE email=:email',array(':email' => $email))) {



      //passwoed hash encrypts our password with the bcrypt type

  	DB::query('INSERT INTO users VALUES (\'\',:username,:password,:email)',array(':username'=>$username,':password'=>password_hash( $password,PASSWORD_BCRYPT),':email'=>$email));


                   echo "success!";
             }


             else {echo "email in use!";}


             }

            else
            {echo "invalid email";}

            }

          else{echo "Password Invalid ";}
				 }
         else{echo "invalid user name ";}
			}

      else{echo "invalid user name";}

    }

    else{echo "User Already Exists!";}
}

 ?>
<h1>REGISTER<h1>



  <form action="create-account.php" method="post">
<input type="text" name="username" value="" placeholder="Username ..."> <p />
<input type="password" name="password" value="" placeholder="Password ..."> <p />
<input type="email" name="email" value="" placeholder="Someone@somesite.com"> <p />
<input type="submit" name="createaccount" value="Create Account">

  </form>
