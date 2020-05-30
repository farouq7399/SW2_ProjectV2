<?php
include('./classes/DB.php');

if (isset($_POST['resetpassword'])) {

        $cstrong = True;
        $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
        $email = $_POST['email'];
        $user_id = DB::query('SELECT id FROM users WHERE email=:email', array(':email'=>$email))[0]['id'];
        DB::query('INSERT INTO password_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));
        echo 'Email sent!';
        echo '<br />';
        echo $token;
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <link rel="stylesheet" href="css/log_reg.css" />
    <title>Reset Password</title>
  </head>
  <body>
    <div id="emad-app">
      <div class="containers">
        <div class="left-container">
          <img class="logo" src="img/logoWhite.png" alt="Logo" />
          <div class="content">
            <h2>Forgot Password?</h2>
            <h3>
              Don't worry, enter your email and we will send you mail to reset
              it.
            </h3>
            <a href="html/loginPage.html">
              <button type="submit" name="resetpassword">Back to sign in page</button></a
            >
          </div>
        </div>
        <div class="right-container">
          <form action="forgot-password.php" method="post" @submit.prevent="validateReset">
            <h1>Reset password</h1>
            <div class="form-email">
              <input
                type="text"
                name="email"
                autocomplete="off"
                placeholder="Type Your Email"
                v-model="email"
              />
              <label>Your Email</label>
            </div>
            <button class="send" type="submit" :disabled="!email">
              <span>Reset password</span>
            </button>
            <div class="error" v-for="error in formErrors">{{ error }}</div>
          </form>
        </div>
      </div>
    </div>
    <script src="js/vue.js"></script>
    <script src="js/website.js"></script>
    <script
      src="https://kit.fontawesome.com/5c514b09fd.js"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
