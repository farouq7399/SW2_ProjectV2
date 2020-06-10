<?php
include('classes/DB.php');

if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {

                if (password_verify($password, DB::query('SELECT password FROM users WHERE username=:username', array(':username'=>$username))[0]['password'])) {
                        echo 'Logged in!';
                          header('Location: http://localhost/Version2-master/index.php');
                        $cstrong = True;
                        $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                        $user_id = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$username))[0]['id'];
                        DB::query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));
                        echo "success!";
                        setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                        setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);



                } else {
                        echo 'Incorrect Password!';
                }

        } else {
                echo 'User not registered!';
        }

}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/log_reg.css">
    <title>Sign in</title>
  </head>
  <body>
    <div id="emad-app">
      <div class="containers">
        <div class="left-container">
          <div class="content">
            <h2>Welcome Back!</h2>
            <h3>To keep connected with us, please login with your personal info.</h3><a href="create-account.php">
              <button type="submit">Sign up</button></a>
          </div>
        </div>
        <div class="right-container"><img class="logo" src="img/logo2.png" alt="Logo">
          <form action="login.php" method="post" @submit="validateForm">
            <h1>Sign in</h1>
            <div class="form-username">
              <input type="text" name="username" autocomplete="off" placeholder="Type Your Username" v-model="userName">
              <Label>Your Username</Label>
            </div>
            <div class="form-password">
              <input class="visible-input" :type="fieldType" autocomplete="off" name="password" placeholder="Type Your Password" v-model="password">
              <Label>Your Password</Label>
              <button class="visible-button" @click.prevent="switchField" @click="selected = !selected"><span v-if="!selected"><i class="fas fa-eye fa-s"></i></span><span v-else="selected"><i class="fas fa-eye-slash fa-s"></i></span></button>
            </div>
            <button class="send" type="submit" name="login" :disabled="!userName || !password"><span>Sign in</span></button><br><a class="forget" href="forgot-password.php">Forgot your email or password?</a>
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
