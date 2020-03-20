<?php
include('classes/DB.php');


if (isset($_POST['createaccount'])) {
   $username=$_POST['username'];
   $password=$_POST['password'];
   $email=$_POST['email'];

    if(!DB::query('SELECT username FROM users WHERE username=:username',array(':username' => $username ))){

    		if(strlen($username)>=3 && strlen($username) <= 32){
				 if ((preg_match('/[a-zA-z0-9_]+/', $username))) {
					 if(filter_var($email,FILTER_VALIDATE_EMAIL)){
					 	if(strlen($password)>= 6 && strlen($password) <=60){

					 		DB::query('INSERT INTO users VALUES (\'\',:username,:password,:email)',array(':username'=>$username,':password'=>password_hash( $password,PASSWORD_BCRYPT),':email'=>$email));
					 	}else{echo "Password Invalid ";}

					   echo "Success!";
					}else{echo "invalid email";}
				 }else{echo "invalid user name ";}
			}else{echo "invalid user name";}

		}
		else{
			echo "User Already Exists!";
		}
}

 ?>
<h1>REGISTER<h1>



  <form action="create-account.php" method="post">
<input type="text" name="username" value="" placeholder="Username ..."> <p />
<input type="password" name="password" value="" placeholder="Password ..."> <p />
<input type="email" name="email" value="" placeholder="Someone@somesite.com"> <p />
<input type="submit" name="createaccount" value="Create Account">

  </form>
