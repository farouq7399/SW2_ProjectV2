<?php
include('./classes/DB.php');
include('./classes/Login.php');


//i have to be logged in to change password
if (Login::isLoggedIn()) {
//when press change password button
    if (isset($_POST['changepassword'])) {
      //get what i typed in the form and access it to the database
      $oldpassword=$_POST['oldpassword'];
      $newpassword=$_POST['newpassword'];
      $newpasswordrepeat=$_POST['newpasswordrepeat'];
      //easier to handle more than username its unique
      $userid = Login::isLoggedIn();
      //first see if the password is correct
        if (password_verify($oldpassword, DB::query('SELECT password FROM users WHERE id=:userid', array(':userid'=>$userid))[0]['password'])){
           //see if the password repeated correctly
           if ($newpassword==$newpasswordrepeat) {
             //our normal pass constraint
              if(strlen($newpassword)>= 6 && strlen($newpassword) <=60){
                  //now we passed all the constraints now change the password
                 DB::query('UPDATE users SET password=:newpassword WHERE id=:userid',array(':newpassword'=>password_hash( $newpassword,PASSWORD_BCRYPT),':userid'=>$userid));
                   echo "Password changed successfully! ";
              }
           } else {
             echo "passwords dont match !";
           }
        }

        else {

          echo "Incorrect old password! ";
        }
    }


}

else {
      die('not logged in');
}
//normal form to test this 
?>
<h1>Change password</h1>
<form action="change-password.php" method="post">
  <input type="password" name="oldpassword" value="" placeholder="Current Password ..."><br /><p />
  <input type="password" name="newpassword" value="" placeholder="New Password ..."><br /><p />
  <input type="password" name="newpasswordrepeat" value="" placeholder="Repeat Password ..."><br /><p />
  <input type="submit" name="changepassword" value="Change Password">
</form>
