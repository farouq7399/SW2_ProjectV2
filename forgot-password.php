<?php
include('./classes/DB.php');
if (isset($_POST['resetpassword'])) {
  //we cannot pass a true in function it has to be a variable
  $cstrong=true;
  //bintohex to change format our token and openssl creates random token
  $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
  $email=$_POST['email'];
  $user_id=DB::query('SELECT id FROM users WHERE email=:email' , array(':email'=>$email))[0]['id'];
DB::query('INSERT INTO password_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));
 echo "Email sent!";
 echo "</ br>";
 echo $token;
}
?>

<h1>Forgot Password</h1>
<form action="forgot-password.php" method="post">
  <input type="text" name="email" value="" placeholder="Email ..."><br /><p />
  <input type="submit" name="resetpassword" value="Reset password"><br /><p />
</form>
