<?php

include('./classes/DB.php');
include('./classes/Login.php');
//if we are not logged in kill the page
if (!Login::isLoggedIn()) {
  die("Not logged in.");
}


//if pressed log out
if (isset($_POST['confirm'])) {
  //if checked box logout from all devices
  if (isset($_POST['alldevices'])) {
    //then delete all the cookies 
      DB::query('DELETE FROM login_tokens WHERE user_id =:userid' , array(':userid'=>Login::isLoggedIn()));
  }
//log out from the current device only then delete temp cookie
  else {
    if(isset($_COOKIE['SNID'])){
      //if we want to logout just access the database and delete the cookie if exists
    DB::query('DELETE FROM login_tokens WHERE token =:token' , array(':token'=>sha1($_COOKIE['SNID'])));
  }
  //now we kinda deleting the cookie by setting it to a time that already passed
  setcookie('SNID','1',time()-3600);
  //do the same with out temp cookie
  setcookie('SNID_','1',time()-3600);
 }
}

 ?>

<h1>Log Out </h1>
<form action="logout.php" method="post">
  <input type="checkbox" name="alldevices" value="alldevices"> Log out of all devices?<br /><p />
  <input type="submit" name="confirm" value="Confirm">
</form>
