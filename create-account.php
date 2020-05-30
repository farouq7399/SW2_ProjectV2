<?php
include('classes/DB.php');

if (isset($_POST['createaccount'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        if (!DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {

                if (strlen($username) >= 3 && strlen($username) <= 32) {

                        if (preg_match('/[a-zA-Z0-9_]+/', $username)) {

                                if (strlen($password) >= 6 && strlen($password) <= 60) {

                                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                                if (!DB::query('SELECT email FROM users WHERE email=:email', array(':email'=>$email))) {

                                        DB::query('INSERT INTO users VALUES (\'\', :username, :password, :email, \'0\')', array(':username'=>$username, ':password'=>password_hash($password, PASSWORD_BCRYPT), ':email'=>$email));
                                        echo "Success!";
                                } else {
                                        echo 'Email in use!';
                                }
                        } else {
                                        echo 'Invalid email!';
                                }
                        } else {
                                echo 'Invalid password!';
                        }
                        } else {
                                echo 'Invalid username';
                        }
                } else {
                        echo 'Invalid username';
                }

        } else {
                echo 'User already exists!';
        }
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/log_reg.css">
    <title>Sign up</title>
  </head>
  <body>
    <div id="emad-app">
      <div class="containers">
        <div class="left-container"><img class="logo" src="img/logoWhite.png" alt="Logo">
          <div class="content">
            <h2>Hello, Friend!</h2>
            <h3>Enter your personal info, to start a journey with us.</h3><a href="html/loginPage.html">
              <button type="submit">Sign in</button></a>
          </div>
        </div>
        <div class="right-container">
          <form action="create-account.php" method="post" @submit="validateForm">
            <h1>Sign up</h1>
            <div class="form-email">
              <input type="text" name="email" autocomplete="off" placeholder="Type Your Email" v-model="email">
              <label>Your Email</label>
            </div>
            <div class="form-username">
              <input type="text" name="username" autocomplete="off" placeholder="Type Your Username" v-model="userName">
              <Label>Your Username</Label>
            </div>
            <div class="form-password">
              <input class="visible-input" :type="fieldType" autocomplete="off" name="password" placeholder="Type Your Password" v-model="password">
              <Label>Your Password</Label>
              <button class="visible-button" @click.prevent="switchField" @click="selected = !selected"><span v-if="!selected"><i class="fas fa-eye fa-s"></i></span><span v-else="selected"><i class="fas fa-eye-slash fa-s"></i></span></button>
            </div>
            <button class="send" type="submit" name="createaccount" :disabled="!userName || !password"><span>Sign up</span></button><br>
            <div class="error" v-for="error in formErrors">{{ error }}</div>
          </form>
        </div>
      </div>
    </div>
    <script src="js/vue.js"></script>
    <script src="js/website.js"></script>
    <script src="https://kit.fontawesome.com/5c514b09fd.js" crossorigin="anonymous"></script>
  </body>
</html>
